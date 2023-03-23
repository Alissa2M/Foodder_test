<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Inertia\Inertia;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;


class ChatController extends Controller
{
    /**
     * index
     *
     * @param  Request  $request
     */
    public function index(Request $request)
    {
        return Inertia::render('Chat');
    }

    /**
     * chat
     *
     * @param  Request  $request
     */
    public function chat(Request $request)
    {

        // バリデーション
        $request->validate([
            'sentence' => 'required',
        ]);

        // 文章
        $sentence = $request->input('sentence');

        // ChatGPT API処理
        $chat_response = $this->chat_gpt("日本語で応答してください", $sentence);

        return Inertia::render('Chat', [
            'chat_response' => $chat_response,
        ]);

    }

    /**
     * ChatGPT API呼び出し
     * Laravel HTTP
     */
    function chat_gpt($system, $user)
    {
        // ChatGPT APIのエンドポイントURL
        $url = "https://api.openai.com/v1/chat/completions";

        // APIキー
        $api_key = config('services.openai.api_key');

        // ヘッダー
        $headers = array(
            "Content-Type" => "application/json",
            "Authorization" => "Bearer $api_key"
        );

        // パラメータ
        $data = array(
            "model" => "gpt-3.5-turbo",
            "temperature" => 0.7,
            "max_tokens" => 150,
            "messages" => [
                [
                    "role" => "system",
                    "content" => $system
                ],
                [
                    "role" => "user",
                    "content" => $user
                ]
            ]
        );

        $response = Http::withHeaders($headers)->post($url, $data);

        if ($response->json('error')) {
            // エラー
            return $response->json('error')['message'];
        }

        return $response->json('choices')[0]['message']['content'];
    }
}
