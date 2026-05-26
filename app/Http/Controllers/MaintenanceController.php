<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Maintenance;
use App\Http\Controllers\Controller;
use App\Repositories\MaintenanceRepository;
use App\Repositories\BikeRepository;

use DateTime;

class MaintenanceController extends Controller
{
    protected $repoMaintenance;
    protected $repoBike;

    public function __construct(MaintenanceRepository $repoMaintenance, BikeRepository $repoBike) {
        $this->repoMaintenance = $repoMaintenance;
        $this->repoBike = $repoBike;
    }

    public function index(Request $request) {
        if (session('role') != 1 && session('role') != 2) {
            return redirect()->route('login');
        }

        $limit = 8;
        $page = (int) $request->input('page', 1);
        $filter = $request->input('filter', 'all');
        $sort = $request->input('sort', 'asc');

        $offset = ($page - 1) * $limit;

        $maintenances = $this->repoMaintenance->getMaintenance($offset, $limit, $filter, $sort, null);

        $totalMaintenances = $this->repoMaintenance->countMaintenance($filter);
        $totalPages = ceil($totalMaintenances / $limit);
        $currentPage = $page;

        if ($request->ajax()) {
            return response()->json([
                'html' => view('maintenance.tableMaintenance', compact('maintenances'))->render(),
                'pagination' => view('_partials.pagination', compact('currentPage', 'totalPages'))->render()
            ]);
        }

        return view('maintenance.index', ['page' => $page, 'limit' => $limit, 'maintenances' => $maintenances, 'totalPages' => $totalPages, 'currentPage' => $currentPage]);
    }

    public function viewAddMaintenance(Request $request) {
        if (session('role') != 1 && session('role') != 2) {
            return redirect()->route('login');
        }

        $currentDateTime = date('Y-m-d\TH:i');
        $tomorrow = date('Y-m-d\TH:i', strtotime('+1 day'));

        $bikes = $this->repoBike->getAvailableBikesForMaintenance($currentDateTime, $tomorrow);

        return view('maintenance.viewAdd', ['bikes' => $bikes, 'currentDateTime' => $currentDateTime]);
    }
    public function maintenanceAdd(Request $request) {
        if (session('role') != 1 && session('role') != 2) {
            return redirect()->route('login');
        }

        $idBike = $request->input('idBike');
        $startDate = trim($request->input('startDate'));

        if (!$this->repoBike->isBikeAvailable($idBike, null, null)) {
            return back()->with('error', 'La bicicleta no existe o no está disponible para mantenimiento.');
        }

        if (strtotime($startDate) > time()) {
            return back()->with('error', 'La fecha y hora no puede ser posterior a la fecha y hora actual.');
        }

        $maintenance = new Maintenance(0, $idBike, session('userId'), $startDate, null, null);

        $added = $this->repoMaintenance->addMaintenance($maintenance);

        if ($added) {
            $this->repoBike->updateBikeStatus($idBike, 2);
        }

        return redirect()->route('maintenance.index')->with('success', 'Mantenimiento iniciado correctamente.');
    }

    public function viewUpdateMaintenance(Request $request) {
        if (session('role') != 1 && session('role') != 2) {
            return redirect()->route('login');
        }

        $idMaintenance = $request->input('idMaintenance');
        $maintenance = $this->repoMaintenance->getMaintenanceById($idMaintenance);

        if (!$maintenance) {
            return redirect()->route('maintenance.index')->with('error', 'Mantenimiento no encontrado.');
        }

        $currentDateTime = date('Y-m-d\TH:i');

        return view('maintenance.viewUpdate', ['maintenance' => $maintenance, 'currentDateTime' => $currentDateTime]);
    }
    public function maintenanceUpdate(Request $request) {
        if (session('role') != 1 && session('role') != 2) {
            return redirect()->route('login');
        }

        $idMaintenance = $request->input('idMaintenance');
        $endDate = trim($request->input('endDate'));
        $description = $request->input('description');
        $cost = $request->input('cost');

        if ($cost === null || $cost === '') {
            $cost = 0;
        }

        if (!is_numeric($cost)) {
            return back()->with('error', 'El coste debe ser un número válido.');
        }

        $maintenance = $this->repoMaintenance->getMaintenanceById($idMaintenance);
        $maintenance->setEndDate($endDate);



        if (strtotime($endDate) <= strtotime($maintenance->getStartDate())) {
            return back()->with('error', 'La fecha y hora de fin no puede ser anterior a la fecha y hora de inicio.');
        }

        if (strtotime($endDate) > time()) {
            return back()->with('error', 'La fecha y hora de fin no puede ser posterior a la fecha y hora actual.');
        }


        $minutes = $maintenance->getMinutesDifference();
        $workCost = $maintenance->calculateWorkCost($minutes);
        $totalCost = floatval($cost) + $workCost;
        $hours = ceil(($minutes / 60) * 10) / 10;

        $description .= "\n$hours hora/s de mano de obra: ($workCost) €.";

        $maintenance->setCost($totalCost);
        $maintenance->setDescription($description);

        $updated = $this->repoMaintenance->updateMaintenance($maintenance);

        if ($updated) {
            $this->repoBike->updateBikeStatus($maintenance->getIdBike(), 1);
        }

        return redirect()->route('maintenance.index')->with('success', 'Mantenimiento finalizado correctamente.');
    }
}