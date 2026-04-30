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

        dd($result);

        //return response()->json($result);

        $prompt2 = "
Convert request into JSON:

{
  \"sql\": \"\",
  \"eloquent\": \"\",
  \"builder\": \"\"
}

Request:
{$request->prompt}

Return JSON only.
";

        $response = Ai::chat()
            ->message($prompt)
            ->send();

        return response()->json(
            json_decode($response->text(), true)
        );
    }
}