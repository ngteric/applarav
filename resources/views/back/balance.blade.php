@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <h2>Balances </h2>
        <table>
            <tr>
                <th>Name</th>
                <th>Due</th>
            </tr>
            @foreach($balances as $balance)
            <tr>
                <td>{{$balance->user->name}}</td>
                <td>{{$balance->due}}</td>
            </tr>
            @endforeach
        </table>
    </div>
    <div class='row'>
        <h2>Suggestions</h2>
        
    </div>
</div>
@endsection