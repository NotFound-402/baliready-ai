<?php

return [
    'api_key' => getenv('GEMINI_API_KEY') ?: ($_ENV['GEMINI_API_KEY'] ?? ''),
    'model' => getenv('AI_MODEL') ?: ($_ENV['AI_MODEL'] ?? 'gemini-1.5-flash'),
    'base_url' => 'https://generativelanguage.googleapis.com/v1beta/models',
];
