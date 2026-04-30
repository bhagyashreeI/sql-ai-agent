<?php

namespace App\Ai\Agents;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\Conversational;
use Laravel\Ai\Contracts\HasStructuredOutput;
use Laravel\Ai\Contracts\HasTools;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Messages\Message;
use Laravel\Ai\Promptable;
use Stringable;

class SqlQueryAgent implements Agent, HasStructuredOutput
{
    use Promptable;

    /**
     * Get the instructions that the agent should follow.
     */
    public function instructions(): Stringable|string
    {
        return <<<PROMPT
You are an expert SQL and Laravel Eloquent assistant.

Your task is to convert user natural language requests into:

1. Optimized MySQL SQL query
2. Equivalent Laravel Eloquent query
3. Query risk level
4. Short explanation

Rules:
- Use MySQL syntax only
- Prefer safe SELECT queries
- Never generate DROP, DELETE, TRUNCATE unless explicitly requested
- Add LIMIT when useful
- Detect dangerous or full-table queries
- Use Laravel best practices in Eloquent
- Return only structured output
PROMPT;
    }

    /**
     * Get structured output schema.
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'sql' => $schema->string()->required(),
            'eloquent' => $schema->string()->required(),
            'risk' => $schema->string()
               // ->enum('safe', 'warning', 'danger')
                ->required(),
            'explanation' => $schema->string()->required(),
        ];
    }
}
