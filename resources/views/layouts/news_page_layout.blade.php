<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>News Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Tailwind CSS with 'tw-' prefix and preflight disabled -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            prefix: 'tw-',
            corePlugins: {
                preflight: false,
            },
        };
    </script>
</head>

<body>
    <header class="bg-primary text-white text-center p-4">
        <h1 class="tw-text-3xl tw-font-bold">{{ $title ?? 'News' }}</h1>
    </header>
    <main class="container my-4">
        @yield('content')
    </main>
</body>

</html>
