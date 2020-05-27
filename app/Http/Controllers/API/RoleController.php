<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserRoleResource;
use App\UserRole;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function __invoke()
    {
        return UserRoleResource::collection(UserRole::all());
    }
}
