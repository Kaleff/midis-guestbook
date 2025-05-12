<?php

namespace App\Http\Controllers;

use App\Http\Requests\DestroyPostRequest;
use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $pagination = Post::orderBy('created_at', 'desc')->paginate(10);
        return Inertia::render('Welcome', [
            'message' => $request->input('message'),
            'success' => $request->input('success'),
            'pagination' => $pagination,
        ]);
    }

    public function store(StorePostRequest $request)
    {
        $postData = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'text' => $request->input('text'),
            'ip_address' => $request->ip(),
        ];

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('post-images', 'public');
            $postData['image'] = $path;
        }

        Post::create($postData);

        return to_route('home');
    }

    public function destroy(DestroyPostRequest $request)
    {
        $post = Post::findOrFail($request->input('id'));

        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return to_route('home');
    }
}
