@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row">
        <h2>Dashboard</h2>
        <div class="list-group">
            @foreach($spends as $spend)
            <a href="{{url('spend', $spend->id)}}" class="list-group-item">
                <h5 class="mb-1">{{$spend->title}}</h5>
                <span class='badge'>{{$spend->price}} €</span>
                
                <p class="mb-1">{{$spend->description}}</p>
                @if ($spend->status =='paid')
                <span class='badge badge-pill badge-success'>{{$spend->status}}</span>
                @endif
            </a>
            @endforeach
        </div>
    </div>
</div>

@endsection