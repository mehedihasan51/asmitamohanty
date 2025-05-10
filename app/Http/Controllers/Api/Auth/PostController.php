<?php

namespace App\Http\Controllers\Api\Auth;

use App\Helpers\Helper;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Reach;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::select('id', 'title', 'image', 'content', 'user_id', 'created_at')
            ->with(['User:id,name,avatar,referral_code'])
            ->where('user_id', auth('api')->user()->id)
            ->orderBy('id', 'desc')
            ->get();

        $data = [
            'posts' => $posts
        ];

        return Helper::jsonResponse(true, 'Posts fetched successfully', 200, $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'             => 'nullable|string|max:255',
            'image'             => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'content'           => 'required'
        ]);

        if ($validator->fails()) {
            return Helper::jsonResponse(false, 'Validation failed', 422, $validator->errors());
        }

        try {
            // Retrieve validated data from the validator
            $data = $validator->validated();

            $post = new Post();
            $post->user_id = auth('api')->user()->id;

            // Handle the thumbnail upload
            if ($request->hasFile('image')) {
                $data['image'] = Helper::fileUpload($request->file('image'), 'posts', time() . '_' . getFileName($request->file('image')));
            }

            // Generate slug and ensure it's unique
            do {
                $slug = Str::random(6);
            } while (Post::where('slug', $slug)->exists());

            $post->slug = $slug;

            // Fill product details
            $post->title = $data['title'] ?? null;
            $post->image = $data['image'] ?? null;
            $post->content = $data['content'];
            $post->save();

            // Retrieve the product along with associated category and images
            $post = Post::select('id', 'title', 'content', 'image', 'created_at')->find($post->id);

            // Return the response
            $data = [
                'post' => $post
            ];

            return Helper::jsonResponse(true, 'Post created successfully', 200, $data);
        } catch (Exception $e) {
            return Helper::jsonResponse(false, 'An error occurred while creating the new post', 500, ['error' => $e->getMessage()]);
        }
    }


    public function show(Post $post, $id)
    {
        $post = Post::where('id', $id)
        ->with(['User:id,name,avatar,referral_code'])
        ->get();
        return Helper::jsonResponse(true, 'Posts fetched successfully', 200, $post);
    }

    public function edit(Post $post, $id)
    {
        $posts = Post::where('user_id', auth('api')->user()->id)->where('id', $id)->get();
        return Helper::jsonResponse(true, 'Posts fetched successfully', 200, $posts);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $validator = Validator::make($request->all(), [
            'title'             => 'nullable|string|max:255',
            'image'             => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'content'           => 'required'
        ]);

        if ($validator->fails()) {
            return Helper::jsonResponse(false, 'Validation failed', 422, $validator->errors());
        }

        try {
            // Retrieve validated data from the validator
            $data = $validator->validated();

            $post = Post::where('user_id', auth('api')->user()->id)->find($request->id);
            if ($post->user_id != auth('api')->user()->id) {
                return Helper::jsonResponse(false, 'You are not authorized to update this product', 401);
            }

            // Handle the thumbnail upload
            if ($request->hasFile('image')) {
                $data['image'] = Helper::fileUpload($request->file('image'), 'posts', time() . '_' . getFileName($request->file('image')));
            }

            // Fill product details
            $post->title = $data['title'] ?? null;
            $post->image = $data['image'] ?? null;
            $post->content = $data['content'];
            $post->save();

            $post = Post::select('id', 'title', 'content', 'image', 'created_at')->find($post->id);

            // Return the response
            $data = [
                'post' => $post
            ];

            return Helper::jsonResponse(true, 'Post created successfully', 200, $data);
        } catch (Exception $e) {
            return Helper::jsonResponse(false, 'An error occurred while creating the new product', 500, ['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $post = Post::where('user_id', auth('api')->user()->id)->find($id);

        if (!$post) {
            return Helper::jsonResponse(false, 'Post not found', 404);
        }

        if ($post->user_id !== auth('api')->user()->id) {
            return Helper::jsonResponse(false, 'You are not authorized to delete this post', 403);
        }

        $post->delete();

        return Helper::jsonResponse(true, 'Post deleted successfully', 200);
    }

    //like toggle
    public function toggle($post_id) {
        try{
            $reach_exist = Reach::where('reachable_id', $post_id)->where('user_id', auth('api')->user()->id)->where('reachable_type', 'App\Models\Post')->first();
            if ($reach_exist) {
                $reach_exist->delete();
                return Helper::jsonResponse(true, 'Post removed from favorites successfully', 200);
            } else {
                Reach::create([
                    'user_id' => auth('api')->user()->id,
                    'reachable_id' => $post_id,
                    'reachable_type' => 'App\Models\Post'
                ]);
                return Helper::jsonResponse(true, 'Post added to favorites successfully', 200);
            }
        } catch (Exception $e) {
            return Helper::jsonResponse(false, $e->getMessage(), 500);
        }
    }

    public function commentStore(Request $request) {
        $validator = Validator::make($request->all(), [
            'post_id' => 'required|exists:posts,id',
            'comment' => 'required'
        ]);

        if ($validator->fails()) {
            return Helper::jsonResponse(false, 'Validation failed', 422, $validator->errors());
        }

        try {
            Comment::create([
                'post_id' => $request->post_id,
                'user_id' => auth('api')->user()->id,
                'comment' => $request->comment
            ]);

            return Helper::jsonResponse(true, 'Comment added successfully', 200);
        } catch (Exception $e) {
            return Helper::jsonResponse(false, $e->getMessage(), 500);
        }
    }

    public function commentToggle($comment_id) {
        try{
            $reach_exist = Reach::where('reachable_id', $comment_id)->where('user_id', auth('api')->user()->id)->where('reachable_type', 'App\Models\Comment')->first();
            if ($reach_exist) {
                $reach_exist->delete();
                return Helper::jsonResponse(true, 'Comment removed from favorites successfully', 200);
            } else {
                Reach::create([
                    'user_id' => auth('api')->user()->id,
                    'reachable_id' => $comment_id,
                    'reachable_type' => 'App\Models\Comment'
                ]);
                return Helper::jsonResponse(true, 'Comment added to favorites successfully', 200);
            }
        } catch (Exception $e) {
            return Helper::jsonResponse(false, $e->getMessage(), 500);
        }
    }

    public function commentDelete($comment_id)
    {
        $comment = Comment::where('id', $comment_id)->where('user_id', auth('api')->user()->id)->first();

        if (!$comment) {
            return Helper::jsonResponse(false, 'Comment not found', 404);
        }

        if ($comment->user_id !== auth('api')->user()->id) {
            return Helper::jsonResponse(false, 'You are not authorized to delete this comment', 403);
        }

        $comment->delete();

        return Helper::jsonResponse(true, 'Comment deleted successfully', 200);
    }

    public function replyStore(Request $request) {
        $validator = Validator::make($request->all(), [
            'post_id' => 'required|exists:posts,id',
            'parent_id' => 'nullable|exists:comments,id',
            'comment' => 'required'
        ]);

        if ($validator->fails()) {
            return Helper::jsonResponse(false, 'Validation failed', 422, $validator->errors());
        }

        try {
            Comment::create([
                'post_id' => $request->post_id,
                'user_id' => auth('api')->user()->id,
                'comment' => $request->comment,
                'parent_id' => $request->parent_id
            ]);

            return Helper::jsonResponse(true, 'Reply added successfully', 200);
        } catch (Exception $e) {
            return Helper::jsonResponse(false, $e->getMessage(), 500);
        }
    }

    public function replyToggle($comment_id) {
        try{
            $reach_exist = Reach::where('reachable_id', $comment_id)->where('user_id', auth('api')->user()->id)->where('reachable_type', 'App\Models\Comment')->first();
            if ($reach_exist) {
                $reach_exist->delete();
                return Helper::jsonResponse(true, 'Reply removed from favorites successfully', 200);
            } else {
                Reach::create([
                    'user_id' => auth('api')->user()->id,
                    'reachable_id' => $comment_id,
                    'reachable_type' => 'App\Models\Comment'
                ]);
                return Helper::jsonResponse(true, 'Reply added to favorites successfully', 200);
            }
        } catch (Exception $e) {
            return Helper::jsonResponse(false, $e->getMessage(), 500);
        }
    }

    public function replyDelete($comment_id)
    {
        $comment = Comment::where('id', $comment_id)->where('user_id', auth('api')->user()->id)->first();

        if (!$comment) {
            return Helper::jsonResponse(false, 'Reply not found', 404);
        }

        if ($comment->user_id !== auth('api')->user()->id) {
            return Helper::jsonResponse(false, 'You are not authorized to delete this reply', 403);
        }

        $comment->delete();

        return Helper::jsonResponse(true, 'Reply deleted successfully', 200);
    }

}
