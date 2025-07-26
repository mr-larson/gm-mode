<?php

namespace App\Http\Controllers;

use App\Enums\WorkerCategory;
use App\Enums\WorkerStyle;
use App\Http\Requests\StoreWorkerRequest;
use App\Http\Requests\UpdateWorkerRequest;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Worker;
use Inertia\Inertia;
use Inertia\Response;

class WorkerController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Worker::query()->with('currentContract.brand');

        // 🔍 Filtres
        if ($request->filled('brand_id')) {
            $query->whereHas('currentContract', fn($q) => $q->where('brand_id', $request->brand_id));
        }

        if ($request->filled('category') && WorkerCategory::tryFrom($request->category)) {
            $query->where('category', $request->category);
        }

        if ($request->filled('style') && WorkerStyle::tryFrom($request->style)) {
            $query->where('style', $request->style);
        }

        // 🔃 Tri
        $sortField = $request->get('sort', 'lastname');
        $sortDirection = $request->get('direction', 'asc');

        if (in_array($sortField, ['lastname', 'firstname', 'popularity', 'overall', 'endurance', 'promo_skill'])) {
            $query->orderBy($sortField, $sortDirection);
        }

        if ($sortField === 'performanceScore') {
            $query->orderByRaw('(wins * 3 + draws) ' . $sortDirection);
        }

        if ($sortField === 'brand') {
            $query->leftJoin('contracts as c', 'workers.id', '=', 'c.worker_id')
                ->leftJoin('brands as b', 'c.brand_id', '=', 'b.id')
                ->where('c.is_active', true)
                ->orderBy('b.name', $sortDirection)
                ->select('workers.*');
        }

        // 📦 Données
        $workers = $query->get()->map(fn ($worker) => [
            'id' => $worker->id,
            'firstname' => $worker->firstname,
            'lastname' => $worker->lastname,
            'nickname' => $worker->nickname,
            'gender' => $worker->gender,
            'age' => $worker->age,
            'style' => $worker->style,
            'status' => $worker->status,
            'category' => $worker->category,
            'alignment' => $worker->alignment,
            'height' => $worker->height,
            'weight' => $worker->weight,
            'overall' => $worker->overall,
            'popularity' => $worker->popularity,
            'endurance' => $worker->endurance,
            'promo' => $worker->promo_skill,
            'wins' => $worker->wins,
            'draws' => $worker->draws,
            'losses' => $worker->losses,
            'note' => $worker->note,
            'performanceScore' => $worker->performance_score,
            'fullName' => $worker->full_name,
            'current_contract' => [
                'brand' => optional($worker->currentContract?->brand)->only(['id', 'name', 'color']),
            ],
        ]);

        // Enums
        $categories = collect(WorkerCategory::cases())->map(fn($case) => [
            'label' => $case->displayName(),
            'value' => $case->value,
        ]);

        $styles = collect(WorkerStyle::cases())->map(fn($case) => [
            'label' => $case->displayName(),
            'value' => $case->value,
        ]);

        return Inertia::render('Workers/Index', [
            'workers' => $workers,
            'brands' => Brand::all(['id', 'name', 'color']),
            'categories' => $categories,
            'styles' => $styles,
            'filters' => $request->only(['brand_id', 'category', 'style', 'sort', 'direction']),
        ]);
    }

    public function show(Worker $worker)
    {
        $worker->load('currentContract.brand');

        return response()->json([
            'id' => $worker->id,
            'firstname' => $worker->firstname,
            'lastname' => $worker->lastname,
            'nickname' => $worker->nickname,
            'gender' => $worker->gender,
            'age' => $worker->age,
            'style' => $worker->style,
            'status' => $worker->status,
            'category' => $worker->category,
            'alignment' => $worker->alignment,
            'height' => $worker->height,
            'weight' => $worker->weight,
            'overall' => $worker->overall,
            'popularity' => $worker->popularity,
            'endurance' => $worker->endurance,
            'promo_skill' => $worker->promo_skill,
            'wins' => $worker->wins,
            'draws' => $worker->draws,
            'losses' => $worker->losses,
            'note' => $worker->note,
            'performanceScore' => $worker->performance_score,
            'fullName' => $worker->full_name,
            'current_contract' => [
                'brand' => optional($worker->currentContract?->brand)->only(['id', 'name', 'color']),
            ],
        ]);
    }

    public function create() {}
    public function store(StoreWorkerRequest $request) {}
    public function edit(Worker $worker) {}
    public function update(UpdateWorkerRequest $request, Worker $worker) {}
    public function destroy(Worker $worker) {}
}
