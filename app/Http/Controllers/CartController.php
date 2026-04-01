<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Reservation;
use App\Http\Controllers\Controller;
use App\Repositories\BikeRepository;
use App\Repositories\ReservationRepository;

class CartController extends Controller
{
    protected $repoBike;
    protected $repoReservation;

    public function __construct(BikeRepository $repoBike, ReservationRepository $repoReservation)
    {
        $this->repoBike = $repoBike;
        $this->repoReservation = $repoReservation;
    }

    public function index() {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return view('cart.index');
        }
        
        $totalCartPrice = 0;
        $bikeIds = array_column($cart, 'bikeId');
        $bikes = $this->repoBike->getBikesById($bikeIds);

        foreach ($bikes as $bike) {
            foreach ($cart as $item) {
                if ((int)$item['bikeId'] === (int)$bike->getIdBike()) {                
                    $totalPrice = $this->calculateItemPrice($bike, $item['startDate'], $item['endDate']);
                    $totalCartPrice += $totalPrice;
                }
            }
        }

        $subtotal = $totalCartPrice / 1.21;
        $iva = $totalCartPrice - $subtotal;

        return view('cart.index', ['bikes' => $bikes, 'subtotal' => $subtotal, 'iva' => $iva, 'total' => $totalCartPrice,]);
    }


    public function add(Request $request) {
        $bikeId = $request->input('bikeId');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $cart = session('cart', []);

        try {
            foreach ($cart as $item) {
                if ($item['bikeId'] == $bikeId) {
                    {
                        return response()->json(['status' => 'exists']);
                    }
                }
            }

            if (!$this->repoBike->isBikeAvailable($bikeId, $startDate, $endDate)) {
                return response()->json(['status' => 'unavailable']);
            }

            $cart = session()->get('cart', []);

            $cart[] = [
                'bikeId' => $bikeId,
                'startDate' => $startDate,
                'endDate' => $endDate,
            ];

            session()->put('cart', $cart);

            return response()->json(['status' => 'added']);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error']);
        }
    }

    public function remove(Request $request) {
        $bikeId = $request->input('bikeId');

        try {
            $cart = session()->get('cart', []);

            $newCart = array_filter($cart, function ($item) use ($bikeId) {
                return $item['bikeId'] != $bikeId;
            });

            if (count($newCart) === count($cart)) {
                return response()->json(false);
            }

            session()->put('cart', array_values($newCart));

            return response()->json(true);
        } catch (\Exception $e) {
            return response()->json(false);
        }
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

                $itemPrice = $this->calculateItemPrice($bike, $item['startDate'], $item['endDate']);
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

    private function calculateItemPrice($bike, $startDate, $endDate) {
        $bike->setStartDate($startDate);
        $bike->setEndDate($endDate);

        $days = $bike->calculateRentalDays();
        $bike->setRentalDays($days);

        $discount = $bike->calculateDiscount($days);
        $bike->setDiscount($discount);

        $priceWithDiscount = $bike->calculateTotalPrice();
        $bike->setTotalPrice($priceWithDiscount);

        return $priceWithDiscount;
    }

}
