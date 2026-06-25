<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'name',
        'description',
        'image'
    ];

    /**
     * Upload image and return image name
     */
    public static function uploadImage($image)
    {
        $imageName = time() . '.' . $image->extension();

        $image->move(
            public_path('images'),
            $imageName
        );

        return $imageName;
    }

    /**
     * Create a new post
     */
    public static function createPost($validatedData, $imageName = null)
    {
        return self::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'image' => $imageName
        ]);
    }

    /**
     * Update existing post
     */
    public function updatePost($validatedData, $imageName = null)
    {
        $data = [
            'name' => $validatedData['name'],
            'description' => $validatedData['description']
        ];

        if ($imageName) {
            $data['image'] = $imageName;
        }

        $this->update($data);
    }
}
