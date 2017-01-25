<!DOCTYPE html>
<html lang="en">
  <head>
   <meta name="csrf-token" content="{{csrf_token()}}">
    <title>NewsUA</title>

    <link rel="stylesheet" href="/bootstrap/css/bootstrap-theme.css.map">
    <link rel="stylesheet" href="/bootstrap/css/bootstrap-theme.css">
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css.map">
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/head.css">
    <link rel="stylesheet" href="/css/body.css">
    <script src="/js/jquery.js"></script>
    <script src="/js/main.js"></script>
    <script src="/js/close_window.js"></script>
    <script src="/bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript" src="/js/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="/js/jquery.cookie.js"></script>
    <script type="text/javascript" src="/js/script.js"></script>
  </head>
    <body style="background-color:">
        <div style="background-color:" class="page-header">
    <div class="row">
        <div class="col-sm-10 col-sm-offset-2"><a id="home" href="/"><h1>NewsUA</h1></a></div>
    </div>
</div>
        
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->


    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    @if(Auth::check())
      <span>Welcome, {{Auth::user()->name}}. <a href="/auth/logout"><span>Logout</span></a></span>
            <ul class="nav navbar-nav">
        <li><a href="/admin/category/manager">Category</a></li>
        <li><a href="/admin/tag/manager">Tag</a></li>
        <li><a href="/search/">Search</a></li>
        @if(Auth::user()->isAdmin)
        <li><a href="/approver/">Approver comment</a></li>
        <li><a href="/color/manager/">Color manager</a></li>
        
        <li><a href="/addform">Add news <span class="sr-only">(current)</span></a></li>
        <li><a href="/advertising">Advertising manager </a></li>
        @endif
      </ul>
      @else
      <span><a href="/auth/login">Login</a> or <a href="/auth/register">register</a></span>
      @endif


      <ul class="nav navbar-nav navbar-right">

      <form form="/get" class="navbar-form navbar-left" role="search">
       {{csrf_field()}}
        <div class="form-group">
          <input type="text" class="search form-control" placeholder="Search">
          <input type="hidden" id="token" value="{{csrf_token()}}">
        </div>
<!--        <button type="submit" class="btn btn-default">Search</button>-->
      </form>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
  <div class="search-result"></div>

        @yield('content')
        <script src="/js/close_window.js"></script>
        <div id="container">
  </body>
</html>