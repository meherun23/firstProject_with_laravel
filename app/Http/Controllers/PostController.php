<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function create()
    {
        return view('create');
    }

    public function ourstore(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = null;

        if ($request->hasFile('image')) {
            $imageName = Post::uploadImage(
                $request->file('image')
            );
        }

        Post::createPost(
            $validatedData,
            $imageName
        );

        return redirect()
            ->route('test')
            ->with('success', 'Post created successfully!');
    }

    public function editdata($id)
    {
        $post = Post::findOrFail($id);

        return view('edit', [
            'ourPost' => $post
        ]);
    }

    public function updatedata(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $post = Post::findOrFail($id);

        $imageName = null;

        if ($request->hasFile('image')) {
            $imageName = Post::uploadImage(
                $request->file('image')
            );
        }

        $post->updatePost(
            $validatedData,
            $imageName
        );

        return redirect()
            ->route('test')
            ->with('success', 'Post updated successfully!');
    }

    public function deletedata($id)
    {
        $post = Post::findOrFail($id);

        $post->delete();

        return redirect()
            ->route('test')
            ->with('success', 'Post deleted successfully!');
    }
}
