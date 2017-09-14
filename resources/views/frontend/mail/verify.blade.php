<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>Please verify your email address</h2>

<div>
    You've created an account with the email address:.{!! $email !!}<br/>
    Click 'confirm' to verify the email address and unlock your full account.<br/>
    We'll also import any bookings you've made with that address.<br/>
    <?php $url = URL::to('register/verify/' . $activation_code);?>
    <a href="{{$url}}">Confirm</a>
    <br/>

</div>

</body>
</html>