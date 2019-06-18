<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Item;
use App\Category;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function index(Request $request)
    {
        $category = (object)['name' => 'Все товары'];
        if ( $request->input( 'category') != null)
        {
            $category = Category::find( intval( $request->input( 'category')) );
            if (isset($category))
            {
                $items = $category->items;
            }
            else {
                abort(404);
            }
        }
        else {
            $items = Item::all();
        }

        return view('welcome', compact(
            'items',
            'category'
        ));
    }
}
