<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $pagination = Post::paginate(10);
        return Inertia::render('Welcome', [
            'message' => $request->input('message'),
            'success' => $request->input('success'),
            'pagination' => $pagination,
        ]);
    }

    public function store(StorePostRequest $request)
    {
        Post::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'text' => $request->input('text'),
            'ip_address' => $request->ip(),
        ]);

        return to_route('home', [
            'message' => 'Post created successfully',
            'success' => true,
            'page' => 1,
        ]);
    }
}
