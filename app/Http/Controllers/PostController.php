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
        $order_column = $request->input('order_column', 'created_at');
        $order_direction = $request->input('order_direction', 'desc');
        $pagination = Post::orderBy($order_column, $order_direction)->paginate(10);
        return Inertia::render('Welcome', [
            'pagination' => $pagination,
            'order_column' => $order_column,
            'order_direction' => $order_direction,
        ]);
    }

    public function indexAdmin(Request $request)
    {
        $order_column = $request->input('order_column', 'created_at');
        $order_direction = $request->input('order_direction', 'desc');
        $pagination = Post::orderBy($order_column, $order_direction)->paginate(10);
        return Inertia::render('Dashboard', [
            'pagination' => $pagination,
            'order_column' => $order_column,
            'order_direction' => $order_direction,
        ]);
    }

    public function store(StorePostRequest $request)
    {
        $post = $request->input('id')
            ? Post::where('ip_address', $request->ip())
                  ->where('created_at', '>=', now()->subMinutes(5))
                  ->findOrFail($request->input('id'))
            : new Post();
        $post->name = $request->input('name');
        $post->email = $request->input('email');
        $post->text = $request->input('text');
        $post->ip_address = $request->ip();

        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image); // Delete the old image if it exists if you are updating with new one
            }
            $path = $request->file('image')->store('post-images', 'public');
            $post->image = $path;
        }

        $post->save();

        return back();
    }

    public function destroy(DestroyPostRequest $request)
    {
        $post = Post::findOrFail($request->input('id'));

        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return back();
    }

    public function destroyAsAdmin(Request $request)
    {
        $post = Post::findOrFail($request->input('id'));

        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return back();
    }

    public function storeAsAdmin(StorePostRequest $request)
    {
        $post = Post::findOrFail($request->input('id'));
        $post->name = $request->input('name');
        $post->email = $request->input('email');
        $post->text = $request->input('text');

        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image); // Delete the old image if it exists if you are updating with new one
            }
            $path = $request->file('image')->store('post-images', 'public');
            $post->image = $path;
        }

        $post->save();

        return back();
    }
}
