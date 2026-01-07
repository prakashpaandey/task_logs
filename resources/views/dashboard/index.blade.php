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
        
        if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }

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
    <style>
        :root {
            --primary-color: #3b82f6;
            --secondary-color: #10b981;
            --danger-color: #ef4444;
            --warning-color: #f59e0b;
            --sidebar-width: 256px;
        }
        
        * {
            font-family: 'Inter', sans-serif;
        }
        
        .dark {
            color-scheme: dark;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }
        
        .dark ::-webkit-scrollbar-track {
            background: #374151;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 4px;
        }
        
        .dark ::-webkit-scrollbar-thumb {
            background: #6b7280;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #a1a1a1;
        }
        
        .dark ::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }
        
        /* Smooth transitions */
        .transition-all {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 200ms;
        }
        
        /* Card shadows */
        .card-shadow {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        .dark .card-shadow {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.2), 0 2px 4px -1px rgba(0, 0, 0, 0.1);
        }
        
        /* Form input focus styles */
        .form-input:focus, .form-textarea:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
        }
        
        .dark .form-input:focus, .dark .form-textarea:focus, .dark .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25);
        }
        
        /* Animation for form sections */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .fade-in {
            animation: fadeIn 0.3s ease-out forwards;
        }
        
        /* Status indicators */
        .status-indicator {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
        }
        
        .status-active {
            background-color: var(--secondary-color);
        }
        
        .status-inactive {
            background-color: #9ca3af;
        }
    </style>
