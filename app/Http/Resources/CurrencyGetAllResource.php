<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class CurrencyGetAllResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'currency' => Str::upper($this->currency_type),
            'date' => $this->created_at->format('Y-m-d'),
            'amount' => number_format($this->amount, 2),
        ];
    }

    public function with($request): array
    {
        $pagination = $this->request->toArray();
        $links = [
            'prev' => $pagination['prev_page_url'] ?? null,
            'next' => $pagination['next_page_url'] ?? null,
        ];
        $meta = [
            'total' => $pagination['total'] ?? 0,
            'count' => $pagination['per_page'] ?? 0,
            'per_page' => $pagination['per_page'] ?? 0,
            'current_page' => $pagination['current_page'] ?? 0,
            'total_pages' => $pagination['last_page'] ?? 0,
        ];
        return compact('links', 'meta');
    }
}
