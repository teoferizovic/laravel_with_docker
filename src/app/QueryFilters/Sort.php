<?php

namespace App\QueryFilters;

use Closure;

class Sort extends Filter
{
	protected function applyFilter($builder) {
		return (request()->sort == 'desc') ? $builder->sortByDesc('id') : $builder->sortBy('id');
	}
}