<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ai\Agents\SqlQueryAgent;

class AiQueryController extends Controller
{
    public function generate(Request $request)
    {
        $request->validate([
            'prompt' => 'required|string'
        ]);

        $result = (new SqlQueryAgent())->prompt(
            $request->prompt
        );


        return response()->json($result);

    }
}