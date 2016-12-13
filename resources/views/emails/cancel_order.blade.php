<html>
	<body>
		Hello  <b>{{ $user->first_name." ".$user->last_name }},</b>
		<br>
		<p> Order No. {{ $order->order_no }} is canceled..!!</p>
		<br>
		Thank you
		<br>
		<br>From,
		<br>Team.
	</body>
</html>