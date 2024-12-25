<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">

    <div class="bg-white shadow-md rounded-lg p-6 w-full max-w-sm">
        <h2 class="text-2xl font-bold text-center text-gray-700 mb-4">Login</h2>
        <p class="text-sm text-gray-500 text-center mb-6">Silakan masukkan NIP dan password Anda</p>
        <form action="{{route('validateUser')}}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="nip_bps" class="block text-sm font-medium text-gray-600">NIP BPS</label>
                <input type="text" name="nip_bps" id="nip_bps" placeholder="Masukkan NIP BPS"
                    class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-600">Password</label>
                <input type="password" name="password" id="password" placeholder="Masukkan Password"
                    class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>
            <button type="submit"
                class="w-full bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 rounded-lg">
                Login
            </button>
        </form>
    </div>

</body>

</html>