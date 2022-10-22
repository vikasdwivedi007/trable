<?php

namespace App\Traits;

trait ServiceCanBeDeleted
{

    public function canBeDeleted()
    {
        if (
            ($this->program_itemable && $this->program_itemable->program && $this->program_itemable->program->job)
            ||
            ($this->routers_in_jobs && $this->routers_in_jobs->count())
            ||
            ($this->job_gifts && $this->job_gifts->count())
            ||
            ($this->job_visas && $this->job_visas->count())
            ||
            ($this->job_trains && $this->job_trains->count())
            ||
            ($this->job_cruises && $this->job_cruises->count())
            ||
            ($this->reserved_for_jobs && $this->reserved_for_jobs->count())
            ||
            ($this->job_flights && $this->job_flights->count())
            ||
            ($this->job_files && $this->job_files->count())


        ) {
            return false;
        }else{
            return true;
        }
    }

    public function CanBeDeletedFlag()
    {
        $this->can_be_deleted = $this->canBeDeleted();
    }
}
