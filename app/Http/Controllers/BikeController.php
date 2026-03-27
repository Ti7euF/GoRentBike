<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Bike;
use App\Http\Controllers\Controller;
use App\Repositories\BikeRepository;

class BikeController extends Controller
{
    protected $repo;

    public function __construct(BikeRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index() {
        return view('bike.index');
    }
}