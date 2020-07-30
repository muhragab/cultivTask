<?php

namespace App\Http\Controllers\V1\API\Admin\Auth;

use App\Http\Requests\V1\API\CreateAdminAPIRequest;
use App\Http\Requests\V1\API\LoginRequest;
use App\Http\Requests\V1\API\UpdateAdminAPIRequest;
use Auth;
use App\Repositories\V1\AdminRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class AdminController
 * @package App\Http\Controllers\V1\API
 */
class AdminAuthAPIController extends AppBaseController
{
    /** @var  AdminRepository */
    private $adminRepository;

    public function __construct(AdminRepository $adminRepo)
    {
        $this->adminRepository = $adminRepo;
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
        if (!$token = Auth::guard('admins')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return $this->sendError(__('messages.errorLogin', ['model' => __('models/users.singular')]), 401);
        } else{
            return $this->sendResponse([
                'admin' => auth()->guard('admins')->user(),
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
    public function store(CreateAdminAPIRequest $request)
    {
        $input = $request->all();
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $image = time() . '.' . $file->getClientOriginalExtension();
            $request['avatar']->move(public_path('admin/avatar/'), $image);
            $avatar = asset('admin/avatar/' . $image);
        }
        $input['avatar'] = $avatar;
        $admin = $this->adminRepository->create($input);

        return $this->sendResponse(
            $admin->toArray(),
            __('messages.saved', ['model' => __('models/admins.singular')])
        );
    }
}
