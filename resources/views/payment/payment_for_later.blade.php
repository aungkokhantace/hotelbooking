<!DOCTYPE html>
<html>
<head>
    <title>Stripe Payment Test - Payment For Later</title>
</head>
<body>

<pre>
data-description="Access for a year"
data-amount="1000"
</pre>
<hr>



{!! Form::open(array('url' => '/pay')) !!}
    <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
            data-key="<?php echo $stripe['publishable_key']; ?>"
            data-description="Access for a year"
            data-amount="1000"
            data-locale="auto"></script>
{!! Form::close() !!}
<hr>

</body>
</html>