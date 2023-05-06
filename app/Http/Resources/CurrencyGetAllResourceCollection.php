<?php

namespace App\Http\Resources;

use App\Http\Resources\CurrencyGetAllResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class CurrencyGetAllResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray($request)
    {
        $data = $this->collection;

        $currentPage = Paginator::resolveCurrentPage() ?? 1; // Aktualna strona, domyślnie pierwsza
        $perPage = $this->perPage ?? 10; // Ilość wyników na stronie, domyślnie 10
        $pagedData = $data->slice(($currentPage - 1) * $perPage, $perPage)->all(); // Pobranie danych dla aktualnej strony
        $paginatedData = new LengthAwarePaginator($pagedData, $data->count(), $perPage, $currentPage); // Utworzenie paginacji

        return [
            'data' => CurrencyGetAllResource::collection($paginatedData),
            'links' => [
                'prev' => $paginatedData->previousPageUrl(),
                'next' => $paginatedData->nextPageUrl(),
            ],
            'meta' => [
                'current_page' => $paginatedData->currentPage(),
                'from' => $paginatedData->firstItem(),
                'last_page' => $paginatedData->lastPage(),
                'path' => Paginator::resolveCurrentPath(),
                'per_page' => $paginatedData->perPage(),
                'to' => $paginatedData->lastItem(),
                'total' => $paginatedData->total(),
            ],
        ];
    }
}
