@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
    <h1>Create a trip</h1>
    <form id='trip-form' class='col-md-6 center' style='margin-bottom:30px' action="{{route('trip.store')}}" method="post">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="title">Title*</label>
            <input type="text" class="form-control" name="title" id="title" placeholder="Spend title" value='{{old("title")}}'>
            @if($errors->has('title'))<div class="invalid-feedback">{{$errors->first('title')}}</div>@endif
        </div>
        <div class="form-group">
            <label for="date">start date*</label>
            <input type="date" class="form-control" name="date" id="date" placeholder="date start" value='{{old("date")}}'>
            @if($errors->has('date'))<div class="invalid-feedback">{{$errors->first('date')}}</div>@endif
        </div>
        <div class="form-group">
            <label for="dayauth">How many day ?*</label>
            <input type="text" class="form-control" name="dayauth" id="dayauth" placeholder="day " value='{{old("dayauth")}}'>
            @if($errors->has('dayauth'))<div class="invalid-feedback">{{$errors->first('dayauth')}}</div>@endif
        </div>
        <div class="form-group">
            <label for="users">Participate*</label><br>
            <button class='add-user btn btn-primary'>add participant</button>
            <ol class="form-group user-list">
               
            </ol>
                  
             
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>

    </div>
</div>
@endsection