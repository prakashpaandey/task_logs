        <header class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 shadow-sm z-30">
            <div class="flex items-center justify-between px-6 py-4">
                <div class="flex items-center space-x-4">
                    <button id="mobile-menu-toggle" class="p-2 -ml-2 rounded-lg md:hidden text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <div class="flex items-center space-x-3">
                        <h1 class="text-xl md:text-2xl font-bold text-gray-800 dark:text-white">Task Manager</h1>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
                    <button id="theme-toggle" class="p-2 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                        <i id="theme-icon" class="fas fa-moon"></i>
                    </button>
                    
                    <div class="relative">
                        <button id="user-menu-button" class="flex items-center space-x-2 md:space-x-3 p-1 md:p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <div id="user-initials" class="w-8 h-8 md:w-10 md:h-10 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white font-semibold text-xs md:text-base">
                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                            </div>
                            <div class="text-left hidden lg:block">
                                <p id="user-display-name" class="font-medium text-gray-800 dark:text-white text-sm">{{ auth()->user()->name }}</p>
                                <p id="user-email-display" class="text-xs text-gray-500 dark:text-gray-400">{{ auth()->user()->email }}</p>
                            </div>
                            <i class="fas fa-chevron-down text-xs text-gray-500 dark:text-gray-400"></i>
                        </button>
                        
                        <div id="user-dropdown" class="absolute right-0 mt-2 w-56 sm:w-56 lg:w-64 bg-white dark:bg-gray-800 rounded-lg shadow-xl border border-gray-200 dark:border-gray-700 py-2 hidden z-50">
                            <button id="profile-btn" class="w-full flex items-center px-4 py-3 lg:px-5 lg:py-3.5 text-sm lg:text-base text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                <i class="fas fa-user-circle mr-3 text-base lg:text-lg"></i>
                                <span>Profile & Security</span>
                            </button>
                            <div class="border-t border-gray-200 dark:border-gray-700 my-2"></div>
                            <form method="POST" action="{{ route('logout') }}" id="logout-form" class="hidden">
                                @csrf
                            </form>
                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="flex items-center px-4 py-3 lg:px-5 lg:py-3.5 text-sm lg:text-base text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                <i class="fas fa-sign-out-alt mr-3 text-base lg:text-lg"></i>
                                <span>Logout</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
