<html>
	<body>
		Hello <b>{{ $user->first_name." ".$user->last_name }},</b>
		<br>
		<p>Your Order No. {{ $order->order_no }} is confirmed..!!</p>
		<br>
		Thank you
		<br>
		<br>From,
		<br>Team.
	</body>
</html>