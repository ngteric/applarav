@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <h2>{{$spend->title}}</h2>
        <span class='label label-success'>{{$spend->status}}</span>
        <p style='margin-top:10px'>{{$spend->description}}</p>
        <span style='font-size:2rem'>{{$spend->price}} €</span>

        <div class="panel panel-primary"  style='margin-top:10px'>
            <div class="panel-heading"><h3 class="panel-title">Participant</h3></div>
                <div class="panel-body">
                    <ol class="list-group">
                        @forelse($spend->users as $user)
                            <li class="list-group-item" style='border:none'>{{$user->name}}<span class='badge'>{{$user->pivot->price}} €</span></li>
                        @empty
                            <p>nobody.</p>
                        @endforelse
                    </ol>
                </div>
                
            </div>
            <div class="btn-group">
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Add participant <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    @forelse($users as $user)
                        <li><a href="#">{{$user->name}}</a></li>
                    @empty
                        <p>nobody.</p>
                    @endforelse
                </ul>
                </div>
        </div>
    </div>
</div>
@endsection