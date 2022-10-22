<?php

namespace App\Models;

use App\Helpers;
use App\Traits\SerializeDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pipeline\Pipeline;
use Spatie\Activitylog\Traits\LogsActivity;

class Commission extends Model
{
    use SoftDeletes, LogsActivity, SerializeDate;

    const PERMISSION_NAME = 'Commissions';

    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['created_at', 'updated_at'];
    protected static $logOnlyDirty = true;

    public $can_search_by = [];

    public static function viewIndex()
    {
        $query = self::select([
            'cash_forms.*',
            'job_file.file_no as job_file.file_no',
            'job_file.client_name as job_file.client_name',
            'job_file.adults_count as job_file.adults_count',
            'job_file.children_count as job_file.children_count',
            'representative.user_id as representative.user_id',
            'representative_user.name as representative_user.name',
        ])->leftJoin('job_files as job_file', 'cash_forms.job_id', '=', 'job_file.id')
            ->leftJoin('employees as representative', 'cash_forms.emp_id', '=', 'representative.id')
            ->leftJoin('users as representative_user', 'representative.user_id', '=', 'representative_user.id');


        $query = app(Pipeline::class)->send($query)
            ->through([
                \App\QueryFilters\FilterBy::class,
                \App\QueryFilters\FilterByRelationship::class,
                \App\QueryFilters\Order::class,
            ])
            ->thenReturn();
        $count = $query->count();
        $query = app(Pipeline::class)->send($query)
            ->through([
                \App\QueryFilters\Paginate::class,//always last
            ])
            ->thenReturn();

        $rows = $query->with('job_file')->get();
        $rows->map->formatObjectForDatatable();
        return Helpers::FormatForDatatable($rows, $count);
    }

    public function formatObjectForDatatable()
    {
        $this->date = $this->date->format('l d F Y');
        $this->pax_count = $this->{'job_file.adults_count'} + $this->{'job_file.children_count'};
        $this->operator = $this->job_file->operator()->user->name;
        $this->representative_user = (object)['name' => $this->{'representative_user.name'}];
        $this->can_edit = auth()->user()->can('update', $this);
        $this->edit_path = route('cash-forms.edit', ['cash_form' => $this->id]);
        $this->can_view = auth()->user()->can('view', $this);
        $this->view_path = route('cash-forms.show', ['cash_form' => $this->id]);
        $this->can_delete = auth()->user()->can('delete', $this);
        $this->delete_path = route('cash-forms.destroy', ['cash_form' => $this->id]);
    }

}
