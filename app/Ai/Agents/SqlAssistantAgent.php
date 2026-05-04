<?php

namespace App\Ai\Agents;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\HasStructuredOutput;
use Laravel\Ai\Promptable;
use Stringable;

class SqlAssistantAgent implements Agent, HasStructuredOutput
{
    use Promptable;

    /**
     * AI Instructions
     */
    public function instructions(): Stringable|string
    {
        return <<<PROMPT
You are an expert SQL and Laravel Eloquent assistant.

Your job is to:
1. Convert natural language → SQL query
2. Detect query risk
3. Optimize query if needed
4. Convert final SQL → Laravel Eloquent

Rules:

--- SQL Generation ---
- Use MySQL syntax
- Avoid SELECT *
- Add LIMIT for large datasets

--- Risk Detection ---
- safe → SELECT with proper WHERE/LIMIT
- warning → full table scan, missing WHERE, SELECT *
- danger → DELETE, DROP, TRUNCATE, UPDATE without WHERE

--- Optimization ---
- If risk = warning:
  - Replace SELECT * with required columns (id, name, etc.)
  - Add LIMIT (e.g., 100)
  - Improve WHERE clause if obvious
- If risk = safe:
  - Keep query as-is
- If risk = danger:
  - Do NOT optimize, just flag it

--- Eloquent Conversion ---
- Convert final SQL to Laravel Eloquent
- Use proper model naming (users → User)
- Use select(), where(), limit(), join()

Return ONLY structured JSON output.
PROMPT;
    }

    /**
     * Structured Output Schema
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'sql' => $schema->string()->required(),
            'risk' => $schema->string()->required(),
            'optimized_sql' => $schema->string()->required(),
            'eloquent' => $schema->string()->required(),
            'explanation' => $schema->string()->required(),
        ];
    }
}