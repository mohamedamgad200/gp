<?php

namespace Modules\Post\App\Http\Controllers;

use App\Trait\AHM_Response;
use Illuminate\Http\Request;
use Modules\Post\App\Models\Post;
use App\Http\Controllers\Controller;
use Modules\Post\App\Http\Requests\PostRequest;
use Modules\Post\App\resources\PostResource;

class PostController extends Controller
{
    use AHM_Response;
    public function __construct()
    {
        $this->middleware('permission:show_post')->only(['index', 'show']);
        $this->middleware('permission:add_post')->only(['store']);
        $this->middleware('permission:edit_post')->only(['update']);
        $this->middleware('permission:delete_post')->only(['destroy']);
    }
    public function index()
    {
        if (Post::exists()) {
            $posts = Post::with('doctor')->paginate(PAGINATE);
            return $this->paginateResponse(PostResource::collection($posts));
        }
        return $this->NotFoundResponse();
    }
    public function show($id)
    {
        $post = Post::with('doctor')->find($id);
        if ($post) {
            return $this->GetDataResponse(PostResource::make($post));
        }
        return $this->NotFoundResponse();
    }
    public function store(PostRequest $request)
    {
        $data = $request->validated();
        $post = Post::create($data);
        if($request->hasFile('image')) {
            $post->addMediaFromRequest('image')->toMediaCollection('post_image');
        }
        if($post) {
            return $this->CreateResponse(PostResource::make($post));
        }
    }
    public function update(PostRequest $request, $id)
    {
        $post = Post::find($id);
        if(!$post) {
            return $this->NotFoundResponse();
        }
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $post->clearMediaCollection('post_image');
            $post->addMediaFromRequest('image')->toMediaCollection('post_image');
        }

        $post->update($data);
        return $this->UpdateResponse(PostResource::make($post));
    }
    public function destroy($id)
    {
        $post = Post::find($id);
        if ($post) {
            $post->delete();
            return $this->DeleteResponse();
        }
        return $this->NotFoundResponse();
    }
}
