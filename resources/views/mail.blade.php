<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email verify</title>
</head>
<body>
    <h1><?= $details['title'] ?></h1>
    <p>{{ $details['body'] }}</p>
    <p>{{ $details['body2'] }}</p>
    <p>{{ $details['body3'] }}<a href="{{ url('http://localhost:81') }}">web BKKBN</a></p>
    <p>Thank you</p>
    
    <script>alert("abc")</script>
</body>
</html>