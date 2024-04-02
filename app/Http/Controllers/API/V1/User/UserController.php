<?php

namespace App\Http\Controllers\API\V1\User;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\User\UpdateUserRequest;

class UserController extends Controller
{
    public function update(UpdateUserRequest $request, User $user)
    {
        //
    }
}
