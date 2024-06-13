<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Service\PostService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;


class PostController extends Controller
{
    const  PAGINATION_LIMIT = 10;

    public function __construct(private readonly PostService $postService)
    {
    }

    public function index(): View
    {
        return view('posts.index', [
            'posts' => $this->postService->getPaginate(self::PAGINATION_LIMIT)
        ]);
    }

    public function create(): View
    {
        return view('posts.create');
    }

    public function store(PostRequest $request): JsonResponse
    {
        $post = $this->postService->create($request->validated());

        if ($post) {
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }

    public function show(int $postId): JsonResponse
    {
        return response()->json($this->postService->getById($postId));
    }

    public function update($postId, PostRequest $request): JsonResponse
    {
        $result = $this->postService->update($postId, $request->validated());


        return response()->json(['success' => $result]);
    }

    public function destroy(int $postId): JsonResponse
    {
        $this->postService->delete($postId);

        return response()->json(['success' => true]);
    }
}
