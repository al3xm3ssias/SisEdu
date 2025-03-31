<?php

namespace App\Observers;

use App\Models\GradeAula;
use Illuminate\Support\Facades\Session;

class GradeAulaObserver
{
    /**
     * Handle the GradeAula "created" event.
     */
    public function created(GradeAula $gradeAula): void
    {
        //
    }

    /**
     * Handle the GradeAula "updated" event.
     */
    public function updated(GradeAula $gradeAula): void
    {
        //
    }

    /**
     * Handle the GradeAula "deleted" event.
     */
    public function deleted(GradeAula $gradeAula): void
    {
        //
    }

    /**
     * Handle the GradeAula "restored" event.
     */
    public function restored(GradeAula $gradeAula): void
    {
        //
    }

    /**
     * Handle the GradeAula "force deleted" event.
     */
    public function forceDeleted(GradeAula $gradeAula): void
    {
        //
    }

    public function creating(GradeAula $gradeAula)
    {
        if (!$gradeAula->ano_letivo_id) {
            $gradeAula->ano_letivo_id = Session::get('ano_letivo_id');
        }
    }
}
