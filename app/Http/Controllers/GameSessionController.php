<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\GameSession;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GameSessionController extends Controller
{
    public function create()
    {
        return Inertia::render('GameSessions/Create', [
            'brands' => Brand::all(['id', 'name', 'color', 'popularity', 'money']),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand_id' => 'required|exists:brands,id',
        ]);

        $session = GameSession::create([
            'name' => $validated['name'],
        ]);

        // Attacher la brand choisie à la session
        $brand = Brand::find($validated['brand_id']);
        $brand->update(['game_session_id' => $session->id]);

        // Tu pourras ajouter ici la logique pour :
        // - affecter des workers à chaque brand
        // - initialiser les stats

        return redirect()->route('sessions.dashboard', $session);
    }

    public function dashboard(GameSession $session)
    {
        $session->load('brands.workers');

        return Inertia::render('GameSessions/Dashboard', [
            'session' => $session,
        ]);
    }
}
