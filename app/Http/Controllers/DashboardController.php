<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Worker;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Contract;

class DashboardController extends Controller
{

    public function __invoke(): Response
    {
        $brands = Brand::select('id', 'name', 'money', 'popularity', 'color')->get();

        $workers = Worker::with('currentContract')
            ->get()
            ->map(fn($w) => [
                'id' => $w->id,
                'fullName' => $w->fullName,
                'endurance' => $w->endurance,
                'popularity' => $w->popularity,
                'overall' => $w->overall,
                'note' => $w->note,
                'promo_skill' => $w->promo_skill,
                'status' => $w->status,
                'category' => $w->category,
                'alignment' => $w->alignment,
                'height' => $w->height,
                'weight' => $w->weight,
                'performanceScore' => $w->performanceScore,
                'wins' => $w->wins,
                'draws' => $w->draws,
                'losses' => $w->losses,
                'current_contract' => [
                    'brand_id' => $w->currentContract?->brand_id,
                ]
            ]);

        return Inertia::render('Dashboard', [
            'brands' => $brands,
            'workers' => $workers,
        ]);
    }

}
