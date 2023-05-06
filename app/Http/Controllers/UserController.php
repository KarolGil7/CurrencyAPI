<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Http\Resources\UserLoginResource;
use App\Repositories\IUserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="L5 OpenApi",
 *      description="L5 Swagger OpenApi description",
 * )
 */
class UserController extends Controller
{
    public function __construct(private IUserRepository $userRepository)
    {}

    /**
    * @OA\Post(
    *     path="/api/users",
    *     tags={"Users"},
    *     description="Create new user",
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\JsonContent(
    *             @OA\Schema(
    *                 type="object",
    *                 required={"email", "password"},
    *                 @OA\Property(property="email", type="string", format="email"),
    *                 @OA\Property(property="password", type="string", minLength=8),
    *             ),
    *         ),
    *     ),
    *     @OA\Response(
    *         response=201,
    *         description="User created successfully",
    *         @OA\JsonContent(
    *             @OA\Schema(
    *                 required={"id","name","email"},
    *                 @OA\Property(property="id", type="integer"),
    *                 @OA\Property(property="name", type="string"),
    *                 @OA\Property(property="email", type="string")
    *             )
    *         )
    *     ),
    *     @OA\Response(
    *         response=422,
    *         description="Validation error"
    *     ),
    *     security={{"bearerAuth": {}}}
    * )
    */
    public function login(UserLoginRequest $request) : JsonResponse
    {

        $result = $this->userRepository->login($request);
        if ($result) {
            return response()->json($result)->setStatusCode(Response::HTTP_OK);
        }

        abort(Response::HTTP_NOT_FOUND, 'User not found');
    }
}
