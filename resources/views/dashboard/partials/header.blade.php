        <header class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 shadow-sm z-30">
            <div class="flex items-center justify-between px-6 py-4">
                <div class="flex items-center space-x-4">
                    <button id="mobile-menu-toggle" class="p-2 -ml-2 rounded-lg md:hidden text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <div class="flex items-center space-x-3 cursor-pointer group" onclick="switchView('statistics')">
                        <img src="{{ asset('favicon.png') }}" alt="Task Manager Logo" class="w-8 h-8 rounded-lg shadow-sm group-hover:scale-110 transition-transform">
                        <h1 class="text-xl md:text-2xl font-bold text-gray-800 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">Task Manager</h1>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
                    <div class="hidden sm:flex items-center px-4 py-1.5 bg-gray-100/50 dark:bg-gray-700/50 rounded-2xl border border-gray-200 dark:border-gray-600 shadow-inner group transition-all hover:bg-white dark:hover:bg-gray-800">
                        <div class="flex items-center space-x-3">
                            <div class="relative">
                                <i class="fas fa-clock text-blue-500 dark:text-blue-400 text-xs animate-pulse"></i>
                                <span class="absolute -top-1 -right-1 flex h-2 w-2">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                                </span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-tighter leading-none mb-0.5">Kathmandu, NP</span>
                                <span id="nepali-clock" class="text-sm font-black text-gray-800 dark:text-white tabular-nums leading-none">00:00:00</span>
                            </div>
                        </div>
                    </div>

                    <button id="theme-toggle" class="relative p-2.5 rounded-xl bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 border border-gray-200 dark:border-gray-700 shadow-sm group transition-all duration-300 overflow-hidden" title="Toggle Theme (Ctrl+D)">
                        <div class="relative w-5 h-5">
                            <!-- Sun Icon (Visible in Dark Mode) -->
                            <i class="fas fa-sun absolute inset-0 flex items-center justify-center text-amber-400 transition-all duration-500 transform translate-y-10 opacity-0 dark:translate-y-0 dark:opacity-100"></i>
                            <!-- Moon Icon (Visible in Light Mode) -->
                            <i class="fas fa-moon absolute inset-0 flex items-center justify-center text-gray-600 transition-all duration-500 transform dark:-translate-y-10 dark:opacity-0"></i>
                        </div>
                    </button>
                    
                    <div class="relative" id="notifications-wrapper">
                        <button id="notifications-button" class="p-2.5 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors relative" title="Notifications">
                            <i class="fas fa-bell text-gray-600 dark:text-gray-300"></i>
                            <span id="notifications-badge" class="absolute top-1 right-1 w-4 h-4 bg-red-500 text-white text-[10px] flex items-center justify-center rounded-full hidden">0</span>
                        </button>
                        
                        <div id="notifications-dropdown" class="absolute right-0 mt-2 w-80 sm:w-96 bg-white dark:bg-gray-800 rounded-xl shadow-2xl border border-gray-200 dark:border-gray-700 hidden z-50 overflow-hidden">
                            <div class="p-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-gray-800/50">
                                <h3 class="font-bold text-gray-800 dark:text-white">Notifications</h3>
                                <button onclick="markNotificationsAsRead()" class="text-xs text-blue-600 dark:text-blue-400 hover:underline">Mark all as read</button>
                            </div>
                            <div id="notifications-list" class="max-h-[400px] overflow-y-auto">
                                <!-- Notifications will be rendered here -->
                                <div class="p-8 text-center text-gray-500 dark:text-gray-400">
                                    <i class="fas fa-bell-slash mb-2 text-2xl opacity-20"></i>
                                    <p class="text-sm font-medium">No new notifications</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
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
                        
                        <div id="user-dropdown" class="absolute right-0 mt-2 w-56 bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-200 dark:border-gray-700 py-1.5 hidden z-50">
                            <button id="profile-btn" class="w-full flex items-center px-4 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all">
                                <i class="fas fa-user-circle mr-3 text-base opacity-70"></i>
                                <span>Profile & Security</span>
                            </button>
                            <div class="border-t border-gray-100 dark:border-gray-700 my-1.5"></div>
                            <form method="POST" action="{{ route('logout') }}" id="logout-form" class="hidden">
                                @csrf
                            </form>
                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="flex items-center px-4 py-2.5 text-sm font-medium text-red-600 dark:text-red-400 hover:bg-rose-50 dark:hover:bg-rose-900/10 transition-all">
                                <i class="fas fa-sign-out-alt mr-3 text-base opacity-70"></i>
                                <span>Logout</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
