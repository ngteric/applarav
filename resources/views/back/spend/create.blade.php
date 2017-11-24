@extends('layouts.app')
@section('content')
@if(Session::has('flashMessageError'))
<div class="alert alert-danger">
    {{ Session::get('flashMessageError')}} 
</div>
@endif
<div class="container">
    <div class="row">

    <form id='spendCreate' class='col-md-6 center' style='margin-bottom:30px' action="{{route('spend.store')}}" method="post">
    {{ csrf_field() }}
        
        <div class="form-group">
            <label for="title">Title*</label>
            <input type="text" class="form-control" name="title" id="title" placeholder="Spend title" value='{{old("title")}}'>
            @if($errors->has('title'))<div class="invalid-feedback">{{$errors->first('title')}}</div>@endif
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" placeholder="Write text here ..." rows="10" cols="">{{old("description")}}</textarea> 
            @if($errors->has('description'))<div class="invalid-feedback">{{$errors->first('description')}}</div>@endif
        </div>
        <div class="form-group">
            <label for="price">Price*</label>
            <input type="number" step="0.01" class="form-control" name="price" id="price" placeholder="Spend price" value='{{old("price")}}'>
            @if($errors->has('price'))<div class="invalid-feedback">{{$errors->first('price')}}</div>@endif
        </div>
        <div class="form-group">
            <label for="status">status</label>
            <select class="form-control" name='status' id="status">
                <option value='paid'>paid</option>
                <option value='account'>account</option>
            </select>
        </div>
        <div class="form-group">
            <label for="pay_date">pay date*</label>
            <input type="text" class="form-control" name="pay_date" id="pay_date" placeholder="AAAA-MM-DD" value='{{old("pay_date")}}'>
            @if($errors->has('pay_date'))<div class="invalid-feedback">{{$errors->first('pay_date')}}</div>@endif
        </div>
        <div class="form-group">
            <label for="users_id">Participate*</label><br>
                @foreach($users as $user)
                {{$user->name}} 
                <div class="input-group" style='margin-bottom:15px'>
                    <span class="input-group-addon">
                        <input type="checkbox" class="form-check-input users_id" name='users_id[]' value='{{$user->id}}'>
                    </span>
                    <input type="number" step="0.01" class="form-control prices" name="prices[]"  placeholder="part price" value='{{old("prices")}}' disabled><br>
                </div>
                @endforeach
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>

    </div>
</div>


@endsection