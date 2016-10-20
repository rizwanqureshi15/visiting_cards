<html>
	<body>
		Hello, 
		<br>
		<p>Mail From <b>{{ $contact->email }},</b></p>
		<br>
		<p>Name: <b>{{ $contact->name }}</b></p>
		<br>
		<p>Subject: <b>{{ $contact->subject }}</b></p>
		<br>
		<p>Content: <b>{{ $contact->content }}</b></p>
		<br>
		Thank you
		<br>
	</body>
</html>