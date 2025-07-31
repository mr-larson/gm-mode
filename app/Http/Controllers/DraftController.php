<?php

namespace App\Http\Controllers;

use App\Models\{GameSession, GameSessionBrand, Worker};
use Illuminate\Http\Request;
use Inertia\Inertia;

class DraftController extends Controller
{
    public function show(GameSession $session)
    {
        $session->load(['pivotBrands.brand','pivotBrands.worker']);

        $pickedIds = $session->pivotBrands
            ->pluck('worker_id')
            ->filter()
            ->all();

        $available = Worker::whereNotIn('id', $pickedIds)->get();

        return Inertia::render('GameSessions/Draft', [
            'session'   => $session->only(['id', 'name']) + [
                    'pivotBrands' => $session->pivotBrands->map(function ($pivot) {
                        return [
                            'id'          => $pivot->id,
                            'draft_order' => $pivot->draft_order,
                            'is_human'    => $pivot->is_human,
                            'brand'       => [
                                'id'   => $pivot->brand->id,
                                'name' => $pivot->brand->name,
                            ],
                            'worker' => $pivot->worker ? [
                                'id'        => $pivot->worker->id,
                                'fullName'  => $pivot->worker->full_name,
                                'overall'   => $pivot->worker->overall,
                            ] : null,
                        ];
                    }),
                ],
            'available' => $available->map(function ($worker) {
                return [
                    'id'       => $worker->id,
                    'fullName' => $worker->full_name,
                    'overall'  => $worker->overall,
                ];
            }),
        ]);
    }

    public function pick(Request $request, GameSession $session)
    {
        $data = $request->validate([
            'draft_order' => 'required|integer|exists:game_session_brand,draft_order,game_session_id,'.$session->id,
            'worker_id'   => 'required|exists:workers,id',
        ]);

        $pivot = GameSessionBrand::where('game_session_id', $session->id)
            ->where('draft_order', $data['draft_order'])
            ->firstOrFail();

        $pivot->update([
            'worker_id' => $data['worker_id'],
        ]);

        $worker = Worker::findOrFail($data['worker_id']);

        $salaryPerWeek = 5000;
        $seasonWeeks = 10;
        $totalSalary = $salaryPerWeek * $seasonWeeks;

        $pivot->brand->contracts()->create([
            'worker_id'  => $worker->id,
            'start_date' => now(),
            'end_date'   => now()->addWeeks($seasonWeeks),
            'salary'     => $totalSalary,
            'is_active'  => true,
        ]);

        return redirect()->route('sessions.draft', $session);
    }

    public function nextStep(GameSession $session)
    {
        $session->load(['pivotBrands.worker']);

        $nextSlot = $session->pivotBrands->first(fn($slot) => !$slot->worker);

        if (!$nextSlot) {
            return redirect()->route('sessions.dashboard', $session);
        }

        if ($nextSlot->is_human) {
            return redirect()->route('sessions.draft', $session);
        }

        $pickedIds = $session->pivotBrands->pluck('worker_id')->filter()->all();

        $worker = Worker::whereNotIn('id', $pickedIds)->inRandomOrder()->first();

        if ($worker) {
            $nextSlot->update(['worker_id' => $worker->id]);
        }

        return $this->nextStep($session);
    }
}
