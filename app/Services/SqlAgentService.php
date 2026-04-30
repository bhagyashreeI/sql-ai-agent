<?php

namespace App\Services;

use Prism\Prism\Facades\Prism;

class SqlAgentService
{
    public function generate(string $prompt): array
    {
        $finalPrompt = "
You are a senior Laravel database expert.

Convert user request into JSON format:

{
  \"sql\": \"\",
  \"builder\": \"\",
  \"eloquent\": \"\"
}

Rules:
- Use MySQL syntax
- Use Laravel 13 syntax
- No explanation text
- Return only JSON

User Request: {$prompt}
";

        $response = Prism::text()
            ->using('openai', 'gpt-4o-mini')
            ->withPrompt($finalPrompt)
            ->asText();

        return json_decode($response, true);
    }
}