<?php

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

if (!function_exists('paginateCollection')) {
    /**
     * Paginate a Laravel Collection.
     *
     * @param \Illuminate\Support\Collection $collection
     * @param int $perPage
     * @param int|null $page
     * @param array $options
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    function paginateCollection($collection, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $perPage = $perPage > 0 ? $perPage : 15;
        $total = $collection->count();
        $results = $collection->slice(($page - 1) * $perPage, $perPage)->values();

        return (new LengthAwarePaginator(
            $results,
            $total,
            $perPage,
            $page,
            $options
        ))->withPath(request()->url())->withQueryString();
    }
}
