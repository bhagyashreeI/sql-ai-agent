<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ai\Agents\{
    SqlQueryAgent,
    DangerousQueryDetector,
    QueryOptimizer,
    EloquentConverter,
    SqlAssistantAgent
};
use Laravel\Ai\Exceptions\RateLimitedException;

class AiQueryController extends Controller
{
    public function generate(Request $request)
    {
        $prompt = $request->input('prompt');

        //Generate SQL
        $sqlResult = (new SqlQueryAgent())->prompt($prompt);
        $sql = $sqlResult['sql'] ?? '';

        //Detect Risk
        $riskResult = (new DangerousQueryDetector())->prompt($sql);
        $risk = $riskResult['risk'] ?? 'warning';

        //Block dangerous queries
        if ($risk === 'danger') {
            return response()->json([
                'blocked' => true,
                'message' => 'Dangerous query detected',
                'reason' => $riskResult['reason'] ?? '',
                'sql' => $sql
            ], 403);
        }

        //Auto-Fix if Warning
        $finalSql = $sql;
        $autoFix = false;
        $notes = null;

        if ($risk === 'warning') {
            $optimized = (new QueryOptimizer())->prompt($sql);

            $finalSql = $optimized['optimized_sql'] ?? $sql;
            $notes = $optimized['improvements'] ?? '';
            $autoFix = true;
        }

        //Convert SQL to Eloquent
        $eloquentResult = (new EloquentConverter())->prompt($finalSql);

        $eloquent = $eloquentResult['eloquent'] ?? '';

        //Final Response
        return response()->json([
            'blocked' => false,
            'auto_fix' => $autoFix,
            'sql' => $finalSql,
            'eloquent' => $eloquent,
            'notes' => $notes,
            'risk' => $riskResult,
        ]);
    }

    public function generate_using_singleAgent(Request $request)
    {
        $prompt = $request->input('prompt');

        try {
            // First attempt
            $result = (new SqlAssistantAgent())->prompt($prompt);

        } catch (RateLimitedException $e) {

            //Wait before retry (1–2 min → we simulate with shorter delay for UX)
            sleep(15);

            try {
                //Retry once
                $result = (new SqlAssistantAgent())->prompt($prompt);

            } catch (RateLimitedException $e) {

                //Still failing → return friendly message
                return response()->json([
                    'error' => true,
                    'message' => 'AI is currently busy due to high usage. Please try again in 1–2 minutes.',
                ], 429);
            }
        }

        //Block dangerous queries
        if (($result['risk'] ?? '') === 'danger') {
            return response()->json([
                'blocked' => true,
                'message' => 'Dangerous query detected',
                'data' => $result
            ], 403);
        }

        return response()->json([
            'blocked' => false,
            'data' => $result
        ]);
    }
}