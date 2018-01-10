<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>.: SIMAS-ad :.</title>
<link rel="stylesheet" href="css/login/style.default.css" type="text/css" />
    <link rel="stylesheet" href="css/login/style.shinyblue.css" type="text/css" />

<script type="text/javascript" src="{{ URL::to('js/login/jquery-1.9.1.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::to('js/login/jquery-migrate-1.1.1.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::to('js/login/jquery-ui-1.9.2.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::to('js/login/modernizr.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::to('js/login/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::to('js/jquery.cookie.js') }}"></script>
<script type="text/javascript" src="{{ URL::to('js/login/custom.js') }}"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('#login').submit(function(){
            var u = jQuery('#username').val();
            var p = jQuery('#password').val();
            if(u == '' && p == '') {
                jQuery('.login-alert').fadeIn();
                return false;
            }
        });
    });
</script>
</head>

<body class="loginpage">

<div class="loginpanel">
    <div class="loginpanelinner">
        <!--<div class="logo animate0 bounceIn"><img src="img/login/logo.png" alt="" /></div>-->
        <div class="logo animate0 bounceIn"><img src="img/simasad-logo-large.png" alt="" /></div>
        <form id="login" action="{{URL::to('login')}}" method="post">
            <div class="inputwrapper login-alert">
                <div class="alert alert-error">Username atau password tidak valid</div>
            </div>
            @if(Session::has('login_errors'))
            <div class="inputwrapper" >
                    <div class="alert alert-error" style="padding: 5px;font-size: small;text-align: center;">Username atau password tidak valid</div>
                </div>
            @endif
            <div class="inputwrapper animate1 bounceIn">
                <input type="text" name="username" id="username" style="width: 359px" placeholder="Ketik username anda" autocomplete="off" autofocus="autofocus" />
            </div>
            <div style="margin-top: 5px;margin-bottom: 5px;"></div>
            <div class="inputwrapper animate2 bounceIn">
                <input type="password" name="password" id="password" style="width: 359px;" placeholder="Ketik password anda" />
            </div>
            <div style="margin-top: 5px;margin-bottom: 5px;"></div>
            <div class="inputwrapper animate3 bounceIn">
                <button name="submit">Sign In</button>
            </div>
<!--            <div class="inputwrapper animate4 bounceIn">
                <label><input type="checkbox" class="remember" name="signin" /> Keep me sign in</label>
            </div>-->
            
        </form>
    </div><!--loginpanelinner-->
</div><!--loginpanel-->

<div class="loginfooter">
    <p>&copy; 2013. SDI Sabilil Huda. All Rights Reserved.</p>
</div>

</body>
</html>
