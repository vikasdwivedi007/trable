<?php


namespace App\QueryFilters;

use Closure;

class Paginate
{

    public function handle($request, Closure $next){
        if( ! request()->has('length') || request('length') < 0 ){
            return $next($request);
	    }
        $start = request('start') ?: 0;
        $per_page = intval(request()->length);

        $builder = $next($request);
        $builder->skip($start)->take($per_page);
        return $builder;
    }
}
