<?php

namespace App\Http\Middleware;

use Closure;
use App\ItemUser;
use Illuminate\Support\Facades\Auth;

class Cart
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $cart = (object)[];

        if (isset($_COOKIE['cart'])) {
            $cart = json_decode($_COOKIE['cart']);          //Getting items from local
        }

        if (    $cart == null) {
            $cart = (object)[];         //if couldn't
        }

        if (Auth::check())               //Merge local and server
        {

            foreach ($cart as $item_id => $value)           //Adding item from local to server
            {

                if ( !ItemUser::where('user_id', Auth::user()->id)
                    ->where('item_id', $item_id)->first()
                ) {
                    $item = new ItemUser();
                    $item->item_id = $item_id;
                    $item->user_id = Auth::user()->id;
                    $item->count = $value->count;
                    $item->save();
                }
            }


            $items = ItemUser::where('user_id', Auth::user()->id)->get();           //Adding item from server to local (adding to $cart)
            foreach ($items as $item) {
                if ( !isset( $cart->{$item->item_id} )) {
                    $cart->{$item->item_id} = (object)['count' => $item->count];
                }
            }
            setcookie('cart', json_encode($cart), 2147483647, '/');          //Set new cookie (local + server items)
            $_COOKIE['cart'] = json_encode($cart);
        }

        return $next($request);
    }
}
