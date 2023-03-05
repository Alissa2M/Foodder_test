<?php

namespace App\Http\Controllers;

use App\Models\Calender;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Carbon\Carbon;


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
          'title' => $post->title,
          'date' => new Carbon($post->start),
          'backgroundColor' => $post->category->find($post->category_id)->color,
        ];
      }
      return Inertia::render('Welcome',['calenders' => $calenders, 'events' => $events]);

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
        'description' => 'max:30',
      ]);

      $dir = 'img';
      $file_name = $request->file('img_path')->getClientOriginalName();
      $file_path = $request->file('img_path')->storeAs('public', $file_name);

      $calender = new Calender([
        'title' => $request->title,
        'description' => $request->description,
        'start' => $request->start,
        'img_path' => '/storage' . '/' . $file_name,
        'user_id' => Auth::id(),
        'category_id' => $request->category_id,
      ]);

      $calender->save();

      return Redirect::route('home');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Calender  $calender
     * @return \Illuminate\Http\Response
     */
    public function edit(Calender $calender)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Calender  $calender
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Calender $calender)
    {
        $user = auth()->user();
        if ($calender->user_id === $user->id || $user->isAdmin) {
          $calender->update($request->all());
        } else {
          abort(403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Calender  $calender
     * @return \Illuminate\Http\Response
     */
    public function destroy(Calender $calender)
    {
        $user = auth()->user();
        if ($calender->user_id === $user->id || $user->isAdmin) {
          $calender->delete();
        } else {
          abort(403);
        }
    }
}
