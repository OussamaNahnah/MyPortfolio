<!DOCTYPE html>
<html>
<head>
	<title>Already Verified</title>
	<style>
		body {
			background-color: #f2f2f2;
			font-family: Arial, sans-serif;
		}

		.container {
			margin: 50px auto;
			max-width: 600px;
			padding: 30px;
			background-color: #fff;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
			border-radius: 5px;
		}

		h1 {
			font-size: 36px;
			color: #333;
			margin-bottom: 20px;
			text-align: center;
		}

		p {
			font-size: 18px;
			color: #666;
			line-height: 1.5;
			margin-bottom: 30px;
			text-align: center;
		}

		.btn {
			display: block;
			margin: 0 auto;
			padding: 10px 20px;
			background-color: #4CAF50;
			color: #fff;
			border-radius: 5px;
			text-align: center;
			text-decoration: none;
			font-size: 18px;
			font-weight: bold;
			transition: background-color 0.3s;
		}

		.btn:hover {
			background-color: #3e8e41;
		}
	</style>
</head>
<body>
	<div class="container">
		<h1>Email Already Verified</h1>
		<p>This email has already been verified. Thank you for using our service.</p>
		<a href="{{ route('index') }}" class="btn">Go to Homepage</a>
	</div>
</body>
</html>
