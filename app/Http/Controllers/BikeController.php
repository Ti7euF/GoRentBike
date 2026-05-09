<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Bike;
use App\Http\Controllers\Controller;
use App\Repositories\BikeRepository;

class BikeController extends Controller
{
    protected $repoBike;

    public function __construct(BikeRepository $repoBike) {
        $this->repoBike = $repoBike;
    }

    public function index(Request $request) {
        if (session('role') != 1) {
            return redirect()->route('login');
        }

        $limit = 8;
        $page = (int) $request->input('page', 1);
        $filter = $request->input('filter', 'all');
        $sort = $request->input('sort', 'asc');

        $offset = ($page - 1) * $limit;

        $bikes = $this->repoBike->getBikesAmortization($offset, $limit, $filter, $sort);
        $bikeIds = array_map(fn($b) => $b->getIdBike(), $bikes);
        $imagesByBike = $this->repoBike->getBikesImagesByIds($bikeIds);

        foreach ($bikes as $bike) {
            $bike->setImages($imagesByBike[$bike->getIdBike()] ?? []);
        }

        $totalBikes = $this->repoBike->countAmortizationBikes($filter);
        $totalPages = ceil($totalBikes / $limit);
        $currentPage = $page;

        if ($request->ajax()) {
            return response()->json([
                'html' => view('bike.tableBike', compact('bikes'))->render(),
                'pagination' => view('_partials.pagination', compact('currentPage', 'totalPages'))->render()
            ]);
        }

        return view('bike.index', ['page' => $page, 'limit' => $limit, 'bikes' => $bikes, 'totalPages' => $totalPages, 'currentPage' => $currentPage]);
    }
    
    public function viewUpdateBike(Request $request) {
        if (session('role') != 1) {
            return redirect()->route('login');
        }
        $idBike = $request->input('idBike');

        $bike = $this->repoBike->getBikeById($idBike);
        $images = $this->repoBike->getBikesImagesByIds([$idBike]);
        $bike->setImages($images[$idBike] ?? []);

        if (!$bike) {
            return redirect()->route('bike.index')->with('error', 'Bicicleta no encontrada.');
        }

        return view('bike.viewUpdate', ['bike' => $bike]);
    }
    public function bikeUpdate(Request $request) {
        if (session('role') != 1) {
            return redirect()->route('bike.index')->with('error', 'No tienes permisos para realizar esta acción.');
        }

        $idBike = $request->input('idBike');
        $brand = trim($request->input('brand'));
        $model = trim($request->input('model'));
        $type = trim($request->input('type'));
        $dailyPrice = trim($request->input('dailyPrice'));
        $active = $request->has('active') ? 1 : 0;
        $frame = trim($request->input('frame'));
        $gear = trim($request->input('gear'));
        $brakes = trim($request->input('brakes'));
        $suspension = trim($request->input('suspension'));
        $tires = trim($request->input('tires'));
        $seatpost = trim($request->input('seatpost'));

        if ($brand === '' || strlen($brand) > 50 || $model === '' || strlen($model) > 50 || $frame === '' || strlen($frame) > 50 || $gear === '' || strlen($gear) > 50 || $brakes === '' || strlen($brakes) > 50 || $suspension === '' || strlen($suspension) > 50 || $tires === '' || strlen($tires) > 50 || $seatpost === '' || strlen($seatpost) > 50) {
            return back()->with('error', 'Hay campos vacíos o con más de 50 caracteres.');
        }

        if ($type !== 'Montaña' && $type !== 'Carretera') {
            return back()->with('error', 'Tipo de bicicleta incorrecto.');
        }

        if ($dailyPrice === '' || !is_numeric($dailyPrice)) {
            return back()->with('error', 'La amortización, el precio diario o los km son inválidos.');
        }

        $bike = new Bike($idBike, 1, $brand, $model, $type, $active);
        $bike->setDailyPrice($dailyPrice);
        $bike->setFrame($frame);
        $bike->setGear($gear);
        $bike->setBrakes($brakes);
        $bike->setSuspension($suspension);
        $bike->setTires($tires);
        $bike->setSeatpost($seatpost);

        $this->repoBike->updateBike($bike);

        return redirect()->route('bike.index')->with('success', 'Bicicleta actualizada correctamente.');
    }

