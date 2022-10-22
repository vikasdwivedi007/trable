<?php

namespace App\Models;

use App\Traits\SerializeDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobTrainTicket extends Model
{
    use SoftDeletes, SerializeDate;

    protected $fillable = ['job_id', 'train_ticket_id'];

    public function job()
    {
        return $this->belongsTo(JobFile::class, 'job_id');
    }

    public function train_ticket()
    {
        return $this->belongsTo(TrainTicket::class, 'train_ticket_id');
    }
}
