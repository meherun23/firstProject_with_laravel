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

        // safe image upload
        $imageName = null;

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
        }

        // save to DB
        $post = new Post;
        $post->name = $validatedData['name'];
        $post->description = $validatedData['description'];
        $post->image = $imageName;
        $post->save();

        return redirect()->route('test')->with('success', 'Post created successfully!');
    }

    public function editdata($id)
    {
        $post = Post::findOrFail($id);
        return view('edit', ['ourPost' => $post]);
    }

    public function updatedata(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $post = Post::findOrFail($id);

        // safe image upload
        if ($request->hasFile('image')) {
            // delete old image if exists
            if ($post->image) {
                unlink(public_path('images/' . $post->image));
            }

            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $post->image = $imageName;
        }

        // update DB
        $post->name = $validatedData['name'];
        $post->description = $validatedData['description'];
        $post->save();

        return redirect()->route('test')->with('success', 'Post updated successfully!');
    }
}
