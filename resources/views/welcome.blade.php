@extends('layouts/app')

@section('content')
    <div class="mb-5" style="font-size: 30px;">{{$category->name}}</div>
    <div class="d-flex flex-row flex-wrap justify-content-center justify-content-sm-start">

        @foreach ( $items as $item )
            <item-preview
            name="{{$item->name}}"
            price="{{$item->price}}"
            img="{{$item->img}}"
            item_id="{{$item->id}}"
                >
            </item-preview>
        @endforeach
    </div>

@endsection
