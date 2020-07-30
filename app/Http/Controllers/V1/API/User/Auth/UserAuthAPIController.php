<?php

namespace App\Http\Controllers\V1\API\User\Auth;

use App\Http\Requests\V1\API\CreateAdminAPIRequest;
use App\Http\Requests\V1\API\CreateUserAPIRequest;
use App\Http\Requests\V1\API\LoginRequest;
use App\Http\Requests\V1\API\UpdateUserAPIRequest;
use App\Repositories\V1\UserRepository;
use Auth;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class AdminController
 * @package App\Http\Controllers\V1\API
 */
class UserAuthAPIController extends AppBaseController
{
    /** @var  AdminRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepository = $userRepo;
    }

    /**
     * admin login.
     * POST|HEAD /admins/login
     *
     * @param Request $request
     * @return Response
     */
    public function login(LoginRequest $request)
    {
        if (!$token = Auth::guard('users')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return $this->sendError(__('messages.errorLogin', ['model' => __('models/users.singular')]), 401);
        } else {
            return $this->sendResponse([
                'user' => auth()->guard('users')->user(),
                'access_token' => $token,
                'token_type' => 'Bearer',
            ], __('messages.login', ['model' => __('models/users.singular')]));
        }

    }

    /**
     * Store a newly created Admin in storage.
     * POST /admins
     *
     * @param CreateAdminAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateUserAPIRequest $request)
    {
        $input = $request->all();
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $image = time() . '.' . $file->getClientOriginalExtension();
            $request['avatar']->move(public_path('admin/avatar/'), $image);
            $avatar = asset('admin/avatar/' . $image);
        }
        $input['avatar'] = $avatar;
        $admin = $this->userRepository->create($input);

        return $this->sendResponse(
            $admin->toArray(),
            __('messages.saved', ['model' => __('models/users.singular')])
        );
    }

    /**
     * Update the specified User in storage.
     * PUT/PATCH /users/{id}
     *
     * @param int $id
     * @param UpdateUserAPIRequest $request
     *
     * @return Response
     */
    public function update( UpdateUserAPIRequest $request)
    {
        $id =  auth()->user()->id ;
        $input = $request->all();

        /** @var User $user */
        $user = $this->userRepository->find( $id );

        if (empty($user)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/users.singular')])
            );
        }

        $user = $this->userRepository->update($input, $id);

        return $this->sendResponse(
            $user->toArray(),
            __('messages.updated', ['model' => __('models/users.singular')])
        );
    }

}
