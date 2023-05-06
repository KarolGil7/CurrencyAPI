<?php

namespace App\Repositories;

use App\Http\Requests\CurrencyAddRequest;
use App\Http\Requests\CurrencyGetAllRequest;
use App\Http\Requests\CurrencyGetRequest;
use App\Http\Requests\UserLoginRequest;
use App\Http\Resources\CurrencyGetAllResourceCollection;
use App\Http\Resources\UserLoginResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

interface ICurrencyRepository
{
    public function getAll(CurrencyGetAllRequest $request): ResourceCollection;
    public function get(CurrencyGetRequest $request): JsonResource;
    public function add(CurrencyAddRequest $request): JsonResource;
}