    public function deleteImage(Request $request) {
        $idBike = $request->input('idBike');
        $path   = $request->input('path');

        $this->repoBike->deleteImageToBike($idBike, $path);

        $fullPath = public_path('uploads/bikes/' . $path);

        if (file_exists($fullPath)) {
            unlink($fullPath);
        }

        return back()->with('success', 'Imagen eliminada correctamente.');
    }
    public function addImage(Request $request) {
        $idBike = $request->input('idBike');
        $images = $request->file('images');
        $nameBike = $request->input('nameBike');

        if (!$images) {
            return back()->with('error', 'Debes subir al menos una imagen.');
        }

        foreach ($images as $file) {
            if ($file->getSize() > 4096 * 1024) {
                return back()->with('error', 'Una de las imágenes supera los 4MB.');
            }

            $mime = $file->getMimeType();
            $allowed = ['image/jpeg', 'image/png', 'image/webp'];

            if (!in_array($mime, $allowed)) {
                return back()->with('error', 'Formato de imagen no permitido.');
            }
        }

        foreach ($request->file('images') as $file) {
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/bikes'), $filename);
            $this->repoBike->addImageToBike($idBike, $filename, $nameBike);
        }

        return back()->with('success', 'Imágenes añadidas correctamente.');
    }

    public function viewAddBike() {
        if (session('role') != 1) {
            return redirect()->route('login');
        }

        return view('bike.viewAdd');
    }
    public function bikeAdd(Request $request) {
        if (session('role') != 1) {
            return redirect()->route('bike.index')->with('error', 'No tienes permisos para realizar esta acción.');
        }

        $brand = trim($request->input('brand'));
        $model = trim($request->input('model'));
        $type = trim($request->input('type'));
        $amortizationPrice = trim($request->input('amortizationPrice'));
        $dailyPrice = trim($request->input('dailyPrice'));
        $totalKm = trim($request->input('totalKm'));
        $active = $request->has('active') ? 1 : 0;
        $frame = trim($request->input('frame'));
        $gear = trim($request->input('gear'));
        $brakes = trim($request->input('brakes'));
        $suspension = trim($request->input('suspension'));
        $tires = trim($request->input('tires'));
        $seatpost = trim($request->input('seatpost'));

        if ($brand === '' || strlen($brand) > 50 || $model === '' || strlen($model) > 50 || $frame === '' || strlen($frame) > 50 || $gear === '' || strlen($gear) > 50 || $brakes === '' || strlen($brakes) > 50 || $suspension === '' || strlen($suspension) > 50 || $tires === '' || strlen($tires) > 50 || $seatpost === '' || strlen($seatpost) > 50) {
            return back()->with('error', 'Hay campos vacíos o con más de 50 caracteres.');
        }

        if ($type !== 'Montaña' && $type !== 'Carretera') {
            return back()->with('error', 'Tipo de bicicleta incorrecto.');
        }

        if ($amortizationPrice === '' || !is_numeric($amortizationPrice) || $dailyPrice === '' || !is_numeric($dailyPrice) || $totalKm === '' || !is_numeric($totalKm)) {
            return back()->with('error', 'La amortización, el precio diario o los km son inválidos.');
        }

        $bike = new Bike(0, 1, $brand, $model, $type, $active);
        $bike->setAmortizationPrice($amortizationPrice);
        $bike->setDailyPrice($dailyPrice);
        $bike->setTotalKm($totalKm);
        $bike->setFrame($frame);
        $bike->setGear($gear);
        $bike->setBrakes($brakes);
        $bike->setSuspension($suspension);
        $bike->setTires($tires);
        $bike->setSeatpost($seatpost);

        $this->repoBike->addBike($bike);

        return redirect()->route('bike.index')->with('success', 'Bicicleta creada correctamente.');
    }
}