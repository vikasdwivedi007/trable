<?php


namespace App\QueryFilters;

use Closure;

class OrderByRelation
{

    public function handle($request, Closure $next){
        if( ! request()->has('order_by_r') || stripos(request()->order_by_r, '.') === false ){
            return $next($request);
	    }
        $order_by = request()->order_by_r;
        $relation = explode('.', $order_by)[0];
        $order_by = explode('.', $order_by)[1];

        $order = 'DESC';
        if( request()->has('order_r') && in_array(request()->order_r, ['ASC', 'DESC', 'asc', 'desc'])){
            $order = request()->order_r;
        }

        $builder = $next($request);

        return $builder->orderBy($relation.'.'.$order_by, $order);
    }

}
