<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;

class TeamController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'search' => 'nullable|string|max:255',
            'sortField' => 'nullable|in:name,created_at', // Field yang valid untuk sort
            'sortDirection' => 'nullable|in:asc,desc',    // Arah sort yang valid
        ]);

        $searchTerm = $validated['search'] ?? null;
        $sortField = $validated['sortField'] ?? 'name';
        $sortDirection = $validated['sortDirection'] ?? 'asc';

        $teams = Team::query()
            ->search($searchTerm)
            ->sort($sortField, $sortDirection)
            ->with(['leader', 'members']) // Mengambil data leader dan members
            ->get(); // Mengambil semua data tanpa pagination

        return response()->json([
            'data' => $teams,
        ]);
    }
}
