<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Forget Password</title>
</head>

<body>
    <h1>Welcome To Our Website</h1>
    <b>Dear: {{ $user->name }} , Your Email: {{ $user->email }}</b>
    <p>Here is the new verification code , to reset your password
        <b>{{$opt}}</b>
    </p>
    <br><br>
    Regards {{env('APP_NAME')}}
</body>

</html>