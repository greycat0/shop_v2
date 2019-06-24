<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use App\Category;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use App\ItemUser;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $category = (object)['name' => 'Все товары'];
        if ($request->input('category') != null) {
            $category = Category::find(intval($request->input('category')));
            if (isset($category)) {
                $items = $category->items;
            } else {
                abort(404);
            }
        } else {
            $items = Item::all();
        }

        return view('welcome', compact(
            'items',
            'category'
        ));
    }

    public function show($id)
    {
        $item = Item::find(intval($id));
        if ($item != null) {
            $category_name = Category::where('id', $item->category_id)->first()->name;
            return view('item', compact(
                'item',
                'category_name',
            ));
        } else {
            abort(404);
        }

    }

    public function cart()
    {
        $cart = (object)[];


        if (isset($_COOKIE['cart'])) {
            $cart = json_decode($_COOKIE['cart']);          //Getting items from local
        }

        if (    $cart == null) {
            $cart = (object)[];         //if couldn't
        }

        $item_ids = array_keys((array)$cart);
        $items = Item::whereIn('id', $item_ids)->get()->keyBy('id');
        return view('cart', compact(
            'items'
        ));

    }

    public function updateItemInCart(Request $request)
    {
        if (Auth::check()) {
            if ($request->input('action') == 'add') {

                $item = ItemUser::where('user_id', Auth::user()->id)
                    ->where('item_id', $request->input('item_id'))->first();
                if (!$item)
                {
                    $item = new ItemUser();
                }

                $item->item_id = $request->input('item_id');
                $item->user_id = Auth::user()->id;
                $item->count = $request->input('count');
                $item->save();
            }
            if ($request->input('action') == 'delete') {

                $item = ItemUser::where('item_id', $request->input('item_id'))->first();
                if ($item)
                {
                    $item->delete();

                    $cart = json_decode( $_COOKIE['cart']);
                    unset( $cart->{$request->input('item_id')} );
                    setcookie('cart', json_encode($cart), 2147483647, '/');
                }

            }
            if ($request->input('action') == 'update_count') {

                $item = new ItemUser();
                $item->item_id = $request->input('item_id');
                $item->user_id = Auth::user()->id;
                $item->count = $request->input('count');
                $item->save();
            }
        }
    }
}
