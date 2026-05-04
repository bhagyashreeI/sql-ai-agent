<?php

namespace App\Ai\Agents;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\HasStructuredOutput;
use Laravel\Ai\Promptable;
use Stringable;

class EloquentConverter implements Agent, HasStructuredOutput
{
    use Promptable;

    /**
     * Instructions for AI
     */
    public function instructions(): Stringable|string
    {
        return <<<PROMPT
You are an expert Laravel developer.

Your task is to convert a given MySQL SQL query into an equivalent Laravel Eloquent query.

Rules:
- Use proper Laravel Eloquent syntax
- Assume model names are singular and PascalCase (e.g., users → User, orders → Order)
- Use query builder methods like select(), where(), join(), groupBy(), orderBy()
- Avoid raw SQL unless absolutely necessary
- Keep the query clean and readable
- Return only Eloquent query code (no explanation)

PROMPT;
    }

    /**
     * Structured Output Schema
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'eloquent' => $schema->string()->required(),
        ];
    }
}