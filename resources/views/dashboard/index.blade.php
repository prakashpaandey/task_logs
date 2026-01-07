<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager | Admin Dashboard</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <script>
        // Set initial theme
        if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }

        // Tailwind Config
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        darkBg: '#0f172a',
                        darkCard: '#1e293b',
                    }
                }
            }
        }
    </script>
    @include('dashboard.partials.styles')
</head>
<body class="h-full bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200 transition-all overflow-x-hidden">
    <div id="app" class="h-full flex flex-col">
        <!-- Top Navigation Bar -->
        @include('dashboard.partials.header')

        <!-- App State -->
        <script>
            window.App = {
                clients: @json($clients),
                selectedClient: @json($selectedClient),
                user: @json(auth()->user()),
                csrfToken: '{{ csrf_token() }}'
            };
        </script>

        <!-- Dynamic Content Layout -->
        <div class="flex flex-1 overflow-hidden">
            @include('dashboard.partials.sidebar')
            @include('dashboard.partials.main_content')
        </div>
    </div>

    <!-- UI Components & Logic -->
    @include('dashboard.partials.modals')
    @include('dashboard.partials.notifications')
    @include('dashboard.partials.scripts')
</body>
</html>