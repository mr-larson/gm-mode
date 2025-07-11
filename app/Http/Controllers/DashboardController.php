<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Worker;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __invoke(): Response
    {
        $brands = Brand::withCount('workers')->get();

        return Inertia::render('Dashboard', [
            'brands' => $brands->map(fn ($brand) => [
                'name' => $brand->name,
                'money' => $brand->money,
                'popularity' => $brand->popularity,
                'color' => $brand->color,
            ]),
        ]);

    }
}
