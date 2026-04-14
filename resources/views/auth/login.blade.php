<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Task Manager</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('favicon.png') }}">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        primary: { 50: '#eff6ff', 100: '#dbeafe', 200: '#bfdbfe', 300: '#93c5fd', 400: '#60a5fa', 500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8', 800: '#1e40af', 900: '#1e3a8a' }
                    }
                }
            }
        }
    </script>
    <script>
        // Apply dark mode immediately to prevent flash
        (function() {
            const theme = localStorage.getItem('theme');
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>
</head>
<body class="h-full bg-slate-50 dark:bg-slate-900 font-sans text-slate-900 dark:text-slate-100 antialiased flex items-center justify-center p-4 transition-colors duration-300">
    <!-- Theme Toggle Button -->
    <button id="theme-toggle" class="fixed top-4 right-4 sm:top-6 sm:right-6 z-50 p-3 rounded-xl bg-white dark:bg-slate-800 shadow-lg border border-slate-200 dark:border-slate-700 hover:shadow-xl transition-all">
        <i class="fas fa-moon text-slate-700 dark:text-slate-300 text-lg"></i>
    </button>
    
    <div class="w-full max-w-md mt-12 sm:mt-0">
        <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-xl shadow-slate-200/50 dark:shadow-slate-950/50 p-6 sm:p-8 md:p-10 border border-slate-100 dark:border-slate-700 transition-colors duration-300">
            <div class="text-center mb-6 sm:mb-8">
                <div class="inline-flex items-center justify-center w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-primary-600 dark:bg-primary-500 mb-4 sm:mb-6 shadow-lg shadow-primary-200 dark:shadow-primary-900/30">
                    <i class="fas fa-tasks text-white text-xl sm:text-2xl"></i>
                </div>
                <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white">Welcome back</h2>
                <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
                    Sign in to manage your professional tasks securely
                </p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Email Address</label>
                    <div class="mt-1 relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <i class="fas fa-envelope text-sm"></i>
                        </div>
                        <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}"
                            class="block w-full pl-10 pr-3 py-3 border border-slate-200 dark:border-slate-600 rounded-xl leading-5 bg-slate-50 dark:bg-slate-700 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all sm:text-sm"
                            placeholder="Enter your email">
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Password</label>
                        @if (Route::has('password.request'))
                            <div class="text-sm">
                                <a href="{{ route('password.request') }}" class="font-medium text-primary-600 hover:text-primary-500 transition-colors text-xs">
                                    Forgot password?
                                </a>
                            </div>
                        @endif
                    </div>
                    <div class="mt-1 relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <i class="fas fa-lock text-sm"></i>
                        </div>
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                            class="block w-full pl-10 pr-12 py-3 border border-slate-200 dark:border-slate-600 rounded-xl leading-5 bg-slate-50 dark:bg-slate-700 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all sm:text-sm"
                            placeholder="••••••••">
                        <button type="button" onclick="togglePassword('password', 'toggle-password-icon')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 transition-colors">
                            <i id="toggle-password-icon" class="fas fa-eye text-sm"></i>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="flex items-center">
                    <input id="remember_me" name="remember" type="checkbox"
                        class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-slate-300 rounded transition-colors">
                    <label for="remember_me" class="ml-2 block text-sm text-slate-600 dark:text-slate-400">
                        Remember me
                    </label>
                </div>

                <div>
                    <button type="submit"
                        class="w-full flex justify-center py-3 sm:py-3.5 px-4 border border-transparent rounded-xl shadow-lg text-sm font-semibold text-white bg-primary-600 hover:bg-primary-700 dark:bg-primary-500 dark:hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all transform active:scale-[0.98]">
                        Sign in
                    </button>
                </div>
            </form>
            
           
        </div>
    </div>
    
    <script>
        // Theme toggle functionality
        const themeToggle = document.getElementById('theme-toggle');
        const html = document.documentElement;
        const themeIcon = themeToggle.querySelector('i');
        
        // Check for saved theme preference or default to light mode
        const currentTheme = localStorage.getItem('theme') || 'light';
        if (currentTheme === 'dark') {
            html.classList.add('dark');
            themeIcon.classList.remove('fa-moon');
            themeIcon.classList.add('fa-sun');
        }
        
        themeToggle.addEventListener('click', () => {
            html.classList.toggle('dark');
            
            if (html.classList.contains('dark')) {
                themeIcon.classList.remove('fa-moon');
                themeIcon.classList.add('fa-sun');
                localStorage.setItem('theme', 'dark');
            } else {
                themeIcon.classList.remove('fa-sun');
                themeIcon.classList.add('fa-moon');
                localStorage.setItem('theme', 'light');
            }
        });
        
        // Password visibility toggle
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
