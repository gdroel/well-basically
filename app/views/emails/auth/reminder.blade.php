<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h1>Well Basically</h1>
		<hr>
		<h2 >Password Reset</h2>
		
		<p>
			To reset your password, complete this form: {{ URL::to('password/reset', array($token)) }}.<br/>
			This link will expire in {{ Config::get('auth.reminder.expire', 60) }} minutes.
		</p>
	</body>
</html>
