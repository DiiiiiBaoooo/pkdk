<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <!-- Flowbite -->
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.0.0/dist/flowbite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.0.0/dist/flowbite.min.js" defer></script>
   
    <!-- Load Vite scripts (include Echo) -->
    @vite(['resources/css/app.css', 'resources/js/app.tsx'])

    @livewireStyles
</head>
<body class="bg-gray-100 text-gray-800">
    <main class="py-4">
        {{ $slot }}
    </main>

    @livewireScripts
</body>
</html>
