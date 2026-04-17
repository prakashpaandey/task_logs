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
                        <div class="flex items-center space-x-2 sidebar-hide-content">
                            <h2 class="text-xl font-bold text-gray-800 dark:text-white">Clients</h2>
                        </div>
                        <div class="flex items-center space-x-2">
                            @if(auth()->user()->isAdmin())
                            <button id="add-client-btn" class="group flex items-center bg-blue-600 hover:bg-blue-700 text-white w-10 h-10 hover:w-36 rounded-lg transition-all duration-300 overflow-hidden shadow-md" title="Add New Client">
                                <div class="flex items-center justify-center min-w-[2.5rem] h-10">
                                    <i class="fas fa-plus"></i>
                                </div>
                                <span class="whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-300 pr-3 font-medium text-sm sidebar-text">Add Client</span>
                            </button>
                            @endif
                            <button id="toggle-sidebar" class="hidden md:flex items-center justify-center w-8 h-8 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-400 dark:text-gray-500 rounded-lg transition-all duration-300" title="Collapse Sidebar">
                                <i class="fas fa-angles-left text-xs transition-colors duration-300" id="toggle-icon"></i>
                            </button>
                        </div>
                    </div>
                    
                    @if(auth()->user()->isAdmin())
                    <!-- Admin Panel (System) -->
                    <div class="mb-6 space-y-1">
                        <p class="px-4 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-4 sidebar-hide-content">Admin Panel</p>
                        <button id="sidebar-manage-users-btn" onclick="switchView('user-management')" class="sidebar-nav-item w-full flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group">
                            <div class="w-8 h-8 flex items-center justify-center rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-400 group-[.active]:bg-indigo-600 group-[.active]:text-white transition-colors">
                                <i class="fas fa-users-cog text-sm"></i>
                            </div>
                            <span class="sidebar-hide-content text-sm font-semibold text-gray-600 dark:text-gray-400 group-[.active]:text-gray-900 dark:group-[.active]:text-white transition-colors">Manage Users</span>
                        </button>
                    </div>
                    @endif

                    <!-- Reports (Shared) -->
                    <div class="mb-6 space-y-1">
                        <p class="px-4 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-4 sidebar-hide-content">Reports</p>
                        <button id="sidebar-activity-reports-btn" onclick="switchView('reports')" class="sidebar-nav-item w-full flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group">
                            <div class="w-8 h-8 flex items-center justify-center rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-400 group-[.active]:bg-blue-600 group-[.active]:text-white transition-colors">
                                <i class="fas fa-file-invoice text-sm"></i>
                            </div>
                            <span class="sidebar-hide-content text-sm font-semibold text-gray-600 dark:text-gray-400 group-[.active]:text-gray-900 dark:group-[.active]:text-white transition-colors">Activity Reports</span>
                        </button>
                    </div>



                    @if(!auth()->user()->isAdmin())
                    <!-- Developer Tasks (Private) -->
                    <div class="mb-6 space-y-1">
                        <p class="px-4 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-4 sidebar-hide-content">My Workspace</p>
                        <button id="sidebar-assigned-tasks-btn" onclick="switchView('developer-tasks')" class="sidebar-nav-item w-full flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group">
                            <div class="w-8 h-8 flex items-center justify-center rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-400 group-[.active]:bg-purple-600 group-[.active]:text-white transition-colors">
                                <i class="fas fa-tasks text-sm"></i>
                            </div>
                            <span class="sidebar-hide-content text-sm font-semibold text-gray-600 dark:text-gray-400 group-[.active]:text-gray-900 dark:group-[.active]:text-white transition-colors">Assigned Tasks</span>
                        </button>
                    </div>
                    @endif

                    <!-- Search clients -->
                    <div class="mb-6 sidebar-hide-content">
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-500 transition-colors">
                                <i class="fas fa-search text-xs"></i>
                            </div>
                            <input type="text" id="client-search" placeholder="Search clients..." class="w-full px-3 py-2.5 pl-10 bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 text-sm transition-all">
                        </div>
                    </div>
                    
                    <!-- Clients list -->
                    <div id="clients-list-container" class="space-y-1">
                        @foreach($clients as $client)
                        @php
                            $initials = collect(explode(' ', $client->name))->map(fn($word) => strtoupper(substr($word, 0, 1)))->take(2)->implode('');
                            $colors = ['from-indigo-500 to-indigo-600', 'from-emerald-500 to-emerald-600', 'from-amber-500 to-amber-600', 'from-rose-500 to-rose-600', 'from-blue-500 to-blue-600', 'from-purple-500 to-purple-600'];
                            $color = $colors[$client->id % count($colors)];
                        @endphp
                        <button class="client-item group relative w-full flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 hover:bg-gray-50 dark:hover:bg-gray-900/50" data-client-id="{{ $client->id }}" title="{{ $client->name }}">
                            <div class="w-8 h-8 bg-gradient-to-br {{ $color }} rounded-lg flex items-center justify-center text-white text-[10px] font-bold shadow-sm shadow-indigo-500/20">
                                {{ $initials }}
                            </div>
                            <div class="sidebar-hide-content flex-1 min-w-0 text-left">
                                <p class="text-sm font-semibold text-gray-700 dark:text-gray-200 truncate group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">{{ $client->name }}</p>
                            </div>
                        </button>
                        @endforeach
                    </div>
                    
                    <!-- No clients message (hidden by default) -->
                    <div id="no-clients-message" class="hidden mt-8 text-center p-8 border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-lg">
                        <div class="mx-auto w-16 h-16 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-users text-3xl text-gray-400"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-2">No clients found</h3>
                        @if(auth()->user()->isAdmin())
                        <p class="text-gray-500 dark:text-gray-400 mb-4 text-sm">Add your first client to get started</p>
                        <button id="add-client-btn-empty" class="group flex items-center justify-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-all shadow-md hover:shadow-lg" title="Add New Client">
                            <i class="fas fa-plus text-sm"></i>
                            <span class="sidebar-text font-medium text-sm">New Client</span>
                        </button>
                        @else
                        <p class="text-gray-500 dark:text-gray-400 mb-4 text-sm italic">You don't have any clients assigned to you yet. Please contact your admin for access.</p>
                        @endif
                    </div>
                </div>
            </aside>
