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
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $query = Worker::query()->with('currentContract.brand');

        // Filtres
        if ($request->filled('brand_id')) {
            $query->whereHas('currentContract', function ($q) use ($request) {
                $q->where('brand_id', $request->brand_id);
            });
        }

        if ($request->filled('category') && WorkerCategory::tryFrom($request->category)) {
            $query->where('category', $request->category);
        }

        if ($request->filled('style') && WorkerStyle::tryFrom($request->style)) {
            $query->where('style', $request->style);
        }

        // Tri
        $sortField = $request->get('sort', 'lastname');
        $sortDirection = $request->get('direction', 'asc');

        if (in_array($sortField, ['lastname', 'firstname', 'popularity', 'overall'])) {
            $query->orderBy($sortField, $sortDirection);
        }

        $workers = $query->get();

        // Format enums pour le front
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
            'brands' => Brand::all(['id', 'name']),
            'categories' => $categories,
            'styles' => $styles,
            'filters' => $request->only(['brand_id', 'category', 'style', 'sort', 'direction']),
        ]);
    }

    public function create()
    {
        //
    }

    public function store(StoreWorkerRequest $request)
    {
        //
    }

    public function show(Worker $worker): Response
    {
        $worker->load('currentContract.brand');

        return Inertia::render('Workers/Show', [
            'worker' => $worker
        ]);
    }

    public function edit(Worker $worker)
    {
        //
    }

    public function update(UpdateWorkerRequest $request, Worker $worker)
    {
        //
    }

    public function destroy(Worker $worker)
    {
        //
    }
}
