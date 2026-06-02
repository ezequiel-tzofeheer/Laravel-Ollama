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

}
