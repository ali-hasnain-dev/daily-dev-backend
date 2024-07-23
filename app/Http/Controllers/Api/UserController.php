<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function updateProfileImage(Request $request)
    {
        $playload = $request->validate([
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,webp,svg,gif|max:2048',
        ]);

        try {
            $user = $request->user();
            $filename = $playload['profile_image']->store('images_' . $user->id, 'public');
            User::where('id', $user->id)->update(['profile_image' => $filename]);
            return response()->json(['message' => 'Profile image updated successfully', 'image' => $filename], 200);
        } catch (\Exception $th) {
            Log::info('Update profile error: ' . $th->getMessage());
            return response()->json(['message' => 'Something went wrong try again later'], 500);
        }
    }
}