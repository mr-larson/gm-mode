<?php

namespace App\Http\Controllers;

use App\Models\{Brand, GameSession};
use Illuminate\Http\Request;
use Inertia\Inertia;

class GameSessionController extends Controller
{
    public function index()
    {
        return Inertia::render('GameSessions/Index', [
            'sessions' => GameSession::with('brands:id,name,color')->get(),
        ]);
    }

    public function create()
    {
        return Inertia::render('GameSessions/Create', [
            'brands' => Brand::all(['id', 'name', 'color', 'popularity', 'money']),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'brand_id' => 'required|exists:brands,id',
        ]);

        $session = GameSession::create([
            'name'       => $validated['name'],
            'started_at' => now(),
        ]);

        $allBrands     = Brand::pluck('id')->toArray();
        $playerBrandId = $validated['brand_id'];
        $others = array_diff($allBrands, [$playerBrandId]);
        shuffle($others);
        $draftOrderList = array_merge([$playerBrandId], $others);

        foreach ($draftOrderList as $index => $brandId) {
            $session->pivotBrands()->create([
                'brand_id'    => $brandId,
                'is_human'    => $brandId == $playerBrandId,
                'draft_order' => $index + 1,
            ]);
        }

        return redirect()->route('sessions.draft', $session);
    }

    public function dashboard(GameSession $session)
    {
        $session->load('pivotBrands.brand');

        foreach ($session->pivotBrands as $pivot) {
            $pivot->brand->load('workers');
        }

        return Inertia::render('GameSessions/Dashboard', [
            'session' => $session,
        ]);
    }
}
