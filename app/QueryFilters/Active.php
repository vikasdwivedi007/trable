<?php


namespace App\QueryFilters;

use Closure;

class Active
{

    public function handle($request, Closure $next){
        if( ! request()->has('active') || !in_array(request()->active, [0,1])){
            return $next($request);
	    }

        $builder = $next($request);
        return $builder->where('active', request()->active);
    }

}
