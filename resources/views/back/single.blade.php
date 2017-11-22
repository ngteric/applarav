@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <h2>{{$spend->title}}</h2>
        <p>{{$spend->description}}</p>
        
    </div>
</div>
@endsection