<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Models\Recipe;
use Inertia\Inertia;

class RecipeController extends Controller
{
    public function index(Request $request)
    {
        if($request){
            $recipe = Recipe::where('id',$request->recipeId)->first();

            return Inertia::render('Recipe',[
                'recipe' => $recipe,
            ]);
        }
        return Inertia::render('Recipe');
    }

    public function edit(Request $request)
    {
        if($request){
            $recipe = Recipe::where('id',$request->recipeId)->first();
    
            return Inertia::render('RecipeEdit',[
                'recipe' => $recipe,
            ]);    
        }
        return Inertia::render('RecipeEdit');

    }

    public function delete(Request $request)
    {
        $recipe = Recipe::where('id',$request->recipeId)->first();
        $recipe->delete();
        
        return Redirect::to('/profile');
    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|max:30',
        ]);
        Recipe::where('id',$request->recipeId)->update([
            'title' => $request->title,
            'recipe' => $request->recipe,
        ]);
        
        $recipe = Recipe::where('id',$request->recipeId)->first();
        
        return Redirect::to('/profile');
    }
}
