<?php

namespace App\Ai\Agents;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\HasStructuredOutput;
use Laravel\Ai\Promptable;
use Stringable;

class DangerousQueryDetector implements Agent, HasStructuredOutput
{
    use Promptable;

    public function instructions(): Stringable|string
    {
        return <<<PROMPT
You are a SQL safety analyzer.

Analyze the SQL query and determine if it is dangerous.

Mark as:
- safe → read-only SELECT queries
- warning → heavy queries (full table scan, no WHERE)
- danger → DELETE, DROP, UPDATE without WHERE, TRUNCATE

Return structured output only.
PROMPT;
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'risk' => $schema->string()->required(),
            'reason' => $schema->string()->required(),
        ];
    }
}