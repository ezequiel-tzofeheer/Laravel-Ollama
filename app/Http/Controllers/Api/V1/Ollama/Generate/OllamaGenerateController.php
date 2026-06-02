<?php

namespace app\Http\Controllers\Api\V1\Ollama\Generate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;

class OllamaGenerateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
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
