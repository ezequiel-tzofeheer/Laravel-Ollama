<?php

namespace App\Http\Controllers\Api\V1\Ollama;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;

class OllamaController extends Controller
{
    /**
     * Generate an AI response from the provided prompt using the Ollama API.
     */
    public function generate(Request $request)
    {
        $data = Http::withToken(config('ollama.api.key'))
                    ->post('https://ollama.com/api/generate', [
                        "model" => "minimax-m3:cloud",
                        "prompt" => $request->prompt,
                        "stream" => false
                    ])
                    ->json();

        return $data['response'];
    }

    /**
     * Generate an AI response from the provided prompt using the Ollama API.
     */
    public function chat(Request $request)
    {
        $response = Http::withToken(config('ollama.api.key'))
                    ->post('https://ollama.com/api/chat', [
                        "model" => "minimax-m3:cloud",
                        "messages" => [
                        [
                            "role" => "user",
                            "content" => $request->prompt
                        ]
                      ]
                    ]);

        $chunks = explode("\n", trim($response->body()));

        $content = '';

        foreach ($chunks as $chunk) {
            $json = json_decode($chunk, true);

            if (isset($json['message']['content'])) {
                $content .= $json['message']['content'];
            }
        }

        return $content;
    }

}
