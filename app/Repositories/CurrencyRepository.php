<?php

namespace App\Repositories;

use App\Exceptions\CurrencyExistsException;
use App\Http\Requests\CurrencyAddRequest;
use App\Http\Requests\CurrencyGetAllRequest;
use App\Http\Requests\CurrencyGetRequest;
use App\Http\Resources\CurrencyAddResource;
use App\Http\Resources\CurrencyGetAllResource;
use App\Http\Resources\CurrencyGetAllResourceCollection;
use App\Http\Resources\CurrencyGetResource;
use App\Models\Currency;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\DB;

class CurrencyRepository implements ICurrencyRepository
{
    public function getAll(CurrencyGetAllRequest $request): ResourceCollection
    {
        $currencies = Currency::orderByDesc('created_at')
            ->whereDate('created_at', $request->input('date'))
            ->paginate($request->input('per_page'), ['*'], 'page', $request->input('page_number'),);

        return new CurrencyGetAllResourceCollection($currencies);
    }

    public function get(CurrencyGetRequest $request): JsonResource
    {
        $currencies = Currency::where('currency_type', $request->input('currency'))
            ->whereDate('created_at', $request->input('date'))
            ->orderByDesc('created_at')
            ->first();

        return new CurrencyGetResource($currencies);
    }

    public function add(CurrencyAddRequest $request): JsonResource
    {
        $currencyType = strtoupper($request->input('currency'));
        $date = Carbon::parse($request->input('date'))->startOfDay();

        $existingCurrency = Currency::where('currency_type', $currencyType)
            ->whereDate('created_at', $date)
            ->first();

        if ($existingCurrency) {
            throw new CurrencyExistsException("Currency type $currencyType already exists for $date");
        }

        try {
            DB::beginTransaction();

            $currency = new Currency();
            $currency->currency_type = $currencyType;
            $currency->amount = $request->input('amount');
            $currency->created_at = $date;
            $currency->save();

            DB::commit();

            return new CurrencyAddResource($currency);

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
