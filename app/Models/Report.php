<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    const PERMISSION_NAME = 'Reports';

    public static function getJobFilesReport($year = null)
    {
        $data = [];
        try {
            if (!$year) {
                $year = Carbon::now()->format('Y');
            }
            for ($i = 1; $i <= 12; $i++) {
                $date =  '01/' .$i . '/' . $year;
                $start = Carbon::createFromFormat('d/n/Y', $date)->startOfMonth();
                $end = Carbon::createFromFormat('d/n/Y', $date)->endOfMonth();
                $month_str = $start->format('F');

                $files_count = JobFile::where('arrival_date', '>=', $start)->where('arrival_date', '<=', $end)->count();
                $data[] = [$month_str, $files_count];
            }
        } catch (\Throwable $t) {
            logger($t);
        }
        return $data;
    }

    public static function getClientsReport($year = null)
    {
        $data = [];
        try {
            if (!$year) {
                $year = Carbon::now()->format('Y');
            }
            for ($i = 1; $i <= 12; $i++) {
                $date =  '01/' .$i . '/' . $year;
                $start = Carbon::createFromFormat('d/n/Y', $date)->startOfMonth();
                $end = Carbon::createFromFormat('d/n/Y', $date)->endOfMonth();
                $month_str = $start->format('F');

                $files = JobFile::where('arrival_date', '>=', $start)->where('arrival_date', '<=', $end)->get();
                $count = 0;
                foreach ($files as $file) {
                    $count += ($file->adults_count + $file->children_count);
                }
                $data[] = [$month_str, $count];
            }
        } catch (\Throwable $t) {
            logger($t);
        }
        return $data;
    }

    public static function getRoomsReport($hotel_id = null, $year = null)
    {
        $data = [];
        if (!$hotel_id) {
            return $data;
        }
        try {
            if (!$year) {
                $year = Carbon::now()->format('Y');
            }
            for ($i = 1; $i <= 12; $i++) {
                $date =  '01/' .$i . '/' . $year;
                $start = Carbon::createFromFormat('d/n/Y', $date)->startOfMonth();
                $end = Carbon::createFromFormat('d/n/Y', $date)->endOfMonth();
                logger("==========");
                logger($date);
                logger($start);
                $month_str = $start->format('F');

                $files = JobFile::whereHas('accommodations', function ($inner) use ($hotel_id, $start, $end) {
                    $inner->where('hotel_id', $hotel_id)->where('check_in', '>=', $start)->where('check_in', '<=', $end);
                })->with([
                    'accommodations' => function ($inner) use ($hotel_id, $start, $end) {
                        $inner->where('hotel_id', $hotel_id)->where('check_in', '>=', $start)->where('check_in', '<=', $end);
                    }
                ])->get();

                $accs = JobAccommodation::where('hotel_id', $hotel_id)->where('check_in', '>=', $start)->where('check_in', '<=', $end)->whereHas('job')->get();

                $count = 0;
                foreach ($accs as $acc) {
                    $check_in = Carbon::createFromFormat('d/m/Y H:i', $acc->check_in->format('d/m/Y H:i'));
                    $check_out = Carbon::createFromFormat('d/m/Y H:i', $acc->check_out->format('d/m/Y H:i'));
                    $count += ($check_in->diffInDays($check_out));
                }
                $data[] = [$month_str, $count];
            }
        } catch (\Throwable $t) {
            logger($t);
        }
        return $data;
    }
}
