<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Reservation;
use App\Models\Rental;
use App\Http\Controllers\Controller;
use App\Repositories\ReservationRepository;
use App\Repositories\BikeRepository;

use DateTime;

class ReservationController extends Controller
{
    protected $repoReservation;
    protected $repoBike;

    public function __construct(ReservationRepository $repoReservation, BikeRepository $repoBike)
    {
        $this->repoReservation = $repoReservation;    
        $this->repoBike = $repoBike;        
    }

    public function index(Request $request) {
        $limit = 8;
        $page = (int) $request->input('page', 1);    
        $sort = $request->input('sort', 'desc');
        $filter = $request->input('filter', 'all');
        $offset = ($page - 1) * $limit;
        
        if(!session()->has('userId')) {
            return redirect()->route('login');
        }

        if(session('role') === 4) {
            //cliente
            $idUser = session('userId');
        } else {
            $idUser = 0;
        }

        $reservation = $this->repoReservation->getReservation($offset, $limit, $sort, $idUser, $filter);
        $total = $this->repoReservation->countReservation($idUser, $filter);
        $totalPages = ceil($total / $limit);
        $currentPage = $page;

        if ($request->ajax()) {
            return response()->json([
                'html' => view('reservation.tableReservation', compact('reservation'))->render(),
                'pagination' => view('_partials.pagination', compact('currentPage', 'totalPages'))->render()
            ]);
        }

        return view('reservation.index', ['page' => $page, 'limit' => $limit, 'reservation' => $reservation, 'totalPages' => $totalPages, 'currentPage' => $currentPage]);
    }

    public function checkout(Request $request) {
        if(!session()->has('userId')) {
            return redirect()->route('login');   
        }
    
        $cart = session('cart', []);
        $totalCartPrice = 0;

        if (empty($cart)) {
            return redirect()->route('reservation')->with('success', false);
        }

        try {
            $cartWithPrices = [];

            foreach ($cart as $item) {
                if (!$this->repoBike->isBikeAvailable($item['bikeId'], $item['startDate'], $item['endDate'])) {
                    return redirect()->route('reservation')->with('success', false);
                }
                
                $bike = $this->repoBike->getBikeById($item['bikeId']);

                if (!$bike) {
                    return redirect()->route('reservation')->with('success', false);
                }

                //$itemPrice = $this->calculateItemPrice($bike, $item['startDate'], $item['endDate']);
                $itemPrice = $bike->calculatePrice($item['startDate'], $item['endDate']);

                $cartWithPrices[] = [
                    'bikeId' => $item['bikeId'],
                    'startDate' => $item['startDate'],
                    'endDate' => $item['endDate'],
                    'price' => $itemPrice
                ];
            }

            foreach ($cartWithPrices as $item) {
                $reservation = new Reservation(0, session('userId'), $item['bikeId'], $item['startDate'], $item['endDate'], $item['price'], 1);
                $this->repoReservation->createReservation($reservation);
            }

            session()->forget('cart');

            return redirect()->route('reservation')->with('success', true);

        } catch (\Exception $e) {
            return redirect()->route('reservation')->with('success', false);
        }
    }

    public function cancelReservation(Request $request) {
        if (session('role') != 1 && session('role') != 3) {
            return back()->with('error', 'No tienes permisos para realizar esta acción.');
        }    
    
        $idReservation = $request->input('id');
        $idReservationStatus = 2; //cancelar

        $cancel = $this->repoReservation->updateReservationStatus($idReservation, $idReservationStatus);

        return back()->with('success', 'Reserva cancelada con éxito.');
    }

