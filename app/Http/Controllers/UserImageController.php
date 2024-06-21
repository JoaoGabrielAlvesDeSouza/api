<?php

namespace App\Http\Controllers;

use App\Models\UserImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserImageController extends Controller
{
    public function upload(Request $request)
    {
        // Validação da requisição
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'images' => 'required',
            'images.*' => 'image|max:2048'
        ]);

        $paths = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('images');
                $paths[] = $path;

                $userImage = new UserImage();
                $userImage->user_id = $request->user_id;
                $userImage->file_path = $path;
                $userImage->save();
            }

            return response()->json(['paths' => $paths], 200);
        }

        return response()->json(['message' => 'No images uploaded'], 400);
    }

    public function getUserImages($id)
    {
        // Busca todas as imagens associadas ao usuário
        $userImages = UserImage::where('user_id', $id)->get();

        if ($userImages->isEmpty()) {
            return response()->json(['message' => 'No images found for this user'], 404);
        }

        // Mapeia os caminhos das imagens para URLs completas
        $imageUrls = $userImages->map(function ($image) {
            return Storage::disk('public')->url($image->file_path);
        });

        return response()->json(['images' => $imageUrls], 200);
    }
}
