<?php


namespace App\QueryFilters;

use Closure;

class FilterByRelationship
{

    public function handle($request, Closure $next){
        if( ! request()->has('filter_by_r') || ! request()->has('filter_q_r')
            || stripos(request()->filter_by_r, '.') === false ){
            return $next($request);
	    }
        $filter_by = request()->filter_by_r;
        $filter_q = request()->filter_q_r;
        $relation = explode('.', $filter_by)[0];
        $filter_by = explode('.', $filter_by)[1];

        $builder = $next($request);
        if(in_array($filter_by, ['name', 'title'])){
            return $builder->whereHas($relation, function($query) use($filter_by, $filter_q){
                $query->where($filter_by, 'LIKE', '%'. $filter_q .'%');
            });
        }else{
            return $builder->whereHas($relation, function($query) use($filter_by, $filter_q){
                $query->where($filter_by, '=', $filter_q);
            });
        }
    }

}
