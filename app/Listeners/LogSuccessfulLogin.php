<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\ItemUser;
use Illuminate\Support\Facades\Auth;

class LogSuccessfulLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
//        $cart = (object)[];
//
//
//        if (isset($_COOKIE['cart'])) {
//            $cart = json_decode($_COOKIE['cart']);          //Getting items from local
//        }
//
//        if (    $cart == null) {
//            $cart = (object)[];         //if couldn't
//        }
//
//        foreach ($cart as $item_id => $value)           //Adding item from local to server
//        {
//
//            if (ItemUser::where('user_id', Auth::user()->id)
//                ->where('item_id', $item_id)->get()->isEmpty()) {
//                $item = new ItemUser();
//                $item->item_id = $item_id;
//                $item->user_id = Auth::user()->id;
//                $item->count = $value->count;
//                $item->save();
//            }
//        }
//
//
//        $items = ItemUser::where('user_id', Auth::user()->id)->get();           //Adding item from server to local (adding to $cart)
//        foreach ($items as $item) {
//            if (!isset($cart->{$item->item_id})) {
//                $cart->{$item->item_id} = (object)['count' => $item->count];
//            }
//        }
//        setcookie('cart', json_encode($cart));
    }
}
