<?php

namespace App\Observers;

use App\Models\Brand;
use Illuminate\Support\Facades\Auth;

class BrandObserver
{
    public function creating(Brand $brand): void
    {
        if (Auth::check()) {
            $brand->created_by = Auth::id();
            $brand->updated_by = Auth::id();
        }
    }

    public function updating(Brand $brand): void
    {
        if (Auth::check()) {
            $brand->updated_by = Auth::id();
        }
    }

    public function deleting(Brand $brand): void
    {
        if (Auth::check()) {
            $brand->deleted_by = Auth::id();
            $brand->save(); // important pour enregistrer le deleted_by avant soft delete
        }
    }
}
