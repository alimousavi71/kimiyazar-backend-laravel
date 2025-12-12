<?php

namespace App\Http\Controllers\Examples;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiExampleController extends Controller
{
    /**
     * Handle POST request from Axios form
     */
    public function store(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|min:10|max:1000',
            'age' => 'nullable|integer|min:18|max:120',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Simulate processing delay
        sleep(1);

        // Process the data (in real app, save to database, etc.)
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
            'age' => $request->age,
            'submitted_at' => now()->toDateTimeString(),
        ];

        // Return success response
        return response()->json([
            'success' => true,
            'message' => 'Form submitted successfully!',
            'data' => $data,
        ], 200);
    }

    /**
     * Handle GET request for testing
     */
    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => 'API is working!',
            'data' => [
                'timestamp' => now()->toDateTimeString(),
                'version' => '1.0.0',
            ],
        ]);
    }

    /**
     * Simulate different error responses for testing
     */
    public function testError(Request $request)
    {
        $type = $request->get('type', '500');

        switch ($type) {
            case '401':
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access',
                ], 401);

            case '403':
                return response()->json([
                    'success' => false,
                    'message' => 'Forbidden: You do not have permission',
                ], 403);

            case '404':
                return response()->json([
                    'success' => false,
                    'message' => 'Resource not found',
                ], 404);

            case '422':
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => [
                        'email' => ['The email field is required.'],
                        'name' => ['The name must be at least 3 characters.'],
                    ],
                ], 422);

            case '429':
                return response()->json([
                    'success' => false,
                    'message' => 'Too many requests',
                ], 429);

            case '500':
            default:
                return response()->json([
                    'success' => false,
                    'message' => 'Internal server error',
                ], 500);
        }
    }
}

