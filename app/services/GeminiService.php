<?php

class GeminiService
{
    private string $apiKey;
    private string $model;
    private string $baseUrl;

    public function __construct(string $apiKey, string $model = 'gemini-1.5-flash')
    {
        $this->apiKey = $apiKey;
        $this->model = $model;
        $this->baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models';
    }

    public function generate(string $prompt): array
    {
        if (trim($this->apiKey) === '') {
            return ['status' => 'fallback', 'content' => ['summary' => 'API key Gemini belum dikonfigurasi.']];
        }

        $url = $this->baseUrl . '/' . rawurlencode($this->model) . ':generateContent?key=' . rawurlencode($this->apiKey);
        $payload = [
            'contents' => [[
                'parts' => [['text' => $prompt]],
            ]],
            'generationConfig' => [
                'temperature' => 0.4,
                'responseMimeType' => 'application/json',
            ],
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($response === false || $httpCode >= 400) {
            return ['status' => 'fallback', 'content' => ['summary' => 'Gemini API gagal merespons.']];
        }

        $decoded = json_decode($response, true);
        if (!is_array($decoded)) {
            return ['status' => 'fallback', 'content' => ['summary' => 'Response AI tidak valid.']];
        }

        $text = $decoded['candidates'][0]['content']['parts'][0]['text'] ?? null;
        if (!is_string($text)) {
            return ['status' => 'fallback', 'content' => ['summary' => 'Format response AI tidak sesuai.']];
        }

        $parsed = json_decode($text, true);
        if (!is_array($parsed)) {
            return ['status' => 'fallback', 'content' => ['summary' => 'AI mengembalikan JSON yang tidak valid.']];
        }

        return ['status' => 'success', 'content' => $parsed];
    }
}
