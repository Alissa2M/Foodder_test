<?php

namespace App\Http\Controllers;

use App\Models\Calender;
use App\Models\Category;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class CalenderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $calenders = DB::table('calenders')->where('user_id',Auth::id())->latest()->take(5)->get();
      $events = array();
      $posts = Calender::with('category')->where('user_id',Auth::id())->get();
      foreach($posts as $post){
        $events[] = [
          'id' => $post->id,
          'title' => $post->title,
          'date' => new Carbon($post->start),
          'backgroundColor' => $post->category->find($post->category_id)->color,
        ];
      }
      return Inertia::render('Welcome',['calenders' => $calenders, 'events' => $events, 'posts' => $posts]);

    }

    public function post(Request $request)
    {
      return redirect()->route('dashboard',['date' => $request->date]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Calender  $calender
     * @return \Illuminate\Http\Response
    */
    public function show(Request $request)
    {
      $category = Category::all();
      $date = $request->date;
      $today = new Carbon('today');
      if($date){
        return Inertia::render('Dashboard', ['date'=> $request->date, 'category' => $category]);
      }else{
        return Inertia::render('Dashboard', ['date'=> $today->toDateString(), 'category' => $category]);
      }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $request->validate([
        'title' => 'required|max:30',
        'description' => 'max:50',
      ]);

      $image = $request->file('file');
      if($image){
        $request->validate([
          'file' => 'max:6000|mimes:jpg,jpeg,png,gif,webp'
        ]);

        if(App::environment('local')){
          $file_name = $request->file('file')->getClientOriginalName();
          $file_path = $request->file('file')->storeAs('public', $file_name);
          $img_path = '/storage' . '/' . $file_name;
        }else{		
          // ↓本番環境のみ 
          // バケットへアップロードする
          $path = Storage::disk('s3')->putFile('/post', $image);
          // アップロードした画像のフルパスを取得
          $img_path = Storage::disk('s3')->url($path);
        }
      }else{
        $img_path = '';
      }
      
      $calender = new Calender([
        'title' => $request->title,
        'description' => $request->description,
        'start' => $request->start,
        'img_path' => $img_path,
        'user_id' => Auth::id(),
        'category_id' => $request->category_id,
        'shop_name' => $request->shop_name,
      ]);

      $calender->save();

      return Redirect::route('home');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Calender  $calender
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
      $request->validate([
        'title' => 'required|max:30',
        'description' => 'max:50',
      ]);
      Calender::where('id',$request->calenderId)->update([
        'title' => $request->title,
        'description' => $request->description,
        'start' => $request->start,
        'category_id' => $request->category_id,
        'shop_name' => $request->shop_name,
      ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Calender  $calender
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
      $calender = Calender::where('id',$request->calenderId)->first();
      // s3の画像を削除(本番のみ)
      $url = $calender->img_path;
      if(!App::environment('local')){
        $s3 = str_replace('https://foodder.s3.ap-northeast-1.amazonaws.com/','',$url);
        Storage::disk('s3')->delete($s3);
      }
      $calender->delete();
      
      return Inertia::render('Welcome')->with('result','削除しました');
    }

    public function timeline()
    {
      $calenders = Calender::with('user')->with('category')->latest()->take(50)->get();

      return Inertia::render('Timeline',['calenders' => $calenders]);
    }
}
