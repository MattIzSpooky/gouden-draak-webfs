<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Requests\API\UserCreateRequest;
use App\Http\Requests\API\UserUpdateRequest;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Contracts\Routing\ResponseFactory;

class UserController extends Controller
{
    private $response;

    /**
     * Constructor
     *
     * @param ResponseFactory $response
     */
    public function __construct(ResponseFactory $response)
    {
        $this->response = $response;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return UserResource::collection(User::paginate())->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserCreateRequest $request, Hasher $hasher)
    {
        $user = User::create([
            'name' =>  $request->input('name'),
            'badge' =>  $request->input('badge'),
            'user_role_id' =>  $request->input('userRoleId'),
            'password' => $hasher->make($request->input('password')),
        ]);

        return (new UserResource($user))->response();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(User $user)
    {
        return (new UserResource($user))->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserUpdateRequest $request
     * @param \App\User $user
     * @param Hasher $hasher
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserUpdateRequest $request, User $user, Hasher $hasher)
    {
        $password = $request->input('password') != null
            ? $hasher->make($request->input('password'))
            : $user->getAuthPassword();

        return $user->update([
            'name' => $request->input('name'),
            'badge' => $request->input('badge'),
            'password' =>  $password,
            'user_role_id' => $request->input('userRoleId'),
        ]) ? $this->response->json(['message' => 'Successful updated'], Response::HTTP_OK)
            : $this->response->json(['message' => 'Something went wrong'], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user)
    {
        return $user->delete()
            ? $this->response->json(['message' => 'Successful deleted'], Response::HTTP_OK)
            : $this->response->json(['message' => 'Something went wrong'], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
