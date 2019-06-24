@extends('layouts/app')

@section('content')
	<cart :items="{{json_encode($items)}}"></cart>
@endsection