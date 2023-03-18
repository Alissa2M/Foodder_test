<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Like;
use App\Models\Calender;


class LikeController extends Controller
{
    public function __construct()
    {
      $this->middleware(['auth', 'verified'])->only(['like', 'unlike']);
    }

    /**
     * 引数のIDに紐づくリプライにLIKEする
    *
    * @param $id リプライID
    * @return \Illuminate\Http\RedirectResponse
    */
    public function like(Request $request)
    {
        Like::create([
            'calender_id' => $request->calenderId,
            'user_id' => Auth::id(),
        ]);

        return "保存";
    }

    /**
     * 引数のIDに紐づくリプライにUNLIKEする
     *
     * @param $id リプライID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unlike(Request $request)
    {
        $like = Like::where('calender_id', $request->calenderId)->where('user_id', Auth::id())->delete();

        return "削除";

    }
}
