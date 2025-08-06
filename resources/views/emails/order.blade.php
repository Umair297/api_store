<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmation</title>
</head>
<body>
    <h2>Thank you for your order, {{ $order->name }}!</h2>
    <p>Your order has been received and is being processed.</p>
    <p><strong>Total Amount:</strong> ${{ $order->total_amount }}</p>
    <p><strong>Status:</strong> {{ $order->status }}</p>
    <br>
    <p>We’ll notify you when it ships.</p>
</body>
</html>
