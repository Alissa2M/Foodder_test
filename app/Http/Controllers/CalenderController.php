<?php

namespace App\Http\Controllers;

use App\Models\Calender;
use App\Models\Category;
use Illuminate\Http\Request;
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
        return Inertia::render('Welcome');
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
      dd("aaa");
      // $request->validate([
      //   'title' => 'required|string|max:30',
      //   'description' => 'string|max:30',
      // ]);

      return redirect('/');


        // $assignee =
        // $request->assignee && auth()->user()->isAdmin ?
        // $request->assignee :
        // $assignee = auth()->user()->id;

        // $calender = new Calender([
        //     'start' => $request->start,
        //     'title' => $request->title,
        //     'description' => $request->description,
        //     'img_path' => $request->img,
        //     'user_id' => $assignee,
        //     'category_id' => $request->category
        // ]);

        // $calender->save();

        // return $event;
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
