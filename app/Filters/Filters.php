<?php

namespace App\Filters;

use Illuminate\Http\Request;

abstract class Filters
{
    protected $request;
    protected $builder;
    protected $filters = [];

    function __construct(Request $request)
    {
        $this->request = $request;
    }

    // apply filters to the $builder
    public function apply($builder)
    {
        $this->builder = $builder;

//        dd($this->getFilters());
        foreach ($this->getFilters() as $filter=>$value) {
            if (method_exists($this, $filter)) {
                $this->$filter($this->request->$filter);
            }
        }

        //                                              or a functional approach
//        collect($this->getFilters())
//            ->filter(function($value, $filter){
//                return method_exists($this, $filter);
//            })
//            ->each(function($value, $filter){
//                $this->$filter($value);
//            });

        return $this->builder;
    }

    public function getFilters(){
        return $this->request->intersect($this->filters);
    }

}