<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager | Admin Dashboard</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('favicon.png') }}">
    
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
<body class="h-full bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200 overflow-x-hidden" style="transition: background-color 200ms ease, color 200ms ease;">
    <div id="app" class="h-full flex flex-col">
        <!-- Top Navigation Bar -->
        @include('dashboard.partials.header')

        <!-- App State -->
        <script>
            window.App = {
                clients: @json($clients),
                selectedClient: @json($selectedClient),
                user: @json(auth()->user()),
                isSuperAdmin: @json(auth()->user()->isAdmin()),
                users: @json($users),
                categories: @json($categories),
                notifications: @json($notifications),
                developerTasks: @json($developerTasks),
                hasUserDeletionErrors: @json($errors->userDeletion->isNotEmpty()),
                routes: {
                    user_status: @json(route('dashboard.account.status')),
                    sync: @json(route('dashboard.sync')),
                    statistics: @json(route('dashboard.statistics')),
                    clients: {
                        store: @json(route('dashboard.clients.store')),
                        update: @json(route('dashboard.clients.update', ['client' => ':id'])),
                        destroy: @json(route('dashboard.clients.destroy', ['client' => ':id']))
                    },
                    users: {
                        index: @json(route('admin.users.index')),
                        store: @json(route('admin.users.store')),
                        update: @json(route('admin.users.update', ['user' => ':id'])),
                        destroy: @json(route('admin.users.destroy', ['user' => ':id'])),
                        reset_password: @json(route('admin.users.reset-password', ['user' => ':id']))
                    },
                    main_tasks: {
                        store: @json(route('main-task.store')),
                        update: @json(route('main-task.update', ['main_task' => ':id'])),
                        destroy: @json(route('main-task.destroy', ['main_task' => ':id']))
                    },
                    profile: {
                        update: @json(route('profile.update')),
                        password_update: @json(route('password.update')),
                        destroy: @json(route('profile.destroy')),
                    },
                    subtasks: {
                        store: @json(route('subtask.store')),
                        update: @json(route('subtask.update', ['subtask' => ':id'])),
                        destroy: @json(route('subtask.destroy', ['subtask' => ':id'])),
                        toggle_status: @json(route('subtask.toggle-status', ['subtask' => ':id']))
                    },
                    time_logs: {
                        store: @json(route('dashboard.time-logs.store')),
                        update: @json(route('dashboard.time-logs.update', ['time_log' => ':id'])),
                        destroy: @json(route('dashboard.time-logs.destroy', ['time_log' => ':id']))
                    },
                    comments: {
                        store: @json(route('dashboard.comments.store')),
                        update: @json(route('dashboard.comments.update', ['comment' => ':id'])),
                        destroy: @json(route('dashboard.comments.destroy', ['comment' => ':id']))
                    },
                    reports: @json(route('dashboard.reports.data')),
                    notifications: {
                        mark_read: @json(route('dashboard.notifications.mark-read'))
                    },
                    developer_tasks: {
                        index: @json(route('developer-tasks.index')),
                        store: @json(route('developer-tasks.store')),
                        update: @json(route('developer-tasks.update', ['developer_task' => ':id'])),
                        update_status: @json(route('developer-tasks.update-status', ['developer_task' => ':id'])),
                        destroy: @json(route('developer-tasks.destroy', ['developer_task' => ':id'])),
                        comments: {
                            store: @json(route('developer-tasks.comments.store', ['developer_task' => ':id']))
                        }
                    }
                }
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