<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::select('id', 'title', 'image', 'content', 'user_id', 'created_at')
            ->with(['User:id,name,avatar,referral_code'])
            ->orderBy('id', 'desc')
            ->paginate(12);

        $data = [
            'posts' => $posts
        ];

        return Helper::jsonResponse(true, 'Posts fetched successfully', 200, $data);
    }

    public function show(Post $post, $id)
    {
        $post = Post::select('id', 'title', 'image', 'content', 'user_id', 'created_at')
            ->with([
                'User:id,name,avatar,referral_code',
                'Comments' => function ($query) {
                    $query->whereNull('parent_id') // restrict to top-level comments only
                        ->select('id', 'user_id', 'post_id', 'parent_id', 'comment', 'created_at');
                },
                'Comments.User:id,name,avatar,referral_code',
                'Comments.Replies:id,user_id,post_id,parent_id,comment,created_at',
                'Comments.Replies.User:id,name,avatar,referral_code',
            ])
            ->find($id);

        if (!$post) {
            return Helper::jsonResponse(false, 'Post not found', 404);
        }

        $data = [
            'post' => $post
        ];

        return Helper::jsonResponse(true, 'Posts fetched successfully', 200, $data);
    }
}
