<?php

namespace App\Http\Controllers\V1\API\Admin;

use App\Http\Requests\V1\API\CreateUserAPIRequest;
use App\Http\Requests\V1\API\UpdateUserAPIRequest;
use App\Models\V1\User;
use App\Repositories\V1\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class UserController
 * @package App\Http\Controllers\V1\API
 */
class UserAPIController extends AppBaseController
{
    /** @var  UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepository = $userRepo;
    }

    /**
     * Display a listing of the User.
     * GET|HEAD /users
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $users = $this->userRepository->all();

        return $this->sendResponse(
            $users->toArray(),
            __('messages.retrieved', ['model' => __('models/users.plural')])
        );
    }

    /**
     * Store a newly created User in storage.
     * POST /users
     *
     * @param CreateUserAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateUserAPIRequest $request)
    {
        $input = $request->all();

        $user = $this->userRepository->create($input);

        return $this->sendResponse(
            $user->toArray(),
            __('messages.saved', ['model' => __('models/users.singular')])
        );
    }

    /**
     * Display the specified User.
     * GET|HEAD /users/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var User $user */
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/users.singular')])
            );
        }

        return $this->sendResponse(
            $user->toArray(),
            __('messages.retrieved', ['model' => __('models/users.singular')])
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
    public function update($id, UpdateUserAPIRequest $request)
    {
        $input = $request->all();

        /** @var User $user */
        $user = $this->userRepository->find($id);

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

    /**
     * Remove the specified User from storage.
     * DELETE /users/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var User $user */
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/users.singular')])
            );
        }

        $user->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/users.singular')])
        );
    }
}
