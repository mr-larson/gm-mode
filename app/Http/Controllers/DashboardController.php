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
        $brands = Brand::select('id','name','money','popularity','color')->get();
        $workers = Worker::with('brand')
            ->get(['id','firstname','lastname','wins','draws','losses','brand_id'])
            ->map(fn($w) => [
                'id' => $w->id,
                'firstname' => $w->firstname,
                'lastname' => $w->lastname,
                'wins' => $w->wins,
                'draws' => $w->draws,
                'losses' => $w->losses,
                'brand_id' => $w->brand_id,
                /** Accesseurs */
                'fullName' => $w->fullName,
                'performanceScore' => $w->performanceScore,
            ]);

        return Inertia::render('Dashboard', compact('brands', 'workers'));
    }

}
