<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Illuminate\Support\Facades\Auth;
use Storage;

class CategoryController extends Controller
{
	public function list ()
	{
		return 	Category::all();
	}
    public function create (Request $request)
    {
        if ($request->input('name') != null)
        {
            $category = new Category();
            $category->name = $request->input('name');
            $category->save();
            return $category;
        }
        return '0';
    }
    public function update ($id, Request $request)
    {
        if ($request->input('name') != null)
        {
            $category = Category::find(intval($id));
            $category->name = $request->input('name');
            $category->save();
            return $category;
        }
    }
    public function delete ($id)
    {
        $category = Category::find(intval($id));
        if ($category) {
            $category->delete();
            foreach ($category->items as $item) {
                $item->delete();
                Storage::delete('/img/' . (string)$item->id);
            }
        }
        return $id;
    }
}
