<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Inertia\Inertia;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\Models\Chat;

class ChatController extends Controller
{
    /**
     * index
     *
     * @param  Request  $request
     */
    public function index()
    {
        // 今日の日付
        $date = Carbon::now()->toDateString();
        // ChatDBからuser_idとdateが一致したレコードのcountを取得
        $history = Chat::where('user_id',Auth::id())->where('date',$date)->first();
        if($history){
            return Inertia::render('Chat',[
                'count' => $history->count
            ]);
        }
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

        // 今日の日付
        $date = Carbon::now()->toDateString();

        // dateが今日と一致するものがあるかの判定
        $history = Chat::where('user_id',Auth::id())->where('date',$date)->first();
        if($history){
            // チャット数が６以上かどうか
            $historyCount = $history->count;
            if($historyCount > 6){
                // チャット数が６より大きい時、画面に戻る
                return Inertia::render('Chat');
            }else{
                // chatGPTのAPIを実行
                $chat_responses = $this->chat_gpt("300文字以内で答えてください", $sentence);

                // データベースと現在のレスポンスの差
                $calculate = count($chat_responses) - $historyCount;
                if($calculate > 0){
                    $history->update([
                        'count' => $historyCount + $calculate,
                    ]);
                }elseif($calculate == 0){
                    $history->update([
                        'count' => $historyCount + 2,
                    ]);
                }else{
                    $history->update([
                        'count' => $historyCount + count($chat_responses),
                    ]);
                }

                return Inertia::render('Chat', [
                    'chat_responses' => $chat_responses,
                    'count' => $history->count
                ]);            
            }
        }else{
            // chatGPTのAPIを実行
            $chat_responses = $this->chat_gpt("300文字以内で答えてください", $sentence);

            // chatにレコードを新しく登録する
            Chat::create([
                'user_id' => Auth::id(),
                'text' => NULL,
                'date' => $date,
                'count' => count($chat_responses),
            ]);

            return Inertia::render('Chat', [
                'chat_responses' => $chat_responses,
                'count' => count($chat_responses)
            ]);

        }
    
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
