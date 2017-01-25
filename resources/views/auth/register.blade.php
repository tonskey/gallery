@extends('.layouts.app')
@section('content')
@if($errors->has())
    <div class="row">
        <div class="col-md-offset-2 col-md-8">
            <div class="alert alert-danger">
                <button class="close" aria-label="Close" data-dismiss="alert" type="button">
                    <span aria-hidden="true">
                        x
                    </span>
                </button>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif
<form action="{{url('auth/register')}}" class="col-md-of
    col-md-5" method="post" role="form">
    {!! csrf_field() !!}
    <div class="form-group">
        <label for="email">Name</label>
        <input type="text" class="form-control" name="name" placeholder="Name">
        <label for="email">Email</label>
        <input type="email" class="form-control" name="email" placeholder="Email">
        <label for="password">Password</label>
        <input type=password class="form-control" name="password" placeholder="Password">
        <div class="form-group">
            <label for="confirm_password">Confirm you password</label>
            <input type="password" class="form-control" placeholder="Confirm password" name="password_confirmation">
        </div>
        <button type="submit" class="btn btn-default">Send</button>

    </div>
</form>
<!--
   <form  class="form-horizontal col-md-offset-1" method="post" action="/auth/register">
    {{csrf_field()}}
    <div class="form-group">
        <label for="name" class="control-label">Name</label>
        <input type="text" value="{{old('name')}}" name="Name" >
    </div>
    <div class="form-group">
        <label for="email" class="control-label">Email</label>
        <input type="email" name="email" value="{{old('email')}}">
    </div>
    <div class="form-group">
        <label for="password" class="control-label">Password</label>
        <input type="password" name="password" >
    </div>
    <div class="form-group">
        <label for="password_confirm" class="control-label">Confirm password</label>
        <input type="password_confirm" name="password" >
    </div>
    <div class="form-group">
    <button type="submit" class="btn btn-success">Register</button>
    </div>
    
</form>
-->
@endsection