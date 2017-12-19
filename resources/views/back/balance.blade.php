@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <h2>Balances </h2>
        <table class='table'>
            <tr>
                <th>Name</th>
                <th>Spend</th>
                <th>Due</th>
            </tr>
            @foreach($balances as $balance)
            <tr>
                <td>{{$balance->user->name}}</td>
                @foreach($users as $user)
                    @if($user->id == $balance->user->id)
                        @foreach($user->spends as $spend)
                            <td>{{$spend->total}} €</td>
                        @endforeach
                    @endif
                @endforeach
                <td>{{$balance->due}} €</td>
            </tr>
            @endforeach
            <tfoot>
                <tr>
                    <td>Total</td>
                    <td>{{round($totalSpend)}} €</td>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class='row'>
        <h2>Suggestions</h2>
        @foreach($suggestions as $suggestion)
        <div>
            <p>{{ $suggestion['name'] }} doit  {{ round($suggestion['price'], 2) }}€ à {{ $suggestion['to'] }}</p>
        </div>
        @endforeach
    </div>
</div>
@endsection