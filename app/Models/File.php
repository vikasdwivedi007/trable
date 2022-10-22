<?php

namespace App\Models;

use App\Helpers;
use App\Traits\SerializeDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Activitylog\Traits\LogsActivity;

class File extends Model
{
    use SoftDeletes, LogsActivity, SerializeDate;

    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['created_at', 'updated_at'];
    protected static $logOnlyDirty = true;

    protected $guarded = [];

    const PERMISSION_NAME = 'Media-Library';

    public $can_search_by = ['files.name', 'user.name'];

    protected $casts = [
        'created_at' => 'datetime:d/m/Y'
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($file) {
            $file->uploaded_by = auth()->user()->id;
        });

        self::updating(function ($file) {
            $file->uploaded_by = auth()->user()->id;
        });
    }

    public function fileable()
    {
        return $this->morphTo();
    }

    public static function storeFiles($files)
    {
        $data = [];
        if (is_array($files)) {
            foreach ($files as $file) {
                $name = $file->getClientOriginalName();
                $path = $file->store('public');
                $data[] = ['name' => $name, 'path' => $path];
            }
        } else {
            $file = $files;
            $name = $file->getClientOriginalName();
            $path = $file->store('public');
            $data[] = ['name' => $name, 'path' => $path];
        }
        return $data;
    }

    public static function uploadFile($file, $folder, $id)
    {
        $data = [];
        if ($file) {
            $base_id = Str::random(20);
            if ($id) {
                $base_id .= $id;
            }
            $path = $folder . '/' . $base_id . $file->getClientOriginalName();
            $path = $file->storeAs('public', $path);
            $data = [
                'name' => $file->getClientOriginalName(),
                'url' => $path
            ];
        }
        return $data;
    }

    public static function mediaIndex()
    {
        $query = self::select([
            'files.*',
            'user.name as user.name',
        ])->leftJoin('users as user', 'files.uploaded_by', '=', 'user.id');

        $files = app(Pipeline::class)->send($query)
            ->through([
                \App\QueryFilters\FilterBy::class,
                \App\QueryFilters\Order::class,
            ])
            ->thenReturn();
        $count = $files->count();
        $files = app(Pipeline::class)->send($files)
            ->through([
                \App\QueryFilters\Paginate::class,//always last
            ])
            ->thenReturn();

        $files = $files->with(['fileable'])->get();
        $files->map->formatFileObject();
        return Helpers::FormatForDatatable($files, $count);
    }

    public function formatFileObject()
    {
        $this->user = (object)['name' => $this->{'user.name'}];
        $this->full_url = url(Storage::url($this->url));
    }
}
