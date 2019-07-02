@extends('layouts/app')

@section('content')
    <items
            :items="{{json_encode($items)}}"
            :category="{{json_encode($category)}}"
    ></items>
@endsection
