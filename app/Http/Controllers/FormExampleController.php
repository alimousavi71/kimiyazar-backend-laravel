<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class FormExampleController extends Controller
{
    /**
     * Handle form submission
     */
    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'birthdate' => 'nullable|date',
            'country' => 'required|string',
            'user_id' => 'nullable|integer',
            'skills' => 'nullable|array',
            'skills.*' => 'string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'documents' => 'nullable|array',
            'documents.*' => 'file|mimes:pdf,doc,docx|max:5120',
            'bio' => 'nullable|string|max:1000',
            'website' => 'nullable|url|max:255',
            'terms' => 'required|accepted',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();
        $uploadedFiles = [];

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatarPath = $avatar->store('avatars', 'public');
            $uploadedFiles['avatar'] = $avatarPath;
            $data['avatar_path'] = $avatarPath;
        }

        // Handle documents upload
        if ($request->hasFile('documents')) {
            $documents = [];
            foreach ($request->file('documents') as $document) {
                $docPath = $document->store('documents', 'public');
                $documents[] = [
                    'name' => $document->getClientOriginalName(),
                    'path' => $docPath,
                    'size' => $document->getSize(),
                ];
            }
            $uploadedFiles['documents'] = $documents;
            $data['documents'] = $documents;
        }

        // In a real application, you would save this data to the database
        // For now, we'll just return the processed data

        return response()->json([
            'success' => true,
            'message' => 'Form submitted successfully!',
            'data' => $data,
            'uploaded_files' => $uploadedFiles,
        ], 200);
    }

    /**
     * Search users for Select2 remote API
     */
    public function searchUsers(Request $request)
    {
        $search = $request->get('q', '');
        $limit = $request->get('limit', 10);

        // Simulate user data (in real app, query from database)
        $allUsers = [
            ['id' => 1, 'name' => 'John Doe', 'email' => 'john@example.com'],
            ['id' => 2, 'name' => 'Jane Smith', 'email' => 'jane@example.com'],
            ['id' => 3, 'name' => 'Bob Johnson', 'email' => 'bob@example.com'],
            ['id' => 4, 'name' => 'Alice Williams', 'email' => 'alice@example.com'],
            ['id' => 5, 'name' => 'Charlie Brown', 'email' => 'charlie@example.com'],
            ['id' => 6, 'name' => 'Diana Prince', 'email' => 'diana@example.com'],
            ['id' => 7, 'name' => 'Edward Norton', 'email' => 'edward@example.com'],
            ['id' => 8, 'name' => 'Fiona Apple', 'email' => 'fiona@example.com'],
        ];

        // Filter users based on search query
        $filteredUsers = collect($allUsers)->filter(function ($user) use ($search) {
            if (empty($search)) {
                return true;
            }
            return stripos($user['name'], $search) !== false ||
                stripos($user['email'], $search) !== false;
        })->take($limit)->values();

        return response()->json([
            'data' => $filteredUsers->toArray()
        ]);
    }
}
