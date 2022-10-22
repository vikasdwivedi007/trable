<?php


namespace App\QueryFilters;

use Closure;

class Order
{

    public function handle($request, Closure $next)
    {
        if (!request()->has('order') || !request('order') || !request('columns') || !isset(request('columns')[request('order')[0]['column']]['data'])) {
            return $next($request);
        }
        $order_by = request('columns')[request('order')[0]['column']]['data'];
        $order = request('order')[0]['dir'];
        
        $builder = $next($request);
        return $builder->orderBy($order_by, $order);
    }

}