</head>
<body class="h-full bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200 transition-all overflow-x-hidden">
    <div id="app" class="h-full flex flex-col">
        <!-- Top Navigation Bar -->
        <header class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 shadow-sm z-30">
            <div class="flex items-center justify-between px-6 py-4">
                <!-- Left side: Mobile Menu Toggle & Logo -->
                <div class="flex items-center space-x-4">
                    <button id="mobile-menu-toggle" class="p-2 -ml-2 rounded-lg md:hidden text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <div class="flex items-center space-x-3">
                        <div class="bg-blue-600 dark:bg-blue-500 text-white p-2 rounded-lg">
                            <i class="fas fa-tasks text-xl"></i>
                        </div>
                        <h1 class="text-xl md:text-2xl font-bold text-gray-800 dark:text-white">Task Manager</h1>
                    </div>
                </div>
                
                <!-- Right side: User info and dark mode toggle -->
                <div class="flex items-center space-x-4">
                    <!-- Dark/Light mode toggle -->
                    <button id="theme-toggle" class="p-2 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                        <i id="theme-icon" class="fas fa-moon"></i>
                    </button>
                    
                    <!-- User dropdown -->
                    <div class="relative">
                        <button id="user-menu-button" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <div id="user-initials" class="w-10 h-10 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white font-semibold">
                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                            </div>
                            <div class="text-left hidden md:block">
                                <p class="font-medium text-gray-800 dark:text-white">{{ auth()->user()->name }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Admin</p>
                            </div>
                            <i class="fas fa-chevron-down text-gray-500 dark:text-gray-400"></i>
                        </button>
                        
                        <!-- Dropdown menu -->
                        <div id="user-dropdown" class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 py-2 hidden">
                            <button id="profile-btn" class="w-full flex items-center px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                <i class="fas fa-user-circle mr-3"></i>
                                <span>Profile & Security</span>
                            </button>
                            <div class="border-t border-gray-200 dark:border-gray-700 my-2"></div>
                            <form method="POST" action="{{ route('logout') }}" id="logout-form" class="hidden">
                                @csrf
                            </form>
                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="flex items-center px-4 py-2 text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <i class="fas fa-sign-out-alt mr-3"></i>
                                <span>Logout</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <script>
            // Global data injected from PHP
            window.App = {
                clients: @json($clients),
                selectedClient: @json($selectedClient),
                user: @json(auth()->user()),
                csrfToken: '{{ csrf_token() }}'
            };
        </script>

        <!-- Main Content Area -->
        <div class="flex flex-1 overflow-hidden">
            <!-- Mobile Sidebar Overlay -->
            <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden"></div>

            <!-- Left Sidebar: Clients List -->
            <aside id="sidebar" class="fixed inset-y-0 left-0 w-64 md:w-64 lg:w-80 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 overflow-y-auto transition-all duration-300 z-50 transform -translate-x-full md:translate-x-0 md:static md:z-auto">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6 md:hidden">
                        <h2 class="text-lg font-bold text-gray-800 dark:text-white">Navigation</h2>
                        <button id="close-sidebar" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                            <i class="fas fa-times text-gray-500"></i>
                        </button>
                    </div>

                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-800 dark:text-white">Clients</h2>
                        <button id="add-client-btn" class="group flex items-center bg-blue-600 hover:bg-blue-700 text-white w-10 h-10 hover:w-36 rounded-lg transition-all duration-300 overflow-hidden shadow-md" title="Add New Client">
                            <div class="flex items-center justify-center min-w-[2.5rem] h-10">
                                <i class="fas fa-plus"></i>
                            </div>
                            <span class="whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-300 pr-3 font-medium text-sm">Add Client</span>
                        </button>
                    </div>
                    
                    <!-- Search clients -->
                    <div class="mb-6">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" id="client-search" placeholder="Search clients..." class="w-full pl-10 pr-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>
                    
                    <!-- Clients list -->
                    <div id="clients-list-container" class="space-y-3">
                        @foreach($clients as $client)
                        <div class="client-item p-4 {{ (isset($selectedClient) && $selectedClient->id == $client->id) ? 'bg-blue-50 dark:bg-blue-900/20 border-blue-200 dark:border-blue-800' : 'bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700' }} border rounded-lg cursor-pointer transition-all hover:shadow-md" data-client-id="{{ $client->id }}">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                                    <h3 class="font-semibold text-gray-800 dark:text-white">{{ $client->name }}</h3>
                                </div>
                                <span class="text-xs bg-blue-100 dark:bg-blue-800 text-blue-800 dark:text-blue-200 px-2 py-1 rounded">Active</span>
                            </div>

                        </div>
                        @endforeach
                    </div>
                    
                    <!-- No clients message (hidden by default) -->
                    <div id="no-clients-message" class="hidden mt-8 text-center p-8 border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-lg">
                        <div class="mx-auto w-16 h-16 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-users text-3xl text-gray-400"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-2">No clients found</h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-4 text-sm">Add your first client to get started</p>
                        <button id="add-first-client-btn" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors text-sm font-medium">
                            <i class="fas fa-plus mr-2"></i>Add Client
                        </button>
                    </div>
                </div>
            </aside>

            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto p-6 bg-gray-50 dark:bg-gray-900">
                <!-- Client selection prompt -->
                <div id="client-selection-prompt" class="h-full flex flex-col items-center justify-center p-8">
                    <div class="max-w-md text-center">
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-users text-4xl text-white"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-3">Select a Client</h2>
                        <p class="text-gray-600 dark:text-gray-400 mb-8">
                            Choose a client from the sidebar to start managing their tasks and subtasks. You can create, update, and delete tasks for the selected client.
                        </p>
                        <div class="flex space-x-4 justify-center">
                            <button id="quick-add-client-btn" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg flex items-center space-x-2 transition-colors">
                                <i class="fas fa-plus"></i>
                                <span>Add New Client</span>
                            </button>
                            <button id="view-all-clients-btn" class="bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-300 px-6 py-3 rounded-lg transition-colors">
                                View All Clients
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Breadcrumb Navigation -->
                <nav id="breadcrumb-nav" class="mb-6 hidden">
                    <ol class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400">
                        <li>
                            <a href="#" onclick="showClientSelectionPrompt()" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                <i class="fas fa-home mr-1"></i> Dashboard
                            </a>
                        </li>
                        <li><i class="fas fa-chevron-right text-xs"></i></li>
                        <li class="font-medium text-gray-800 dark:text-gray-200" id="breadcrumb-client-name">Select Client</li>
                    </ol>
                </nav>

                <!-- Client content (hidden by default) -->
                <div id="client-content" class="hidden">
                    <!-- Client header -->
                    <div class="mb-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div>
                                    <h2 id="selected-client-name" class="text-2xl font-bold text-gray-800 dark:text-white">Acme Corporation</h2>
                                    <div class="flex items-center mt-1 space-x-4">
                                        <span id="selected-client-status" class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                                            <span class="w-2 h-2 bg-blue-500 rounded-full mr-2"></span>
                                            Active
                                        </span>
                                        <span class="text-gray-600 dark:text-gray-400 text-sm">
                                            <i class="fas fa-calendar-alt mr-1"></i>
                                            Joined: <span id="client-join-date">Jan 15, 2023</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex space-x-3">
                                <button id="edit-client-btn" class="bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-300 px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                                    <i class="fas fa-edit"></i>
                                    <span>Edit Client</span>
                                </button>
                                <button id="delete-client-btn" class="bg-red-100 dark:bg-red-900/30 hover:bg-red-200 dark:hover:bg-red-900/50 text-red-700 dark:text-red-400 px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                                    <i class="fas fa-trash-alt"></i>
                                    <span>Delete</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Two-panel layout for tasks -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Left Panel: Main Task Management -->
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
                            <div class="flex items-center justify-between mb-6">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800 dark:text-white">Main Tasks</h3>
                                    <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">Create and manage main tasks for this client</p>
                                </div>
                                <button id="add-main-task-btn" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                                    <i class="fas fa-plus"></i>
                                    <span>Add Task</span>
                                </button>
                            </div>
                            
                            <!-- Main Task Form -->
                            <div id="main-task-form" class="fade-in">
                                <div class="mb-6">
                                    <label for="main-task-title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Task Title</label>
                                    <input type="text" id="main-task-title" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Enter main task title">
                                </div>
                                
                                <div class="mb-6">
                                    <label for="main-task-description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
                                    <textarea id="main-task-description" rows="4" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Describe the main task"></textarea>
                                </div>
                                
                                <!-- Status section removed as per request -->
                                <div class="mb-6">
                                    <div class="flex items-center justify-between">
                                        <span id="main-task-id-display" class="text-xs text-gray-500 dark:text-gray-400">New Task</span>
                                    </div>
                                </div>
                                
                                <div class="flex space-x-3">
                                    <button id="save-main-task-btn" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-lg font-medium transition-colors">
                                        <i class="fas fa-save mr-2"></i>
                                        Save Main Task
                                    </button>
                                    <button id="update-main-task-btn" class="flex-1 bg-green-600 hover:bg-green-700 text-white px-4 py-3 rounded-lg font-medium transition-colors hidden">
                                        <i class="fas fa-sync-alt mr-2"></i>
                                        Update Task
                                    </button>
                                    <button id="cancel-main-task-btn" class="bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-300 px-4 py-3 rounded-lg transition-colors">
                                        Cancel
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Main Tasks List (for selection only) -->
                            <div class="mt-8">
                                <h4 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-4">Select a Main Task to Manage</h4>
                                <div id="main-tasks-list" class="space-y-3 max-h-80 overflow-y-auto pr-2">
                                    <!-- Main tasks will be loaded here dynamically -->
                                    <div class="text-center py-12 text-gray-500 dark:text-gray-400">
                                        <div class="mx-auto w-12 h-12 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-3">
                                            <i class="fas fa-clipboard-list text-xl text-gray-400 dark:text-gray-500"></i>
                                        </div>
                                        <p class="text-sm">No main tasks found for this client.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Right Panel: Subtask Management -->
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
                            <div class="flex items-center justify-between mb-6">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800 dark:text-white">Subtasks</h3>
                                    <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">Manage subtasks for the selected main task</p>
                                </div>
                                <button id="add-subtask-btn" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                                    <i class="fas fa-plus"></i>
                                    <span>Add Subtask</span>
                                </button>
                            </div>
                            
                            <!-- Selected Main Task Info -->
                            <div id="selected-main-task-info" class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg hidden">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h4 id="selected-main-task-title" class="font-medium text-gray-800 dark:text-white">Website Redesign</h4>
                                        <p id="selected-main-task-description" class="text-sm text-gray-600 dark:text-gray-400 mt-1">Complete homepage redesign</p>
                                    </div>
                                    <button id="change-main-task-btn" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 text-sm">
                                        <i class="fas fa-exchange-alt mr-1"></i> Change
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Subtask Form -->
                            <div id="subtask-form" class="fade-in hidden">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                    <div>
                                        <label for="subtask-title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Subtask Title</label>
                                        <input type="text" id="subtask-title" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Enter subtask title">
                                    </div>
                                    
                                    <div>
                                        <label for="subtask-work-date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Work Date</label>
                                        <input type="date" id="subtask-work-date" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>
                                </div>
                                
                                <div class="mb-6">
                                    <label for="subtask-description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
                                    <textarea id="subtask-description" rows="3" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Describe the subtask"></textarea>
                                </div>
                                
                                <div class="mb-6">
                                    <label for="subtask-time-logged" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Time Logged (hours)</label>
                                    <div class="flex items-center">
                                        <input type="range" id="subtask-time-logged-range" min="0" max="40" step="0.5" value="2" class="flex-1 h-2 bg-gray-200 dark:bg-gray-700 rounded-lg appearance-none cursor-pointer">
                                        <input type="number" id="subtask-time-logged" min="0" max="40" step="0.5" value="2" class="ml-4 w-24 px-3 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <span class="ml-2 text-gray-600 dark:text-gray-400">hours</span>
                                    </div>
                                </div>
                                
                                <div class="flex space-x-3">
                                    <button id="save-subtask-btn" class="flex-1 bg-green-600 hover:bg-green-700 text-white px-4 py-3 rounded-lg font-medium transition-colors">
                                        <i class="fas fa-save mr-2"></i>
                                        Save Subtask
                                    </button>
                                    <button id="update-subtask-btn" class="flex-1 bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-3 rounded-lg font-medium transition-colors hidden">
                                        <i class="fas fa-sync-alt mr-2"></i>
                                        Update Subtask
                                    </button>
                                    <button id="cancel-subtask-btn" class="bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-300 px-4 py-3 rounded-lg transition-colors">
                                        Cancel
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Subtask Comments Section -->
                            <div id="subtask-comments-section" class="mt-8 hidden">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center">
                                        <button id="back-to-subtasks-btn" class="mr-3 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition-colors" title="Back to Subtasks">
                                            <i class="fas fa-arrow-left"></i>
                                        </button>
                                        <h4 class="text-lg font-medium text-gray-700 dark:text-gray-300">Comments</h4>
                                    </div>
                                    <button id="add-comment-btn" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 text-sm">
                                        <i class="fas fa-plus mr-1"></i> Add Comment
                                    </button>
                                </div>
                                
                                <!-- Comment Form -->
                                <div id="comment-form" class="mb-6 hidden">
                                    <div class="mb-4">
                                        <label for="comment-text" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Add Comment</label>
                                        <textarea id="comment-text" rows="3" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Enter your comment"></textarea>
                                    </div>
                                    <div class="flex justify-end space-x-3">
                                        <button id="save-comment-btn" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                                            Save Comment
                                        </button>
                                        <button id="cancel-comment-btn" class="bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-300 px-4 py-2 rounded-lg transition-colors">
                                            Cancel
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- Comments List -->
                                <div id="comments-list" class="space-y-4 max-h-60 overflow-y-auto pr-2">
                                    <!-- Comments will be loaded here dynamically -->
                                    <div class="text-center py-6 text-gray-500 dark:text-gray-400">
                                        <p>No comments for this subtask.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Subtasks List -->
                            <div id="subtasks-list" class="mt-8">
                                <h4 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-4">Select a Subtask to Manage</h4>
                                <div id="subtasks-container" class="space-y-3 max-h-80 overflow-y-auto pr-2">
                                    <!-- Subtasks will be loaded here dynamically -->
                                    <div class="text-center py-12 text-gray-500 dark:text-gray-400">
                                        <div class="mx-auto w-12 h-12 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-3">
                                            <i class="fas fa-list-ul text-xl text-gray-400 dark:text-gray-500"></i>
                                        </div>
                                        <p class="text-sm">Select a main task to view its subtasks.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Modal for Add/Edit Client -->
    <div id="client-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl w-full max-w-md mx-4">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 id="client-modal-title" class="text-xl font-bold text-gray-800 dark:text-white">Add New Client</h3>
                    <button id="close-client-modal" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <form id="client-form">
                    <div class="mb-6">
                        <label for="client-name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Client Name</label>
                        <input type="text" id="client-name" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Enter client name" required>
                    </div>
                    
                    <div class="mb-6">
                        <label for="client-status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                        <select id="client-status" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="active">Active</option>
                            <option value="pending">Pending</option>
                            <option value="inactive">Inactive</option>
                            <option value="archived">Archived</option>
                        </select>
                    </div>
                    
                    <div class="flex justify-end space-x-3">
                        <button type="button" id="cancel-client-btn" class="px-5 py-3 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-300 rounded-lg transition-colors">
                            Cancel
                        </button>
                        <button type="submit" id="save-client-btn" class="px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                            Save Client
                        </button>
                        <button type="submit" id="update-client-btn" class="px-5 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors hidden">
                            Update Client
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirmation-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl w-full max-w-md mx-4">
            <div class="p-6">
                <div class="flex items-center justify-center mb-6">
                    <div class="w-16 h-16 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-3xl text-red-600 dark:text-red-400"></i>
                    </div>
                </div>
                
                <h3 id="confirmation-title" class="text-xl font-bold text-center text-gray-800 dark:text-white mb-4">Confirm Deletion</h3>
                <p id="confirmation-message" class="text-gray-600 dark:text-gray-400 text-center mb-8">
                    Are you sure you want to delete this item? This action cannot be undone.
                </p>
                
                <div class="flex justify-center space-x-4">
                    <button id="cancel-confirmation-btn" class="px-6 py-3 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-300 rounded-lg transition-colors">
                        Cancel
                    </button>
                    <button id="confirm-delete-btn" class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors">
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Notification -->
    <div id="success-notification" class="fixed top-6 right-6 w-[calc(100%-3rem)] md:w-auto max-w-md bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg flex items-center space-x-3 transform translate-x-[150%] transition-transform duration-300 z-50 invisible">
        <i class="fas fa-check-circle text-xl"></i>
        <div>
            <p class="font-medium" id="success-message">Operation completed successfully!</p>
        </div>
    </div>

    <!-- Error Notification -->
    <div id="error-notification" class="fixed top-6 right-6 w-[calc(100%-3rem)] md:w-auto max-w-md bg-red-500 text-white px-6 py-4 rounded-lg shadow-lg flex items-center space-x-3 transform translate-x-[150%] transition-transform duration-300 z-50 invisible">
        <i class="fas fa-exclamation-circle text-xl"></i>
        <div>
            <p class="font-medium" id="error-message">An error occurred. Please try again.</p>
        </div>
    </div>

    <!-- Profile Modal -->
    <div id="profile-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden overflow-y-auto">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl w-full max-w-md mx-4 my-8">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white">Profile & Security</h3>
                    <button id="close-profile-modal" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <!-- Profile Information Section -->
                <div class="mb-8">
                    <h4 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">Profile Information</h4>
                    <form id="profile-form">
                        <div class="mb-4">
                            <label for="profile-name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Display Name</label>
                            <input type="text" id="profile-name" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ auth()->user()->name }}" required>
                        </div>
                        
                        <div class="mb-6">
                            <label for="profile-email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email Address</label>
                            <input type="email" id="profile-email" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ auth()->user()->email }}" required>
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors text-sm font-medium">Update Info</button>
                        </div>
                    </form>
                </div>

                <div class="border-t border-gray-200 dark:border-gray-700 my-6"></div>

                <!-- Password Change Section -->
                <div>
                    <h4 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">Change Password</h4>
                    <form id="password-form">
                        <div class="mb-4">
                            <label for="current-password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Current Password</label>
                            <input type="password" id="current-password" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="••••••••" required>
                        </div>
                        
                        <div class="mb-4">
                            <label for="new-password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">New Password</label>
                            <input type="password" id="new-password" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="••••••••" required>
                        </div>

                        <div class="mb-6">
                            <label for="new-password-confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Confirm New Password</label>
                            <input type="password" id="new-password-confirmation" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="••••••••" required>
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="submit" class="px-5 py-2.5 bg-gray-800 dark:bg-gray-200 text-white dark:text-gray-800 hover:bg-gray-900 dark:hover:bg-white rounded-lg transition-colors text-sm font-medium">Update Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // DOM Elements
        const appContainer = document.getElementById('app');
        const themeToggle = document.getElementById('theme-toggle');
        const themeIcon = document.getElementById('theme-icon');
        const userMenuButton = document.getElementById('user-menu-button');
        const userDropdown = document.getElementById('user-dropdown');
        const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebar-overlay');
        const closeSidebarBtn = document.getElementById('close-sidebar');
        const clientItems = document.querySelectorAll('.client-item');
        const clientSearch = document.getElementById('client-search');
        const addClientBtn = document.getElementById('add-client-btn');
        const quickAddClientBtn = document.getElementById('quick-add-client-btn');
        const addFirstClientBtn = document.getElementById('add-first-client-btn');
        const viewAllClientsBtn = document.getElementById('view-all-clients-btn');
        const clientSelectionPrompt = document.getElementById('client-selection-prompt');
        const clientContent = document.getElementById('client-content');
        const selectedClientName = document.getElementById('selected-client-name');
        const selectedClientStatus = document.getElementById('selected-client-status');
        const editClientBtn = document.getElementById('edit-client-btn');
        const deleteClientBtn = document.getElementById('delete-client-btn');
        const clientModal = document.getElementById('client-modal');
        const closeClientModal = document.getElementById('close-client-modal');
        const cancelClientBtn = document.getElementById('cancel-client-btn');
        const clientForm = document.getElementById('client-form');
        const clientModalTitle = document.getElementById('client-modal-title');
        const saveClientBtn = document.getElementById('save-client-btn');
        const updateClientBtn = document.getElementById('update-client-btn');
        const confirmationModal = document.getElementById('confirmation-modal');
        const cancelConfirmationBtn = document.getElementById('cancel-confirmation-btn');
        const confirmDeleteBtn = document.getElementById('confirm-delete-btn');
        const confirmationTitle = document.getElementById('confirmation-title');
        const confirmationMessage = document.getElementById('confirmation-message');
        const successNotification = document.getElementById('success-notification');
        const errorNotification = document.getElementById('error-notification');
        const successMessage = document.getElementById('success-message');
        const errorMessage = document.getElementById('error-message');
        
        // Profile & Security Elements
        const profileBtn = document.getElementById('profile-btn');
        const profileModal = document.getElementById('profile-modal');
        const closeProfileModal = document.getElementById('close-profile-modal');
        const cancelProfileBtn = document.getElementById('cancel-profile-btn');
        const profileForm = document.getElementById('profile-form');
        const passwordForm = document.getElementById('password-form');
        
        // Main Task Elements
        const addMainTaskBtn = document.getElementById('add-main-task-btn');
        const mainTaskForm = document.getElementById('main-task-form');
        const saveMainTaskBtn = document.getElementById('save-main-task-btn');
        const updateMainTaskBtn = document.getElementById('update-main-task-btn');
        const cancelMainTaskBtn = document.getElementById('cancel-main-task-btn');
        const mainTaskItems = document.querySelectorAll('.main-task-item');
        const mainTaskTitle = document.getElementById('main-task-title');
        const mainTaskDescription = document.getElementById('main-task-description');
        const taskStatusButtons = document.querySelectorAll('.task-status-btn');
        
        // Subtask Elements
        const addSubtaskBtn = document.getElementById('add-subtask-btn');
        const selectedMainTaskInfo = document.getElementById('selected-main-task-info');
        const selectedMainTaskTitle = document.getElementById('selected-main-task-title');
        const selectedMainTaskDescription = document.getElementById('selected-main-task-description');
        const changeMainTaskBtn = document.getElementById('change-main-task-btn');
        const subtaskForm = document.getElementById('subtask-form');
        const saveSubtaskBtn = document.getElementById('save-subtask-btn');
        const updateSubtaskBtn = document.getElementById('update-subtask-btn');
        const cancelSubtaskBtn = document.getElementById('cancel-subtask-btn');
        const subtaskTitle = document.getElementById('subtask-title');
        const subtaskDescription = document.getElementById('subtask-description');
        const subtaskWorkDate = document.getElementById('subtask-work-date');
        const subtaskTimeLogged = document.getElementById('subtask-time-logged');
        const subtaskTimeLoggedRange = document.getElementById('subtask-time-logged-range');
        const subtaskItems = document.querySelectorAll('.subtask-item');
        const subtasksList = document.getElementById('subtasks-list');
        const subtaskCommentsSection = document.getElementById('subtask-comments-section');
        const addCommentBtn = document.getElementById('add-comment-btn');
        const commentForm = document.getElementById('comment-form');
        const saveCommentBtn = document.getElementById('save-comment-btn');
        const cancelCommentBtn = document.getElementById('cancel-comment-btn');
        const commentText = document.getElementById('comment-text');
        
        // State variables
        let currentClientId = window.App.selectedClient ? window.App.selectedClient.id : null;
        let editingClientId = null;
        let currentMainTaskId = null;
        let currentSubtaskId = null;
        let currentCommentId = null;
        let deleteCallback = null;
        let currentDeleteType = null;
        
        // Helper for API calls
        async function apiCall(url, method = 'GET', data = null) {
            const options = {
                method,
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': window.App.csrfToken
                }
            };
            
            if (data) {
                options.body = JSON.stringify(data);
            }
            
            try {
                const response = await fetch(url, options);
                const result = await response.json();
                
                if (!response.ok) {
                    throw new Error(result.message || 'Something went wrong');
                }
                
                return result;
            } catch (error) {
                showErrorNotification(error.message);
                throw error;
            }
        }

        // Initialize the UI
        function init() {
            // Update icon state based on current theme (now applied in head)
            if (document.documentElement.classList.contains('dark')) {
                themeIcon.classList.remove('fa-moon');
                themeIcon.classList.add('fa-sun');
            } else {
                themeIcon.classList.remove('fa-sun');
                themeIcon.classList.add('fa-moon');
            }
            
            // Set default date for subtask work date
            const today = new Date().toISOString().split('T')[0];
            subtaskWorkDate.value = today;
            
            // Set up event listeners
            setupEventListeners();
            
            // Show initial state
            if (window.App.selectedClient) {
                showClientContent();
                // Optionally load main tasks if they aren't already in App.selectedClient
                renderMainTasks(window.App.selectedClient.main_tasks || []);
                
                // Set join date for initial client
                const joinDate = new Date(window.App.selectedClient.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                document.getElementById('client-join-date').textContent = joinDate;
            } else {
                showClientSelectionPrompt();
            }
        }
        
        // Set up all event listeners
        function setupEventListeners() {
            // Theme toggle
            themeToggle.addEventListener('click', toggleDarkMode);
            
            // User dropdown
            userMenuButton.addEventListener('click', toggleUserDropdown);
            
            // Mobile menu toggle
            if (mobileMenuToggle) {
                mobileMenuToggle.addEventListener('click', toggleMobileMenu);
            }
            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', closeMobileMenu);
            }
            if (closeSidebarBtn) {
                closeSidebarBtn.addEventListener('click', closeMobileMenu);
            }

            document.addEventListener('click', (e) => {
                if (!userMenuButton.contains(e.target) && !userDropdown.contains(e.target)) {
                    userDropdown.classList.add('hidden');
                }
            });
            
            // Client selection (Delegation)
            document.getElementById('clients-list-container').addEventListener('click', (e) => {
                const item = e.target.closest('.client-item');
                if (item) selectClient(item);
            });
            
            // Client search
            clientSearch.addEventListener('input', filterClients);
            
            // Add client buttons
            addClientBtn.addEventListener('click', () => openClientModal('add'));
            quickAddClientBtn.addEventListener('click', () => openClientModal('add'));
            addFirstClientBtn.addEventListener('click', () => openClientModal('add'));
            
            // View all clients
            viewAllClientsBtn.addEventListener('click', () => {
                clientSearch.value = '';
                filterClients();
            });
            
            // Client modal
            closeClientModal.addEventListener('click', () => closeClientModalFunc());
            cancelClientBtn.addEventListener('click', () => closeClientModalFunc());
            clientForm.addEventListener('submit', handleClientFormSubmit);
            
            // Edit and delete client buttons
            editClientBtn.addEventListener('click', () => {
                const client = window.App.clients.find(c => c.id == currentClientId);
                if (client) openClientModal('edit', client.id, client.name);
            });
            deleteClientBtn.addEventListener('click', () => {
                const client = window.App.clients.find(c => c.id == currentClientId);
                if (client) openConfirmationModal('client', client.name, deleteCurrentClient);
            });
            
            // Confirmation modal
            cancelConfirmationBtn.addEventListener('click', () => closeConfirmationModal());
            
            // Main task buttons
            addMainTaskBtn.addEventListener('click', () => openMainTaskForm('add'));
            cancelMainTaskBtn.addEventListener('click', resetMainTaskForm);
            saveMainTaskBtn.addEventListener('click', saveMainTask);
            updateMainTaskBtn.addEventListener('click', updateMainTask);
            
            // Task status buttons logic removed
            
            // Main task list event delegation
            document.getElementById('main-tasks-list').addEventListener('click', (e) => {
                const item = e.target.closest('.main-task-item');
                if (!item) return;

                if (e.target.closest('.edit-main-task-btn')) {
                    e.stopPropagation();
                    const taskId = item.getAttribute('data-task-id');
                    const task = findMainTask(taskId);
                    if (task) openMainTaskForm('edit', task.id, task.title, task.description);
                } else if (e.target.closest('.delete-main-task-btn')) {
                    e.stopPropagation();
                    const taskId = item.getAttribute('data-task-id');
                    const task = findMainTask(taskId);
                    if (task) openConfirmationModal('main task', task.title, () => deleteMainTask(taskId));
                } else {
                    selectMainTask(item);
                }
            });
            
            // Subtask buttons
            addSubtaskBtn.addEventListener('click', () => openSubtaskForm('add'));
            
            // Profile & Security listeners
            if (profileBtn) profileBtn.addEventListener('click', openProfileModal);
            if (closeProfileModal) closeProfileModal.addEventListener('click', closeProfileModalFunc);
            if (cancelProfileBtn) cancelProfileBtn.addEventListener('click', closeProfileModalFunc);
            if (profileForm) profileForm.addEventListener('submit', handleProfileUpdate);
            if (passwordForm) passwordForm.addEventListener('submit', handlePasswordUpdate);
            cancelSubtaskBtn.addEventListener('click', resetSubtaskForm);
            saveSubtaskBtn.addEventListener('click', saveSubtask);
            updateSubtaskBtn.addEventListener('click', updateSubtask);
            changeMainTaskBtn.addEventListener('click', () => resetMainTaskSelection());
            
            // Time logged sync
            subtaskTimeLoggedRange.addEventListener('input', () => {
                subtaskTimeLogged.value = subtaskTimeLoggedRange.value;
            });
            subtaskTimeLogged.addEventListener('input', () => {
                subtaskTimeLoggedRange.value = subtaskTimeLogged.value;
            });
            
            // Subtasks list event delegation
            document.getElementById('subtasks-container').addEventListener('click', (e) => {
                const item = e.target.closest('.subtask-item');
                if (!item) return;

                if (e.target.closest('.edit-subtask-btn')) {
                    e.stopPropagation();
                    const subtaskId = item.getAttribute('data-subtask-id');
                    const subtask = findSubtask(subtaskId);
                    if (subtask) openSubtaskForm('edit', subtask.id, subtask.title, subtask.time_logged, subtask.work_date, subtask.description);
                } else if (e.target.closest('.delete-subtask-btn')) {
                    e.stopPropagation();
                    const subtaskId = item.getAttribute('data-subtask-id');
                    const subtask = findSubtask(subtaskId);
                    if (subtask) openConfirmationModal('subtask', subtask.title, () => deleteSubtask(subtaskId));
                } else {
                    selectSubtask(item);
                }
            });
            
            // Comment buttons
            addCommentBtn.addEventListener('click', () => openCommentForm('add'));
            cancelCommentBtn.addEventListener('click', resetCommentForm);
            saveCommentBtn.addEventListener('click', saveComment);
            
            // Comments list event delegation
            document.getElementById('comments-list').addEventListener('click', (e) => {
                const item = e.target.closest('.comment-item');
                if (!item) return;

                if (e.target.closest('.edit-comment-btn')) {
                    const commentId = item.getAttribute('data-comment-id');
                    const comment = findComment(commentId);
                    if (comment) openCommentForm('edit', comment.id, comment.comment);
                } else if (e.target.closest('.delete-comment-btn')) {
                    const commentId = item.getAttribute('data-comment-id');
                    openConfirmationModal('comment', 'this comment', () => deleteComment(commentId));
                }
            });

            // Back to subtasks button
            document.getElementById('back-to-subtasks-btn').addEventListener('click', () => {
                subtaskCommentsSection.classList.add('hidden');
                subtasksList.classList.remove('hidden');
                currentSubtaskId = null;
            });
        }
        
        // Theme functionality
        function toggleDarkMode() {
            if (document.documentElement.classList.contains('dark')) {
                disableDarkMode();
                localStorage.setItem('theme', 'light');
            } else {
                enableDarkMode();
                localStorage.setItem('theme', 'dark');
            }
        }
        
        function enableDarkMode() {
            document.documentElement.classList.add('dark');
            themeIcon.classList.remove('fa-moon');
            themeIcon.classList.add('fa-sun');
        }
        
        function disableDarkMode() {
            document.documentElement.classList.remove('dark');
            themeIcon.classList.remove('fa-sun');
            themeIcon.classList.add('fa-moon');
        }
        
        // User dropdown functionality
        function toggleUserDropdown() {
            userDropdown.classList.toggle('hidden');
        }
        
        function toggleMobileMenu() {
            sidebar.classList.toggle('-translate-x-full');
            sidebarOverlay.classList.toggle('hidden');
            document.body.classList.toggle('overflow-hidden');
        }
        
        function closeMobileMenu() {
            sidebar.classList.add('-translate-x-full');
            sidebarOverlay.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
        
        // Client functionality
        async function selectClient(clientItem) {
            const clientId = clientItem.getAttribute('data-client-id');
            if (clientId == currentClientId) return;

            // Update UI instantly for feedback
            const items = document.querySelectorAll('.client-item');
            items.forEach(item => {
                item.classList.remove('bg-blue-50', 'dark:bg-blue-900/20', 'border-blue-200', 'dark:border-blue-800');
                item.classList.add('bg-white', 'dark:bg-gray-800', 'border-gray-200', 'dark:border-gray-700');
            });
            clientItem.classList.remove('bg-white', 'dark:bg-gray-800', 'border-gray-200', 'dark:border-gray-700');
            clientItem.classList.add('bg-blue-50', 'dark:bg-blue-900/20', 'border-blue-200', 'dark:border-blue-800');
            
            currentClientId = clientId;
            
            // Close mobile menu if open
            if (window.innerWidth < 768) {
                closeMobileMenu();
            }
            
            // Load client data
            try {
                // In this simplified dashboard, we might just reload the page or fetch tasks
                // To keep it SPA-like, we fetch tasks if needed, but here we can just find it in App.clients
                const client = window.App.clients.find(c => c.id == clientId);
                if (client) {
                    selectedClientName.textContent = client.name;
                    // For status, let's assume active for now
                    selectedClientStatus.innerHTML = `<span class="w-2 h-2 bg-blue-500 rounded-full mr-2"></span>Active`;
                    
                    // Render main tasks (they should be loaded via a separate API if not in App.clients)
                    // For now, let's assume they are joined
                    renderMainTasks(client.main_tasks || []);
                    
                    // Render join date
                    const joinDate = new Date(client.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                    document.getElementById('client-join-date').textContent = joinDate;
                    
                    // Update breadcrumb
                    document.getElementById('breadcrumb-client-name').textContent = client.name;
                    
                    showClientContent();
                    resetMainTaskForm();
                    resetMainTaskSelection();

                    // Mobile: Scroll to content
                    if (window.innerWidth < 768) {
                        document.getElementById('client-content').scrollIntoView({ behavior: 'smooth' });
                    }
                }
            } catch (error) {
                showErrorNotification("Failed to load client details");
            }
        }
        
        function renderMainTasks(tasks) {
            const list = document.getElementById('main-tasks-list');
            if (tasks.length === 0) {
                list.innerHTML = `
                    <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                        <i class="fas fa-info-circle mb-2"></i>
                        <p>No main tasks found for this client.</p>
                    </div>`;
                return;
            }
            
            list.innerHTML = tasks.map(task => `
                <div class="main-task-item p-4 border border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors" data-task-id="${task.id}">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg flex items-center justify-center">
                                <i class="fas fa-project-diagram"></i>
                            </div>
                            <div>
                                <h5 class="font-medium text-gray-800 dark:text-white">${task.title}</h5>
                                <p class="text-sm text-gray-600 dark:text-gray-400">${task.description || 'No description'}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="hidden md:block text-xs bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 px-2 py-1 rounded">By: ${task.user ? task.user.name : 'Unknown'}</span>
                            <button class="edit-main-task-btn text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 p-1">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="delete-main-task-btn text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 p-1">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        function filterClients() {
            const searchTerm = clientSearch.value.toLowerCase();
            let visibleCount = 0;
            
            const items = document.querySelectorAll('.client-item');
            items.forEach(item => {
                const clientName = item.querySelector('h3').textContent.toLowerCase();
                if (clientName.includes(searchTerm)) {
                    item.classList.remove('hidden');
                    visibleCount++;
                } else {
                    item.classList.add('hidden');
                }
            });
            
            const noClientsMessage = document.getElementById('no-clients-message');
            if (visibleCount === 0 && searchTerm !== '') {
                noClientsMessage.classList.remove('hidden');
            } else {
                noClientsMessage.classList.add('hidden');
            }
        }
        
        function showClientSelectionPrompt() {
            clientSelectionPrompt.classList.remove('hidden');
            clientContent.classList.add('hidden');
            document.getElementById('breadcrumb-nav').classList.add('hidden');
        }
        
        function showClientContent() {
            clientSelectionPrompt.classList.add('hidden');
            clientContent.classList.remove('hidden');
            document.getElementById('breadcrumb-nav').classList.remove('hidden');
        }
        
        function openClientModal(mode, clientId = null, clientName = '') {
            if (mode === 'add') {
                clientModalTitle.textContent = 'Add New Client';
                saveClientBtn.classList.remove('hidden');
                updateClientBtn.classList.add('hidden');
                document.getElementById('client-name').value = '';
                editingClientId = null;
            } else if (mode === 'edit') {
                clientModalTitle.textContent = 'Edit Client';
                saveClientBtn.classList.add('hidden');
                updateClientBtn.classList.remove('hidden');
                document.getElementById('client-name').value = clientName;
                editingClientId = clientId;
            }
            clientModal.classList.remove('hidden');
        }
        
        function closeClientModalFunc() {
            clientModal.classList.add('hidden');
        }
        
        async function handleClientFormSubmit(e) {
            e.preventDefault();
            const name = document.getElementById('client-name').value;
            
            try {
                if (!editingClientId) {
                    const result = await apiCall('/dashboard/clients', 'POST', { name });
                    window.App.clients.push(result.client);
                    showSuccessNotification(result.message);
                    renderClientsList();
                } else {
                    const result = await apiCall(`/dashboard/clients/${editingClientId}`, 'PUT', { name });
                    const index = window.App.clients.findIndex(c => c.id == editingClientId);
                    if (index !== -1) {
                        window.App.clients[index] = { ...window.App.clients[index], ...result.client };
                    }
                    showSuccessNotification(result.message);
                    renderClientsList();
                    if (selectedClientName && currentClientId == editingClientId) {
                        selectedClientName.textContent = name;
                    }
                }
                closeClientModalFunc();
            } catch (error) {}
        }

        async function deleteCurrentClient() {
            if (!currentClientId) return;
            
            try {
                const result = await apiCall(`/dashboard/clients/${currentClientId}`, 'DELETE');
                window.App.clients = window.App.clients.filter(c => c.id != currentClientId);
                
                showSuccessNotification(result.message);
                renderClientsList();
                
                // Reset selection
                currentClientId = null;
                showClientSelectionPrompt();
                
                // Close modal
                closeConfirmationModal();
            } catch (error) {}
        }
        
        function renderClientsList() {
            const container = document.getElementById('clients-list-container');
            container.innerHTML = window.App.clients.map(client => `
                <div class="client-item p-4 ${currentClientId == client.id ? 'bg-blue-50 dark:bg-blue-900/20 border-blue-200 dark:border-blue-800' : 'bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700'} border rounded-lg cursor-pointer transition-all hover:shadow-md" data-client-id="${client.id}">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                            <h3 class="font-semibold text-gray-800 dark:text-white">${client.name}</h3>
                        </div>
                        <span class="text-xs bg-blue-100 dark:bg-blue-800 text-blue-800 dark:text-blue-200 px-2 py-1 rounded">Active</span>
                    </div>

                </div>
            `).join('');
        }

        async function deleteCurrentClient() {
            try {
                const result = await apiCall(`/dashboard/clients/${currentClientId}`, 'DELETE');
                window.App.clients = window.App.clients.filter(c => c.id != currentClientId);
                showSuccessNotification(result.message);
                renderClientsList();
                showClientSelectionPrompt();
                currentClientId = null;
                closeConfirmationModal();
            } catch (error) {}
        }
        
        // Main task functionality
        function openMainTaskForm(mode, taskId = null, title = '', description = '') {
            if (mode === 'add') {
                mainTaskTitle.value = '';
                mainTaskDescription.value = '';
                saveMainTaskBtn.classList.remove('hidden');
                updateMainTaskBtn.classList.add('hidden');
                document.getElementById('main-task-id-display').textContent = 'New Task';
            } else if (mode === 'edit') {
                mainTaskTitle.value = title;
                mainTaskDescription.value = description;
                saveMainTaskBtn.classList.add('hidden');
                updateMainTaskBtn.classList.remove('hidden');
                document.getElementById('main-task-id-display').textContent = `Task ID: ${taskId}`;
                currentMainTaskId = taskId;
            }
            mainTaskForm.classList.remove('hidden');
        }
        
        function resetMainTaskForm() {
            mainTaskForm.classList.add('hidden');
            mainTaskTitle.value = '';
            mainTaskDescription.value = '';
        }
        
        async function saveMainTask() {
            const title = mainTaskTitle.value;
            const description = mainTaskDescription.value;
            if (!title.trim()) return showErrorNotification('Please enter a task title');
            
            try {
                const result = await apiCall('/dashboard/main-tasks', 'POST', {
                    client_id: currentClientId,
                    title,
                    description
                });
                const client = findClient(currentClientId);
                if (client) {
                    if (!client.main_tasks) client.main_tasks = [];
                    client.main_tasks.push(result.mainTask);
                }
                renderMainTasks(client.main_tasks);
                renderClientsList();
                showSuccessNotification(result.message);
                resetMainTaskForm();
            } catch (error) {}
        }
        
        async function updateMainTask() {
            const title = mainTaskTitle.value;
            const description = mainTaskDescription.value;
            if (!title.trim()) return showErrorNotification('Please enter a task title');
            
            try {
                const result = await apiCall(`/dashboard/main-tasks/${currentMainTaskId}`, 'PUT', {
                    title,
                    description
                });
                const client = findClient(currentClientId);
                const taskIndex = client.main_tasks.findIndex(t => t.id == currentMainTaskId);
                if (taskIndex !== -1) {
                    client.main_tasks[taskIndex] = { ...client.main_tasks[taskIndex], ...result.mainTask };
                    
                    // Update the selected task info panel if this is the active main task
                    if (currentMainTaskId == result.mainTask.id) {
                        selectedMainTaskTitle.textContent = result.mainTask.title;
                        selectedMainTaskDescription.textContent = result.mainTask.description || 'No description';
                    }
                }
                
                renderMainTasks(client.main_tasks);
                renderClientsList();
                showSuccessNotification(result.message);
                resetMainTaskForm();
            } catch (error) {}
        }
        
        function selectMainTask(taskItem) {
            const taskId = taskItem.getAttribute('data-task-id');
            const task = findMainTask(taskId);
            if (!task) return;

            selectedMainTaskTitle.textContent = task.title;
            selectedMainTaskDescription.textContent = task.description || 'No description';
            selectedMainTaskInfo.classList.remove('hidden');
            addSubtaskBtn.disabled = false;
            currentMainTaskId = taskId;
            
            renderSubtasks(task.subtasks || []);

            // Mobile: Scroll to subtasks section
            if (window.innerWidth < 1024) {
                document.getElementById('subtasks-list').scrollIntoView({ behavior: 'smooth' });
            }
            
            // Update breadcrumb
            const breadcrumbEl = document.getElementById('breadcrumb-client-name');
            const clientName = breadcrumbEl.textContent.split(' > ')[0];
            breadcrumbEl.textContent = `${clientName} > ${task.title}`;

            subtasksList.classList.remove('hidden');
            subtaskForm.classList.add('hidden');
            subtaskCommentsSection.classList.add('hidden');
        }
        
        function renderSubtasks(subtasks) {
            const container = document.getElementById('subtasks-container');
            if (subtasks.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-12 text-gray-500 dark:text-gray-400">
                        <div class="mx-auto w-12 h-12 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-3">
                            <i class="fas fa-list-ul text-xl text-gray-400 dark:text-gray-500"></i>
                        </div>
                        <p class="text-sm">No subtasks found.</p>
                    </div>`;
                return;
            }
            
            container.innerHTML = subtasks.map(s => `
                <div class="subtask-item p-4 border border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors" data-subtask-id="${s.id}">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg flex items-center justify-center">
                                <i class="fas fa-pencil-alt"></i>
                            </div>
                            <div>
                                <h5 class="font-medium text-gray-800 dark:text-white">${s.title}</h5>
                                <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                    <i class="fas fa-clock mr-1"></i><span>${s.time_logged} hours logged</span>
                                    <i class="fas fa-calendar-alt mx-2"></i><span>${s.work_date}</span>
                                    <span class="ml-2 hidden lg:inline-block text-xs italic bg-gray-100 dark:bg-gray-700 px-2 py-0.5 rounded">By: ${s.user ? s.user.name : 'Unknown'}</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button class="edit-subtask-btn text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 p-1"><i class="fas fa-edit"></i></button>
                            <button class="delete-subtask-btn text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 p-1"><i class="fas fa-trash-alt"></i></button>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        function resetMainTaskSelection() {
            selectedMainTaskInfo.classList.add('hidden');
            addSubtaskBtn.disabled = true;
            subtaskForm.classList.add('hidden');
            subtasksList.classList.remove('hidden');
            subtaskCommentsSection.classList.add('hidden');
            currentMainTaskId = null;
            currentSubtaskId = null;
            
            // Clear lists to prevent stale data
            // Clear lists to prevent stale data
            document.getElementById('subtasks-container').innerHTML = `
                <div class="text-center py-12 text-gray-500 dark:text-gray-400">
                    <div class="mx-auto w-12 h-12 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-3">
                        <i class="fas fa-list-ul text-xl text-gray-400 dark:text-gray-500"></i>
                    </div>
                    <p class="text-sm">Select a main task to view its subtasks.</p>
                </div>`;
            document.getElementById('comments-list').innerHTML = '';
            
            // Reset breadcrumb (if element exists to avoid errors on init)
            const breadcrumbEl = document.getElementById('breadcrumb-client-name');
            if (breadcrumbEl && breadcrumbEl.textContent.includes(' > ')) {
                const clientName = breadcrumbEl.textContent.split(' > ')[0];
                breadcrumbEl.textContent = clientName;
            }
        }
        
        async function deleteMainTask(taskId) {
            try {
                const result = await apiCall(`/dashboard/main-tasks/${taskId}`, 'DELETE');
                const client = findClient(currentClientId);
                client.main_tasks = client.main_tasks.filter(t => t.id != taskId);
                renderMainTasks(client.main_tasks);
                renderClientsList();
                showSuccessNotification(result.message);
                if (currentMainTaskId == taskId) resetMainTaskSelection();
                closeConfirmationModal();
            } catch (error) {}
        }
        
        // Subtask functionality
        function openSubtaskForm(mode, subtaskId = null, title = '', timeLogged = 2, workDate = '', description = '') {
            if (mode === 'add') {
                subtaskTitle.value = '';
                subtaskDescription.value = '';
                subtaskTimeLogged.value = '2';
                subtaskTimeLoggedRange.value = '2';
                subtaskWorkDate.value = new Date().toISOString().split('T')[0];
                saveSubtaskBtn.classList.remove('hidden');
                updateSubtaskBtn.classList.add('hidden');
                currentSubtaskId = null;
            } else if (mode === 'edit') {
                subtaskTitle.value = title;
                subtaskDescription.value = description;
                subtaskTimeLogged.value = timeLogged;
                subtaskTimeLoggedRange.value = timeLogged;
                subtaskWorkDate.value = workDate;
                saveSubtaskBtn.classList.add('hidden');
                updateSubtaskBtn.classList.remove('hidden');
                currentSubtaskId = subtaskId;
            }
            subtaskForm.classList.remove('hidden');
            subtasksList.classList.add('hidden');
            subtaskCommentsSection.classList.add('hidden');
        }
        
        function resetSubtaskForm() {
            subtaskForm.classList.add('hidden');
            subtasksList.classList.remove('hidden');
            currentSubtaskId = null;
        }
        
        async function saveSubtask() {
            const title = subtaskTitle.value;
            const description = subtaskDescription.value;
            const work_date = subtaskWorkDate.value;
            const time_logged = subtaskTimeLogged.value;
            if (!title.trim()) return showErrorNotification('Please enter a subtask title');
            
            try {
                const result = await apiCall('/dashboard/subtasks', 'POST', {
                    main_task_id: currentMainTaskId,
                    title,
                    description,
                    work_date,
                    time_logged
                });
                const task = findMainTask(currentMainTaskId);
                if (!task.subtasks) task.subtasks = [];
                task.subtasks.push(result.subtask);
                renderSubtasks(task.subtasks);
                showSuccessNotification(result.message);
                resetSubtaskForm();
            } catch (error) {}
        }
        
        async function updateSubtask() {
            const title = subtaskTitle.value;
            const description = subtaskDescription.value;
            const work_date = subtaskWorkDate.value;
            const time_logged = subtaskTimeLogged.value;
            if (!title.trim()) return showErrorNotification('Please enter a subtask title');
            
            try {
                const result = await apiCall(`/dashboard/subtasks/${currentSubtaskId}`, 'PUT', {
                    title,
                    description,
                    work_date,
                    time_logged
                });
                const task = findMainTask(currentMainTaskId);
                const idx = task.subtasks.findIndex(s => s.id == currentSubtaskId);
                if (idx !== -1) {
                    task.subtasks[idx] = { ...task.subtasks[idx], ...result.subtask };
                }
                renderSubtasks(task.subtasks);
                showSuccessNotification(result.message);
                resetSubtaskForm();
            } catch (error) {}
        }
        
        function selectSubtask(subtaskItem) {
            const subtaskId = subtaskItem.getAttribute('data-subtask-id');
            const subtask = findSubtask(subtaskId);
            if (!subtask) return;

            currentSubtaskId = subtaskId;
            renderComments(subtask.comments || []);
            subtaskCommentsSection.classList.remove('hidden');
            subtasksList.classList.add('hidden');
            subtaskForm.classList.add('hidden');
        }
        
        function renderComments(comments) {
            const container = document.getElementById('comments-list');
            if (comments.length === 0) {
                container.innerHTML = `<div class="text-center py-6 text-gray-500 dark:text-gray-400"><p>No comments for this subtask.</p></div>`;
                return;
            }
            
            container.innerHTML = comments.map(c => `
                <div class="comment-item p-4 border border-gray-200 dark:border-gray-700 rounded-lg" data-comment-id="${c.id}">
                    <div class="flex justify-between items-start">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-purple-100 dark:bg-purple-900/30 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-purple-600 dark:text-purple-400"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800 dark:text-white">${c.user ? c.user.name : 'Unknown User'}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">${new Date(c.created_at).toLocaleString()}</p>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <button class="edit-comment-btn text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300"><i class="fas fa-edit"></i></button>
                            <button class="delete-comment-btn text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300"><i class="fas fa-trash-alt"></i></button>
                        </div>
                    </div>
                    <p class="mt-3 text-gray-700 dark:text-gray-300">${c.comment}</p>
                </div>
            `).join('');
        }

        async function deleteSubtask(subtaskId) {
            try {
                const result = await apiCall(`/dashboard/subtasks/${subtaskId}`, 'DELETE');
                const task = findMainTask(currentMainTaskId);
                task.subtasks = task.subtasks.filter(s => s.id != subtaskId);
                renderSubtasks(task.subtasks);
                showSuccessNotification(result.message);
                if (currentSubtaskId == subtaskId) {
                    subtaskCommentsSection.classList.add('hidden');
                    subtasksList.classList.remove('hidden');
                }
                closeConfirmationModal();
            } catch (error) {}
        }
        
        // Comment functionality
        function openCommentForm(mode, commentId = null, text = '') {
            if (mode === 'add') {
                commentText.value = '';
                currentCommentId = null;
            } else if (mode === 'edit') {
                commentText.value = text;
                currentCommentId = commentId;
            }
            commentForm.classList.remove('hidden');
        }
        
        function resetCommentForm() {
            commentForm.classList.add('hidden');
            commentText.value = '';
            currentCommentId = null;
        }
        
        async function saveComment() {
            const comment = commentText.value;
            if (!comment.trim()) return showErrorNotification('Please enter a comment');
            
            try {
                if (!currentCommentId) {
                    const result = await apiCall('/dashboard/comments', 'POST', {
                        sub_task_id: currentSubtaskId,
                        comment
                    });
                    const subtask = findSubtask(currentSubtaskId);
                    if (!subtask.comments) subtask.comments = [];
                    subtask.comments.push(result.comment);
                    renderComments(subtask.comments);
                    showSuccessNotification(result.message);
                } else {
                    const result = await apiCall(`/dashboard/comments/${currentCommentId}`, 'PUT', { comment });
                    const subtask = findSubtask(currentSubtaskId);
                    const idx = subtask.comments.findIndex(c => c.id == currentCommentId);
                    if (idx !== -1) subtask.comments[idx] = result.comment;
                    renderComments(subtask.comments);
                    showSuccessNotification(result.message);
                }
                resetCommentForm();
            } catch (error) {}
        }
        
        // Profile & Security
        function openProfileModal() {
            profileModal.classList.remove('hidden');
            userDropdown.classList.add('hidden');
            document.body.classList.add('overflow-hidden');
            passwordForm.reset();
        }

        function closeProfileModalFunc() {
            profileModal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        async function handleProfileUpdate(e) {
            e.preventDefault();
            const name = document.getElementById('profile-name').value;
            const email = document.getElementById('profile-email').value;

            try {
                const result = await apiCall('/profile', 'PATCH', { name, email });
                
                // Update UI elements showing name
                document.querySelectorAll('.font-medium.text-gray-800.dark\\:text-white').forEach(el => {
                    if (el.textContent === window.App.user.name) {
                        el.textContent = name;
                    }
                });
                
                // Update initials
                const initials = name.substring(0, 2).toUpperCase();
                document.getElementById('user-initials').textContent = initials;
                
                // Update App state
                window.App.user.name = name;
                window.App.user.email = email;
                
                showSuccessNotification(result.message);
            } catch (error) {}
        }

        async function handlePasswordUpdate(e) {
            e.preventDefault();
            const current_password = document.getElementById('current-password').value;
            const password = document.getElementById('new-password').value;
            const password_confirmation = document.getElementById('new-password-confirmation').value;

            try {
                const result = await apiCall('/password', 'PUT', { 
                    current_password, 
                    password, 
                    password_confirmation 
                });
                
                showSuccessNotification(result.message);
                passwordForm.reset();
            } catch (error) {}
        }
        
        async function deleteComment(commentId) {
            try {
                const result = await apiCall(`/dashboard/comments/${commentId}`, 'DELETE');
                const subtask = findSubtask(currentSubtaskId);
                subtask.comments = subtask.comments.filter(c => c.id != commentId);
                renderComments(subtask.comments);
                showSuccessNotification(result.message);
                closeConfirmationModal();
            } catch (error) {}
        }
        
        // Data helpers
        function findClient(id) { return window.App.clients.find(c => c.id == id); }
        function findMainTask(id) {
            for (let c of window.App.clients) {
                if (c.main_tasks) {
                    let t = c.main_tasks.find(mt => mt.id == id);
                    if (t) return t;
                }
            }
            return null;
        }
        function findSubtask(id) {
            for (let c of window.App.clients) {
                if (c.main_tasks) {
                    for (let t of c.main_tasks) {
                        if (t.subtasks) {
                            let s = t.subtasks.find(st => st.id == id);
                            if (s) return s;
                        }
                    }
                }
            }
            return null;
        }
        function findComment(id) {
            const s = findSubtask(currentSubtaskId);
            return s ? s.comments.find(c => c.id == id) : null;
        }

        // Confirmation modal
        function openConfirmationModal(type, name, callback) {
            confirmationTitle.textContent = `Delete ${type.charAt(0).toUpperCase() + type.slice(1)}`;
            confirmationMessage.textContent = `Are you sure you want to delete "${name}"? This action cannot be undone.`;
            deleteCallback = callback;
            currentDeleteType = type;
            confirmationModal.classList.remove('hidden');
        }
        
        function closeConfirmationModal() {
            confirmationModal.classList.add('hidden');
            deleteCallback = null;
            currentDeleteType = null;
        }
        
        // Notifications
        function showSuccessNotification(message) {
            successMessage.textContent = message;
            successNotification.classList.remove('invisible');
            successNotification.classList.remove('translate-x-[150%]');
            setTimeout(() => {
                successNotification.classList.add('translate-x-[150%]');
                setTimeout(() => successNotification.classList.add('invisible'), 300);
            }, 3000);
        }
        
        function showErrorNotification(message) {
            errorMessage.textContent = message;
            errorNotification.classList.remove('invisible');
            errorNotification.classList.remove('translate-x-[150%]');
            setTimeout(() => {
                errorNotification.classList.add('translate-x-[150%]');
                setTimeout(() => errorNotification.classList.add('invisible'), 300);
            }, 3000);
        }
        
        // Initialize the application
        init();
        
        confirmDeleteBtn.addEventListener('click', () => {
            if (deleteCallback) deleteCallback();
        });
    </script>
</body>
</html>