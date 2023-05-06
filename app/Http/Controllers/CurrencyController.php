<?php

namespace App\Http\Controllers;

use App\Exceptions\CurrencyExistsException;
use App\Http\Requests\CurrencyAddRequest;
use App\Http\Requests\CurrencyGetAllRequest;
use App\Http\Requests\CurrencyGetRequest;
use App\Http\Resources\CurrencyGetAllResourceCollection;
use App\Models\Currency;
use App\Repositories\ICurrencyRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

/**
 * @group Currency
 */
class CurrencyController extends Controller
{
    public function __construct(
        private ICurrencyRepository $currencyRepository
    )
    {}


    public function getAll(CurrencyGetAllRequest $request) : JsonResponse
    {
        $result = $this->currencyRepository->getAll($request);
        return response()->json(new CurrencyGetAllResourceCollection($result))->setStatusCode(Response::HTTP_OK);
    }

    public function get(CurrencyGetRequest $request): JsonResponse
    {
        $result = $this->currencyRepository->get($request);
        return response()->json($result)->setStatusCode(Response::HTTP_OK);
    }

    public function add(CurrencyAddRequest $request): JsonResponse
    {
        try {
            $result = $this->currencyRepository->add($request);
            return response()->json($result)->setStatusCode(Response::HTTP_CREATED);
        } catch (CurrencyExistsException $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
