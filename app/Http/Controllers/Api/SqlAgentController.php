<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\QueryHistory;
use App\Services\SqlAgentService;
use Illuminate\Http\Request;

class SqlAgentController extends Controller
{
    public function generate(Request $request, SqlAgentService $service)
    {
        $request->validate([
            'prompt' => 'required|string'
        ]);

        $result = $service->generate($request->prompt);

        QueryHistory::create([
            'input_text'       => $request->prompt,
            'sql_output'       => $result['sql'] ?? null,
            'builder_output'   => $result['builder'] ?? null,
            'eloquent_output'  => $result['eloquent'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'data' => $result
        ]);
    }

    public function history()
    {
        return QueryHistory::latest()->get();
    }
}
