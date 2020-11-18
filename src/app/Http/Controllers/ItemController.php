<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use App\Category;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use App\ItemUser;
use Exception;
use Storage;

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

    public function list(Request $request)
    {
        $category = (object)['name' => 'Все товары'];
        if ($request->input('category') != null) {
            $category = Category::find(intval($request->input('category')));
            if (isset($category)) {
                $items = $category->items;
            } else {
                return [];
            }
        } else {
            $items = Item::all();
        }
        return $items;
    }

    public function create(Request $request)
    {
        if ($request->input('name') != null
            && $request->input('price') != null
            && $request->input('amount') != null
            && $request->input('category') != null
            && $request->file("image") != null)
        {
            $item = new Item();
            $item->name = $request->input('name');
            $item->price = $request->input('price');
            $item->amount = $request->input('amount');
            $item->category_id = $request->input('category');
            $item->desc = $request->input('desc') ? $request->input('desc') : "";
            $item->img = "";
            $item->save();
            $item->img = (string)$item->id;
            $request->file("image")->storePubliclyAs('/img', (string)$item->id);
            $item->save();
            return $item->id;
        }
    }

    public function update($id, Request $request)
    {
        if ($request->input('name') != null
            && $request->input('price') != null
            && $request->input('amount') != null
            && $request->input('category') != null)
        {
            $item = Item::find(intval($id));
            if ($item)
            {
                $item->name = $request->input('name');
                $item->price = $request->input('price');
                $item->amount = $request->input('amount');
                $item->category_id = $request->input('category');
                $item->desc = $request->input('desc') ? $request->input('desc') : "";
                if ($request->file("image") != null)
                {
                    $request->file("image")->storePubliclyAs('/img', (string)$item->id);
                }
                $item->save();
                return $item->id; 
            }
        }
    }

    public function delete($id)
    {
        $item = Item::find(intval($id));
        if ($item)
        $item->delete();
        Storage::delete('/img/' . (string)$id);
        return $id;
    }

    public function show($id)
    {
        $item = Item::find(intval($id));
        try {
            if ($item != null) {
                $category = Category::where('id', $item->category_id)->first();
                if ($category === null)
                {
                    throw new Exception("");
                }
                $category_name = $category->name;
                return view('item', compact(
                    'item',
                    'category_name',
                ));
            } else {
                throw new Exception("");
            }
        } catch (Exception $e) {
            abort(404);
        }

    }


    public function createItemPage()
    {
            return view('createItemPage');
    }

    public function cart()
    {
        $cart = (object)[];


        if (isset($_COOKIE['cart'])) {
            $cart = json_decode($_COOKIE['cart']);        //Getting items from local
        }

        if ($cart == null) {
            $cart = (object)[];         //if couldn't
        }

        $item_ids = array_keys((array)$cart);
        $items = Item::whereIn('id', $item_ids)->get()->keyBy('id');
        return view('cart', compact(
            'items'
        ));

    }


    public function cartItemCount()
    {
        $cart = (object)[];


        if (isset($_COOKIE['cart'])) {
            $cart = json_decode($_COOKIE['cart']);        //Getting items from local
        }

        if ($cart == null) {
            $cart = (object)[];         //if couldn't
        }

        $item_ids = array_keys((array)$cart);
        $items = Item::whereIn('id', $item_ids)->get()->keyBy('id');
        return count($items);

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
    public function buy(Request $request)
    {
        if (Auth::check())
        {
            $items = ItemUser::where('user_id', Auth::user()->id)->delete();
            setcookie('cart', '{}', 2147483647, '/');
            return redirect('/');
        }else
        {
            return redirect('/login');
        }
        
    }
}
