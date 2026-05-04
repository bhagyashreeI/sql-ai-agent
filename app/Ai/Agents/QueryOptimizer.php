<?php

namespace App\Ai\Agents;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\HasStructuredOutput;
use Laravel\Ai\Promptable;
use Stringable;

class QueryOptimizer implements Agent, HasStructuredOutput
{
    use Promptable;

    public function instructions(): Stringable|string
    {
        return <<<PROMPT
You are a SQL performance expert.

Given a MySQL query, rewrite it to be more efficient.

Guidelines:
- Keep the result semantics identical
- Add appropriate WHERE filters if missing (only when implied by prompt)
- Prefer indexed columns when possible (assume common indexes like id, foreign keys, created_at)
- Avoid SELECT *
- Add LIMIT where reasonable for listing queries
- Remove unnecessary joins/subqueries
- Use proper aggregation and grouping
- Keep it safe (no destructive statements)

Return only structured output.
PROMPT;
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'optimized_sql' => $schema->string()->required(),
            'improvements'  => $schema->string()->required(),
        ];
    }
}