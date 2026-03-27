<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Repositories\BikeRepository;

class HomeController extends Controller
{
    protected $repo;

    public function __construct(BikeRepository $repoBike)
    {
        $this->repo = $repoBike;
    }

    public function index(Request $request) {
        $limit = 8;
        $page = (int) $request->input('page', 1);
        $filter = $request->input('filter', 'all');
        $sort = $request->input('sort', 'asc');

        $offset = ($page - 1) * $limit;

        $bikes = $this->repo->getAvailableBikes($offset, $limit, $filter, $sort);
        $bikeIds = array_map(fn($b) => $b->getIdBike(), $bikes);
        $imagesByBike = $this->repo->getBikesImagesByIds($bikeIds);

        foreach ($bikes as $bike) {
            $bike->setImages($imagesByBike[$bike->getIdBike()] ?? []);
        }

        $totalBikes = $this->repo->countAvailableBikes($filter);
        $totalPages = ceil($totalBikes / $limit);
        $currentPage = $page;

        if ($request->ajax()) {
            return response()->json([
                'html' => view('home.bikes', compact('bikes'))->render(),
                'pagination' => view('_partials.pagination', compact('currentPage', 'totalPages'))->render()
            ]);
        }

        return view('home.index', ['page' => $page, 'limit' => $limit, 'bikes' => $bikes, 'totalPages' => $totalPages, 'currentPage' => $currentPage]);
    }
}
