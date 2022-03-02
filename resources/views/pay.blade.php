<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Receive Payment</title>
</head>

<body>
    <h3>Buy Movie Tickets N500.00</h3>
    <form method="POST" action="{{ route('pay') }}" id="paymentForm">
        {{ csrf_field() }}

        <input name="name" placeholder="Name" />
        <input name="email" type="email" placeholder="Your Email" />
        <input name="phone" type="tel" placeholder="Phone number" />

        <input type="submit" value="Buy" />
    </form>

</body>

</html>
