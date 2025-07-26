<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\GameSession;
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
        // 1) Validation des entrées
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'brand_id' => 'required|exists:brands,id',
        ]);

        // 2) Création de la GameSession
        $session = GameSession::create([
            'name'       => $validated['name'],
            'user_id'    => $request->user()->id,
            'started_at' => now(),
            'is_active'  => true,
        ]);

        // 3) On assigne la brand sélectionnée à cette partie
        Brand::findOrFail($validated['brand_id'])
            ->update(['game_session_id' => $session->id]);

        // 4) (Optionnel) Logique d'initialisation de draft, d'affectation de workers, etc.

        // 5) Redirection vers le dashboard de la partie
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
