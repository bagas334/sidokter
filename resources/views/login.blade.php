<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
</head>

<body>

    <div>
        <div class="">Login Page</div>
        <form action="{{route('validateUser')}}" method="POST">
            @csrf
            <label for="nip_bps">NIP BPS</label>
            <input type="text" name="nip_bps" id="nip_bps">
            <label for="password">Password</label>
            <input type="password" name="password" id="password">
            <input type="submit">
        </form>
    </div>
</body>

</html>