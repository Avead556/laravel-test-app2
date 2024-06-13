<?php

namespace App\Service;

use App\Models\Post;
use App\Repository\PostRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

readonly class PostService
{
    public function __construct(private PostRepository $postRepository)
    {

    }

    public function getPaginate(int $page = 10): LengthAwarePaginator
    {
        return $this->postRepository->paginate($page);
    }

    public function create(array $data): ?Post
    {
        try {
            return $this->postRepository->store($data);
        } catch (\Throwable $e) {
            Log::critical('[POST CREATE] error:' . $e->getMessage());
        }

        return null;
    }

    public function getById(int $postId): Post
    {
        return $this->postRepository->find($postId);

    }

    public function update(int $postId, array $data): bool
    {
        try {
            $this->postRepository->update($postId, $data);

            return true;
        } catch (\Throwable $e) {
            Log::critical('[POST Update] error:' . $e->getMessage());
        }
        return false;
    }

    public function delete(int $postId): void
    {
        $this->postRepository->delete($postId);
    }
}
