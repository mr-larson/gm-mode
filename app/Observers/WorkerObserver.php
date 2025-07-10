<?php

namespace App\Observers;

use App\Models\Worker;
use Illuminate\Support\Facades\Auth;

class WorkerObserver
{
    public function creating(Worker $worker): void
    {
        if (Auth::check()) {
            $worker->created_by = Auth::id();
            $worker->updated_by = Auth::id();
        }
    }

    public function updating(Worker $worker): void
    {
        if (Auth::check()) {
            $worker->updated_by = Auth::id();
        }
    }

    public function deleting(Worker $worker): void
    {
        if (Auth::check()) {
            $worker->deleted_by = Auth::id();
            $worker->save(); // Important : sinon deleted_by ne sera pas persisté avant soft delete
        }
    }
}
