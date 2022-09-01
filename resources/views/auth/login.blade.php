@extends('layouts.jnb.auth')

@section('content')

<style>
 
.inputBox{
    position: relative;
    width: 100%;
    height: 50px;
}
.inputBox input{
    position: absolute;
    top: 0;
    left: 0;
    width:100%;
    height: 80%;
    border:none;
    /*background: transparent;*/
    padding: 0 20px;
    font-size: 18px;
    box-sizing: border-box;
    border-radius: 8px;
    box-shadow: -4px -4px 10px rgba(255,255,255,1),
                inset 4px 4px 10px rgba(0,0,0,0.05),
                inset -4px -4px 10px rgba(255,255,255,1),
                4px 4px 10px rgba(0,0,0,0.05);
}
.inputBox input::placeholder{
    color: #cccccc;
}
#toggle{
    position: absolute;
    top: 40%;
    right: 20px;
    transform: translateY(-50%);
    width: 30px;
    height: 30px;
    background:url('assets/img/show.png');
    background-size: cover;
    cursor: pointer;
}
#toggle.hideTongle{
    background: url('assets/img/hide.png');
    background-size: cover;
}
</style>
 
<div id="wrapper" class="login">

    <div  id="top">
        <div  id="topBar" class="clearfix widget-content pad10">
            
         
            <a class="logo" >
                <img style="border-radius: 6px;margin-left: 0px;" src="{{ asset('assets/img') }}/logo.png" rel="logo">
            </a>
<!--            <div class="topNav clearfix">
                <ul class="tNav clearfix">
                    <li>
                        <a data-toggle="dropdown" href="#" class="dropdown-toggle"><i class="fa fa-gear icon-white"></i></a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="{{ url('/password/reset') }}"><i class="fa fa-question"></i> Lupa Password</a></li>
                            <li><a href="#"><i class="fa fa-envelope-o"></i> Kontak Admin</a></li>
                            <li class="divider"></li>
                            <li><a href="#"><i class="fa fa-info-circle"></i> Bantuan</a></li>
                        </ul>
                    </li>
                </ul>
            </div>-->
            
            <!-- /topNav -->		
        </div> <!-- /topBar -->

    </div> <!-- /top -->
    <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
        {{ csrf_field() }}
        <div class="widget-content pad20 clearfix">
<!--            <div class="userImg">
                <img  src="{{ asset('assets/img/') }}/lock.jpg"  rel="user">
            </div>-->
                
            <h3 class="center">Panel Login</h3>
                      <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                      
                            <div class="col-md-12">
                                <input style="border: none" id="email" type="text" class="form-control" name="username" placeholder="Username"  value="{{ old('username') }}" required autofocus>

                                @if ($errors->has('username'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div> 
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}"> 
                            <div class="col-md-12">
                              
                                <div class="inputBox">
                                    <input type="password" class="form-control"  name="password" placeholder="Enter Password" id="password">
                                      <div id="toggle"  onclick="showHide();"></div>
                                </div>
                                
                                
                                
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
            <button class="btn btn-blue btn-full" type="submit">LOGIN</button>
            <span class="custom-input">
                <input type="checkbox" id="chkbx-1"><label for="chkbx-1">Remember me</label>
            </span>
        </div>	<!-- /widget-content -->	
    </form>
</div>  <!-- /wrapper -->
<script type="text/javascript">
            const password = document.getElementById('password');
            const toggle = document.getElementById('toggle');
            
            function showHide(){
//                alert('klik!');
                if(password.type === 'password'){
                    password.setAttribute('type', 'text');
                    toggle.classList.add('hideTongle')
                } else{
                    password.setAttribute('type', 'password');
                    toggle.classList.remove('hideTongle')
                }
            }
</script>

@endsection
