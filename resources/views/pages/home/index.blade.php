<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/okta.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Login</title>
</head>

<body class="bg-body 	" style="">
    <div class="max-w-md mx-auto glass h-5/6 backdrop-blur-sm p-10 rounded-lg mt-20 z-50">

        @if (auth()->user())
            <h1 class="text-center font-semibold text-lg">Hai {{ auth()->user()->name }}</h1>
            <p class="text-center my-5">

                <a href="/dashboard" class="text-blue-500 text-center">Kembali ke dashboard</a>
            </p>
        @else
            <h1 class="text-center font-semibold text-lg">Hai, Login untuk melanjutkan</h1>
            <p class="text-center my-5">
                <a href="/dashboard" class="text-blue-500 text-center">Login</a>
            </p>
        @endif

    </div>

</body>

</html>
