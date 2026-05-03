<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{

    /**
     * Admin: list all users.
     */
    public function index()
    {
        $users = User::with('images')->latest()->get();
        return response()->json(['status' => 'success', 'data' => $users]);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:9',
            'role' => 'nullable|string|in:admin,porter,donor',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'] ?? 'donor',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('avatars', 'public');
            $user->images()->create([
                'url' => asset('storage/' . $path)
            ]);
        }

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user->load('images'),
        ], 201);
    }


    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // 1. Try Standard User Auth
        if ($token = auth('api')->attempt($credentials)) {
            $user = auth('api')->user();
            
            if ($user->is_banned) {
                auth('api')->logout();
                return response()->json([
                    'error' => 'Your account has been banned. Please contact support.',
                    'status' => 'banned'
                ], 403);
            }
            
            return response()->json([
                'message' => 'Login successful',
                'access_token' => $token,
                'user' => $user->load('images'),
            ]);
        }

        // 2. Try Organisation Auth
        if ($token = auth('organisation')->attempt($credentials)) {
            $org = auth('organisation')->user();

            if (!$org->is_verified) {
                auth('organisation')->logout();
                return response()->json([
                    'error' => 'Your account is pending verification.',
                    'status' => 'pending'
                ], 403);
            }

            // Map for UI Compatibility
            $org->role = 'organisation';
            $org->first_name = $org->name;

            return response()->json([
                'message' => 'Organisation login successful',
                'access_token' => $token,
                'user' => $org,
            ]);
        }

        return response()->json(['error' => 'Invalid credentials'], 401);
    }

    /**
     * Get current authenticated user
     */
    public function me()
    {
        return response()->json(auth()->user()->load('images'));
    }


    public function refresh()
    {
        return response()->json([
            'token' => JWTAuth::refresh(),
        ]);
    }

    /**
     * Logout user (invalidate token)
     */
    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json(['message' => 'Logged out successfully']);
    }

    /**
     * Update user profile
     */
    public function update(Request $request)
    {
       
        $user = auth()->user();

        $validated = $request->validate([
            'first_name' => 'string|max:255',
            'last_name' => 'string|max:255',
            'email' => 'email|unique:users,email,' . $user->id,
        ]);

        $user->update($validated);

        return response()->json([
            'message' => 'User updated successfully',
            'user' => $user->load('images'),
        ]);
    }


    public function ban(User $user)
    {
        $user->update(['is_banned' => true]);

        return response()->json([
            'message' => 'User has been banned successfully',
            'user' => $user
        ]);
    }

    /**
     * Unban a user
     */
    public function unban(User $user)
    {
        $user->update(['is_banned' => false]);

        return response()->json([
            'message' => 'User has been unbanned successfully',
            'user' => $user
        ]);
    }

    /**
     * Upload user avatar
     */
    public function uploadAvatar(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        /** @var \App\Models\User $user */
        $user = auth()->user();

        // Delete old image if exists (optional but good practice)
        if ($user->images) {
            // Logic to delete physical file could go here
        }

        // Store the file in storage/app/public/avatars
        $path = $request->file('image')->store('avatars', 'public');

        // Update or create the polymorphic relationship
        $user->images()->updateOrCreate(
            [], // No unique criteria needed for morphOne update if handled by relation
            ['url' => asset('storage/' . $path)]
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Avatar uploaded successfully',
            'url' => asset('storage/' . $path)
        ]);
    }
}
