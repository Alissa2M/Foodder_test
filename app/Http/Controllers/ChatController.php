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
        $sentence =$request->input('sentence');

        $chat_responses = $this->chat_gpt("300文字以内で答えてください", $sentence);

        return Inertia::render('Chat', [
            'chat_responses' => $chat_responses,

        ]);

    }

    /**
     * ChatGPT API呼び出し
     * Laravel HTTP
     */
    function chat_gpt($system, $messages)
    {

        // messageを格納する
        $arrayMassage = array();

        // 1set
        foreach($messages as $key=>$message){
            if($key % 2 == 0){
                // 偶数なので、user
                $arrayMassage[] = [
                    "role" => "user",
                    "content" => $message
                ];
            } else {
                // 奇数なので、assistant
                $arrayMassage[] = [
                    "role" => "assistant",
                    "content" => $message
                ];
            }
        }

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
            "max_tokens" => 1000,
            "messages" => [
                [
                    "role" => "system",
                    "content" => $system
                ],
                ...$arrayMassage
            ]
        );

        $response = Http::withHeaders($headers)->post($url, $data);

        if ($response->json('error')) {
            // エラー
            return $response->json('error')['message'];
        }

        // 返信メッセージの配列を取得する
        $choices = $response->json('choices')[0]['message']['content'];

        // 入力メッセージを配列に追加する
        $messages[] = $choices;

        return $messages;
    }
}
