<?php

namespace App\Http\Controllers\V1\API\User;

use App\Http\Requests\V1\API\UserPostAPIRequest;
use App\Http\Requests\V1\API\UpdatePostAPIRequest;
use App\Models\V1\Post;
use App\Repositories\V1\PostRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class PostController
 * @package App\Http\Controllers\V1\API
 */
class PostAPIController extends AppBaseController
{
    /** @var  PostRepository */
    private $postRepository;

    public function __construct(PostRepository $postRepo)
    {
        $this->postRepository = $postRepo;
    }

    /**
     * Display a listing of the Post.
     * GET|HEAD /posts
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {

        $posts = $this->postRepository->all(['user_id' => auth()->user()->id]);

        return $this->sendResponse(
            $posts->toArray(),
            __('messages.retrieved', ['model' => __('models/posts.plural')])
        );
    }

    /**
     * Store a newly created Post in storage.
     * POST /posts
     *
     * @param UserPostAPIRequest $request
     *
     * @return Response
     */
    public function store(UserPostAPIRequest $request)
    {
        $input = $request->all();
        $input['user_id'] = auth()->user()->id;
        $post = $this->postRepository->create($input);

        return $this->sendResponse(
            $post->toArray(),
            __('messages.saved', ['model' => __('models/posts.singular')])
        );
    }

    /**
     * Display the specified Post.
     * GET|HEAD /posts/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Post $post */
        $post = $this->postRepository->find($id);

        if (empty($post)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/posts.singular')])
            );
        }

        if ($post->user_id != auth()->user()->id) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/posts.singular')])
            );
        }


        return $this->sendResponse(
            $post->toArray(),
            __('messages.retrieved', ['model' => __('models/posts.singular')])
        );
    }

    /**
     * Update the specified Post in storage.
     * PUT/PATCH /posts/{id}
     *
     * @param int $id
     * @param UpdatePostAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UserPostAPIRequest $request)
    {
        $input = $request->all();

        /** @var Post $post */
        $post = $this->postRepository->find($id);

        if (empty($post)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/posts.singular')])
            );
        }
        if ($post->user_id != auth()->user()->id) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/posts.singular')])
            );
        }

        $post = $this->postRepository->update($input, $id);

        return $this->sendResponse(
            $post->toArray(),
            __('messages.updated', ['model' => __('models/posts.singular')])
        );
    }

    /**
     * Remove the specified Post from storage.
     * DELETE /posts/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Post $post */
        $post = $this->postRepository->find($id);

        if (empty($post)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/posts.singular')])
            );
        }

        if ($post->user_id != auth()->user()->id) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/posts.singular')])
            );
        }


        $post->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/posts.singular')])
        );
    }
}
