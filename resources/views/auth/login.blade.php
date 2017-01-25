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
   <form class="form-horizontal col-md-offset-1" method="post" action="{{url('/auth/login/')}}">
    {!!csrf_field()!!}
    <div class="form-group">
        <label for="email" class="control-label">Email</label>
        <input type="email" name="email" value="{{old('email')}}">
    </div>
    <div class="form-group">
        <label for="password" class="control-label">Password</label>
        <input type="password" name="password" >
    </div>
    <div class="form-group">
        <label for="remember" class="control-label">Remember</label>
        <input type="checkbox" name="remember" >
    </div>
    <div class="form-group">
    <button type="submit" class="btn btn-success">Login</button>
    </div>
    
</form>
@endsection