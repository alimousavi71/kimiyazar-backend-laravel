<?php

namespace App\Http\Controllers\Examples;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class UsersController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index()
    {
        $perPage = request()->get('per_page', 10);
        $currentPage = request()->get('page', 1);

        // Example data collection (replace with your actual query)
        $items = collect([
            ['id' => 1, 'name' => 'John Doe', 'email' => 'john.doe@example.com', 'role' => 'admin', 'status' => 'active', 'created' => '2024-01-15'],
            ['id' => 2, 'name' => 'Jane Smith', 'email' => 'jane.smith@example.com', 'role' => 'user', 'status' => 'active', 'created' => '2024-01-20'],
            ['id' => 3, 'name' => 'Alice Brown', 'email' => 'alice.brown@example.com', 'role' => 'user', 'status' => 'pending', 'created' => '2024-02-01'],
            ['id' => 4, 'name' => 'Bob Wilson', 'email' => 'bob.wilson@example.com', 'role' => 'moderator', 'status' => 'active', 'created' => '2024-02-05'],
            ['id' => 5, 'name' => 'Charlie Davis', 'email' => 'charlie.davis@example.com', 'role' => 'user', 'status' => 'inactive', 'created' => '2024-02-10'],
            ['id' => 6, 'name' => 'Diana Prince', 'email' => 'diana.prince@example.com', 'role' => 'admin', 'status' => 'active', 'created' => '2024-02-15'],
            ['id' => 7, 'name' => 'Eve Johnson', 'email' => 'eve.johnson@example.com', 'role' => 'user', 'status' => 'active', 'created' => '2024-02-20'],
            ['id' => 8, 'name' => 'Frank Miller', 'email' => 'frank.miller@example.com', 'role' => 'moderator', 'status' => 'active', 'created' => '2024-02-25'],
            ['id' => 9, 'name' => 'Grace Lee', 'email' => 'grace.lee@example.com', 'role' => 'user', 'status' => 'pending', 'created' => '2024-03-01'],
            ['id' => 10, 'name' => 'Henry Taylor', 'email' => 'henry.taylor@example.com', 'role' => 'user', 'status' => 'active', 'created' => '2024-03-05'],
            ['id' => 11, 'name' => 'Ivy Chen', 'email' => 'ivy.chen@example.com', 'role' => 'admin', 'status' => 'active', 'created' => '2024-03-10'],
            ['id' => 12, 'name' => 'Jack White', 'email' => 'jack.white@example.com', 'role' => 'user', 'status' => 'inactive', 'created' => '2024-03-15'],
        ]);

        $total = $items->count();
        $offset = ($currentPage - 1) * $perPage;
        $itemsForCurrentPage = $items->slice($offset, $perPage)->values();

        $paginator = new LengthAwarePaginator(
            $itemsForCurrentPage,
            $total,
            $perPage,
            $currentPage,
            [
                'path' => request()->url(),
                'pageName' => 'page',
            ]
        );

        $paginator->appends(request()->except('page'));

        return view('pages.users', ['paginator' => $paginator, 'users' => $itemsForCurrentPage]);
    }
}