    public function confirmReservation(Request $request) {
        if (session('role') != 1 && session('role') != 3) {
            return back()->with('error', 'No tienes permisos para realizar esta acción.');
        }    
    
        $idReservation = $request->input('id');
        $startDate = $request->input('startDate');
        $idReservationStatus = 4; //alquilada

        $startDateTime = strtotime($startDate);

        $startOfToday = strtotime(date('Y-m-d') . ' 00:00:00');
        $endOfToday = strtotime(date('Y-m-d') . ' 23:59:59');

        if ($startDateTime < $startOfToday) {
            $this->repoReservation->updateReservationStatus($idReservation, 2);
            return back()->with('error', 'La reserva ha sido cancelada automáticamente porque la fecha de inicio ya pasó.');
        }

        if ($startDateTime >= $startOfToday && $startDateTime <= $endOfToday) {
            $pickupDate = date('Y-m-d H:i:s');

            $this->repoReservation->updateReservationStatus($idReservation, $idReservationStatus);
            $this->repoReservation->createRental($idReservation, $pickupDate);

            return back()->with('success', 'Reserva confirmada correctamente.');
        }

        return back()->with('error', 'Solo puedes confirmar la reserva el mismo día del inicio.');
    }

    public function receive(Request $request) {
        if (session('role') != 1 && session('role') != 3) {
            return back()->with('error', 'No tienes permisos para realizar esta acción.');
        }    
    
        $idReservation = $request->input('id');
        $returnDate = date('Y-m-d H:i:s');
        $idReservationStatus = 5; //supervisión

        //En supervisión
        $this->repoReservation->updateReservationStatus($idReservation, $idReservationStatus);

        $this->repoReservation->updateRentalReturnDate($idReservation, $returnDate);

        return back()->with('success', 'Bicicleta recepcionada correctamente.');
    }

    public function supervisingView(Request $request) {
        if (session('role') != 1 && session('role') != 2) {
            return back()->with('error', 'No tienes permisos para realizar esta acción.');
        }    

        $idReservation = $request->input('id');
    
        $reservation = $this->repoReservation->getReservationById($idReservation);
        if (!$reservation) {
            return back()->with('error', 'Reserva no encontrada.');
        }

        $idBike = $reservation->getIdBike();
        $kmBike = $this->repoBike->getKmBikeById($idBike);

        return view('reservation.supervising', ['idReservation' => $idReservation, 'kmBike' => $kmBike]);
    }

    public function supervising(Request $request) {
        if (session('role') != 1 && session('role') != 2) {
            return redirect()->route('reservation.index')->with('error', 'No tienes permisos para realizar esta acción.');
        }

        $idReservation = $request->input('idReservation');
        $kmInput = floatval($request->input('km'));
        $incident = $request->input('incident');
        $penalty = floatval($request->input('penalty'));

        $reservation = $this->repoReservation->getReservationById($idReservation);
        if (!$reservation) {
            return redirect()->route('reservation.index')->with('error', 'Reserva no encontrada.');
        }

        $rental = $this->repoReservation->getRentalByIdReservation($idReservation);
        if (!$rental) {
            return redirect()->route('reservation.index')->with('error', 'No existe registro de alquiler.');
        }

        $idBike = $reservation->getIdBike();
        $bike = $this->repoBike->getBikeById($idBike);

        $delayDays = $this->getDelayDays($reservation->getEndDate(), $rental->getReturnDate());

        if ($delayDays > 0) {
            $extraPenalty = $delayDays * $bike->getDailyPrice();
            $penalty += $extraPenalty;
            $incident .= "\nBicicleta devuelta con $delayDays día/s de retraso (Penalización de $extraPenalty €).";
        }

        if ($kmInput < $bike->getTotalKm()) {
            return redirect()->route('reservation.index')->with('error', 'Los kilómetros introducidos no pueden ser menores que los actuales.');
        }

        //Actualizar el alquiler, actualizar km de la bici y finalizar la reserva
        $this->repoReservation->updateFinishRental($idReservation, $kmInput - $bike->getTotalKm(), $incident, $penalty);
        $this->repoBike->updateKmBike($idBike, $kmInput);
        $this->repoReservation->updateReservationStatus($idReservation, 3);

        return redirect()->route('reservation.index')->with('success', 'Revisión guardada correctamente.');
    }

    private function getDelayDays(string $endDate, string $returnDate): int {
        $end = new DateTime($endDate);
        $return = new DateTime($returnDate);

        $diff = $end->diff($return);

        if ($return <= $end) {
            return 0;
        }

        return (int) $diff->days;
    }
}
