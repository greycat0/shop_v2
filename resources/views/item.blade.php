@extends('layouts/app')

@section('content')

    <item
            item_id={{$item->id}}
    name="{{$item->name}}"
            price={{$item->price}}
    img="{{$item->img}}"
            desc="{{$item->desc}}"
            amount={{$item->amount}}
    category_name="{{$category_name}}"
            category_id={{$item->category_id}}
    ></item>

@endsection
