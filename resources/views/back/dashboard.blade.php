@extends('layouts.app')
@section('content')
@if(Session::has('flashMessage'))

<div class="alert alert-success">
    <div class='container'>
        {{ Session::get('flashMessage')}} 
    </div>
</div>
@endif
<div class="container">
    <div class="row">
        <h2>Dashboard</h2>
        <div id='chart'>
            @forelse($users as $user)
                @foreach($user->spends as $spend)
                    <div class='part'>
                        <div class='graph' data-price='{{$spend->total}}'><p class='part-price'>{{$spend->total}} €</p></div>
                        <p class='part-name'>{{$user->name}}</p>
                    </div>
                @endforeach
            @empty
            <p>Indisponible.</p>
            @endforelse
        </div>
        <a href='{{ route("spend.create") }}' class="btn btn-primary" style='margin-bottom:25px'>Add spend</a>
        <a href='{{ route("balance") }}' class="btn btn-primary" style='margin-bottom:25px'>Show balances</a>
        <div class="list-group">
            @foreach($spends as $spend)
            <a href="{{url('spend', $spend->id)}}" class="list-group-item">
                <h3 class="mb-1" style='font-weight:bold'>{{$spend->title}}</h3>
                <span class='label label-default'>{{$spend->price}} €</span>
                @if ($spend->status =='paid')
                <span class='label label-success'>{{$spend->status}}</span>
                @elseif($spend->status=='canceled')
                <span class='label label-danger'>{{$spend->status}}</span>
                @else
                <span class='label label-warning'>{{$spend->status}}</span>
                @endif
                <p class="mb-1" style='margin-top:10px'>{{$spend->description}}</p>
                
            </a>
            @endforeach
        </div>
        {{ $spends->links() }}
    </div>
</div>

@endsection