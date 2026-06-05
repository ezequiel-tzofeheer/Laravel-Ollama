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
        $response = Http::withToken(config('ollama.api.key'))
                    ->post('https://ollama.com/api/generate', [
                        "model" => "minimax-m3:cloud",
                        "prompt" => $request->prompt,
                        "stream" => false
                    ])
                    ->json();

        return $response['response'];
    }

    /**
     * Send a prompt to the Ollama chat API and return the complete AI-generated response.
     *
     * Parses the streamed NDJSON response and merges all content chunks into a single string.
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

    /**
     * Handles tool-calling requests with Ollama and returns the final AI response.
     *
     * @param Request $request
     * @return array|null
     */
    public function toolCalling(Request $request)
    {
        $response = Http::withToken(config('ollama.api.key'))
        ->post('http://host.docker.internal:11434/api/chat', [
            "model" => "minimax-m3:cloud",
            "messages" => [
                [
                    "role"      => "user",
                    "content"   => $request->prompt
                ]
            ],
            "stream" => false,
            "tools" => [
                [
                    "type" => "function",
                    "function" => [
                        "name" => "get_cnpj",
                        "description" => "Obtenha os dados de um CNPJ.",
                        "parameters" => [
                            "type" => "object",
                            "required" => [
                                "cnpj"
                            ],
                            "properties" => [
                                "cnpj" => [
                                    "type" => "string",
                                    "description" => "Dados do CNPJ"
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]);

        $toolCalls = $response->json('message.tool_calls') ?? [];

        foreach ($toolCalls as $toolCall) {

            $functionName = $toolCall['function']['name'];
            $arguments = $toolCall['function']['arguments'];

            if ($functionName == 'get_cnpj') {

                $cnpj = $arguments['cnpj'];
                $result = $this->getCnpj($cnpj);

                $messages = [
                    [
                        "role"          => "system",
                        "content"       => 'Você é um assistente e responde sempre em português do Brasil.'
                    ],
                    [
                        "role"          => "user",
                        "content"       => $request->prompt
                    ],
                    [
                        "role"          => "assistant",
                        "content"       => "",
                        "tool_calls"    => $toolCalls
                    ],
                    [
                        "role"          => "tool",
                        "name"          => "get_cnpj",
                        "content"       => json_encode($result)
                    ]
                ];

                $finalResponse = Http::post(
                    'http://host.docker.internal:11434/api/chat',
                    [
                        "model" => "minimax-m3:cloud",
                        "messages" => $messages,
                        "stream" => false
                    ]
                );

                return $finalResponse->json();

            }

        }
    }

    /**
     * Retrieves company data from the public CNPJ API.
     *
     * @param string $cnpj
     * @return array
     */
    public function getCnpj($cnpj)
    {
        $response = Http::get("https://publica.cnpj.ws/cnpj/$cnpj")->json();

        return [
            'Razão Social'      => $response['razao_social'] ?? null,
            'Capital Social'    => $response['capital_social'] ?? null,
            'MEI'               => $response['simples']['mei'] ?? null,
            'Simples Nacional'  => $response['simples']['simples'] ?? null,
        ];
    }
}
