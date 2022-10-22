<?php

namespace App\Console\Commands;

use App\Models\Car;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CleanDBOfDeletedRows extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'DB:RemoveDeletedRows';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will run daily to remove all rows in the db that have been deleted for more than 7 days.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        try {
            $models_dir = app_path() . '/Models/';
            $files = array_diff(scandir($models_dir), array('.', '..'));
            $models = array_map(function ($i) {
                return 'App\Models\\' . str_replace(".php", '', $i);
            }, $files);

            $data = [];
            foreach ($models as $model) {
                try {
                    $deleted_rows = $model::onlyTrashed()->where('deleted_at', '<=', Carbon::now()->subMonth())->get();
                    foreach ($deleted_rows as $row) {
                        $row->forceDelete();
                        if (!isset($data[$model])) {
                            $data[$model] = 0;
                        }
                        $data[$model]++;
                    }
                } catch (\Throwable $t) {
                    $this->error($model . ' - ' . $t->getMessage() . ' ' . $t->getFile() . ' ' . $t->getLine());
                }
            }
            foreach($data as $key => $value){
                $this->info($key.'='.$value);
            }
        } catch (\Throwable $t) {
            $this->error($t->getMessage());
        }
    }
}
