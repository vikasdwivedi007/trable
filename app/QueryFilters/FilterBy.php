<?php


namespace App\QueryFilters;

use App\Models\DailySheet;
use App\Models\Flight;
use App\Models\Invoice;
use App\Models\JobFile;
use App\Models\NileCruise;
use App\Models\OperatorAssignment;
use App\Models\Reminder;
use App\Models\Room;
use App\Models\Router;
use App\Models\TrainTicket;
use Carbon\Carbon;
use Closure;

class FilterBy
{

    public function handle($request, Closure $next)
    {
        if (!request()->has('search') || !isset(request('search')['value'])) {
            return $next($request);
        }
        $filter_q = request('search')['value'];

        $builder = $next($request);
        $model = $builder->getModel();
        $can_search_by = $builder->getModel()->can_search_by;

        if (stripos($filter_q, 'date-range:') !== false) {
            $dates_str = str_replace('date-range:', '', $filter_q);
            $dates = explode('-', $dates_str);
            if (count($dates) >= 2) {
                if ($model instanceof JobFile) {
                    try {
                        $start = Carbon::createFromFormat('d/m/Y', trim($dates[0]));
                        $end = Carbon::createFromFormat('d/m/Y', trim($dates[1]));
                        $start = $start->startOfDay();
                        $end = $end->endOfDay();
                        return $builder->where('job_files.created_at', '>=', $start)->where('job_files.created_at', '<=', $end);
                    } catch (\Throwable $t) {
                        return $builder;
                    }
                } elseif ($model instanceof DailySheet) {
                    try {
                        $start = Carbon::createFromFormat('j/n/Y', trim($dates[0]));
                        $end = Carbon::createFromFormat('j/n/Y', trim($dates[1]));
                        $start = $start->startOfDay();
                        $end = $end->endOfDay();
                        return $builder->where('daily_sheets.date', '>=', $start)->where('daily_sheets.date', '<=', $end);
                    } catch (\Throwable $t) {
                        return $builder;
                    }
                } elseif ($model instanceof OperatorAssignment) {
                    try {
                        //query should be in this format date-range:date1-date2&emp-id:id
                        //can filter by [date only, date&emp_id]
                        $filters = explode('&', $filter_q);
                        if (isset($filters[0])) {
                            $dates_str = str_replace('date-range:', '', $filters[0]);
                            $dates = explode('-', $dates_str);
                            if (count($dates) == 2) {
                                $start = Carbon::createFromFormat('d/m/Y', trim($dates[0]));
                                $end = Carbon::createFromFormat('d/m/Y', trim($dates[1]));
                                $start = $start->startOfDay();
                                $end = $end->endOfDay();
                                $builder = $builder->where('date', '>=', $start)->where('date', '<=', $end);
                            }
                        }
                        if(isset($filters[1])){
                            $emp_id = str_replace('emp-id:', '', $filters[1]);
                            $builder = $builder->where('emp_id', $emp_id);
                        }
                        return $builder;
                    } catch (\Throwable $t) {
                        return $builder;
                    }
                }
            }
            return $builder;
        } else {
            return $builder->where(function ($query) use ($can_search_by, $filter_q, $model) {
                $i = 0;
                foreach ($can_search_by as $key) {
                    if (stripos($key, '_id') !== false) {
                        if ($i == 0) {
                            $query->where($key, '=', $filter_q);
                        } else {
                            $query->orWhere($key, '=', $filter_q);
                        }
                    } elseif ($model instanceof Router && $key == 'provider') {
                        if ($i == 0) {
                            $query->whereIn($key, array_keys(Router::searchForProviders($filter_q)));
                        } else {
                            $query->orWhereIn($key, array_keys(Router::searchForProviders($filter_q)));
                        }
                    } elseif ($model instanceof Reminder && $key == 'status') {
                        if ($i == 0) {
                            $query->whereIn($key, array_keys(Reminder::searchForStatus($filter_q)));
                        } else {
                            $query->orWhereIn($key, array_keys(Reminder::searchForStatus($filter_q)));
                        }
                    } elseif ($model instanceof Room && $key == 'type') {
                        if ($i == 0) {
                            $query->whereIn($key, array_keys(Room::searchForType($filter_q)));
                        } else {
                            $query->orWhereIn($key, array_keys(Room::searchForType($filter_q)));
                        }
                    } elseif ($model instanceof Room && $key == 'meal_plan') {
                        if ($i == 0) {
                            $query->whereIn($key, array_keys(Room::searchForPlans($filter_q)));
                        } else {
                            $query->orWhereIn($key, array_keys(Room::searchForPlans($filter_q)));
                        }
                    } elseif ($model instanceof TrainTicket && $key == 'type') {
                        if ($i == 0) {
                            $query->whereIn($key, array_keys(TrainTicket::searchForType($filter_q)));
                        } else {
                            $query->orWhereIn($key, array_keys(TrainTicket::searchForType($filter_q)));
                        }
                    } elseif ($model instanceof TrainTicket && $key == 'class') {
                        if ($i == 0) {
                            $query->whereIn($key, array_keys(TrainTicket::searchForClass($filter_q)));
                        } else {
                            $query->orWhereIn($key, array_keys(TrainTicket::searchForClass($filter_q)));
                        }
                    } elseif ($model instanceof NileCruise && $key == 'rooms_type') {
                        if ($i == 0) {
                            $query->whereIn($key, array_keys(NileCruise::searchForTypes($filter_q)));
                        } else {
                            $query->orWhereIn($key, array_keys(NileCruise::searchForTypes($filter_q)));
                        }
                    } elseif ($model instanceof Flight && $key == 'status') {
                        if ($i == 0) {
                            $query->whereIn($key, array_keys(Flight::searchForTypes($filter_q)));
                        } else {
                            $query->orWhereIn($key, array_keys(Flight::searchForTypes($filter_q)));
                        }
                    } elseif ($model instanceof Invoice && $key == 'invoices.status') {
                        if ($i == 0) {
                            $query->whereIn($key, array_keys(Invoice::searchForStatus($filter_q)));
                        } else {
                            $query->orWhereIn($key, array_keys(Invoice::searchForStatus($filter_q)));
                        }
                    } else {
                        if ($i == 0) {
                            $query->where($key, 'LIKE', '%' . $filter_q . '%');
                        } else {
                            $query->orWhere($key, 'LIKE', '%' . $filter_q . '%');
                        }
                    }
                    $i++;
                }
            });
        }
    }

}
