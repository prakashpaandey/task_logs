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
                            <button id="add-client-btn" class="group flex items-center bg-blue-600 hover:bg-blue-700 text-white w-10 h-10 hover:w-36 rounded-lg transition-all duration-300 overflow-hidden shadow-md" title="Add New Client">
                                <div class="flex items-center justify-center min-w-[2.5rem] h-10">
                                    <i class="fas fa-plus"></i>
                                </div>
                                <span class="whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-300 pr-3 font-medium text-sm sidebar-text">Add Client</span>
                            </button>
                            <button id="toggle-sidebar" class="hidden md:flex items-center justify-center w-8 h-8 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-400 dark:text-gray-500 rounded-lg transition-all duration-300" title="Collapse Sidebar">
                                <i class="fas fa-angles-left text-xs transition-colors duration-300" id="toggle-icon"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Search clients -->
                    <div class="mb-6 sidebar-hide-content">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" id="client-search" placeholder="Search clients... (/)" class="w-full px-3 py-2 pl-10 bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm focus:border-transparent">
                        </div>
                    </div>
                    
                    <!-- Clients list -->
                    <div id="clients-list-container" class="space-y-2">
                        @foreach($clients as $client)
                        @php
                            $initials = collect(explode(' ', $client->name))->map(fn($word) => strtoupper(substr($word, 0, 1)))->take(2)->implode('');
                            $colors = [
                                'from-emerald-400 to-teal-500',
                                'from-violet-400 to-purple-600',
                                'from-blue-400 to-indigo-600',
                                'from-rose-400 to-pink-600',
                                'from-amber-400 to-orange-500',
                                'from-cyan-400 to-sky-600',
                            ];
                            $color = $colors[$client->id % count($colors)];
                        @endphp
                        <div class="client-item group relative flex items-center gap-3 px-3 py-3 rounded-xl border cursor-pointer transition-all duration-200 overflow-hidden
                            {{ (isset($selectedClient) && $selectedClient->id == $client->id)
                                ? 'bg-blue-50 dark:bg-blue-900/25 border-blue-300 dark:border-blue-700 shadow-sm shadow-blue-100 dark:shadow-blue-900/20'
                                : 'bg-white dark:bg-gray-800/60 border-gray-200 dark:border-gray-700/60 hover:bg-gray-50 dark:hover:bg-gray-700/60 hover:border-gray-300 dark:hover:border-gray-600 hover:shadow-sm' }}"
                            data-client-id="{{ $client->id }}" title="{{ $client->name }}">

                            {{-- Active indicator bar --}}
                            @if(isset($selectedClient) && $selectedClient->id == $client->id)
                            <div class="absolute left-0 top-2 bottom-2 w-1 bg-blue-500 dark:bg-blue-400 rounded-r-full"></div>
                            @endif

                            {{-- Avatar --}}
                            <div class="relative shrink-0">
                                <div class="w-9 h-9 rounded-xl bg-gradient-to-br {{ $color }} flex items-center justify-center text-white text-xs font-bold shadow-md">
                                    {{ $initials }}
                                </div>
                                @if(isset($selectedClient) && $selectedClient->id == $client->id)
                                <span class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 bg-emerald-400 border-2 border-white dark:border-gray-800 rounded-full"></span>
                                @endif
                            </div>

                            {{-- Name --}}
                            <div class="sidebar-hide-content min-w-0 flex-1">
                                <p class="text-sm font-semibold truncate
                                    {{ (isset($selectedClient) && $selectedClient->id == $client->id)
                                        ? 'text-blue-700 dark:text-blue-300'
                                        : 'text-gray-800 dark:text-gray-100 group-hover:text-gray-900 dark:group-hover:text-white' }}">
                                    {{ $client->name }}
                                </p>
                                <p class="text-xs text-gray-400 dark:text-gray-500 truncate">Client</p>
                            </div>

                            {{-- Arrow hint on hover --}}
                            <div class="sidebar-hide-content shrink-0 opacity-0 group-hover:opacity-100 transition-opacity duration-150">
                                <i class="fas fa-chevron-right text-[10px] text-gray-400 dark:text-gray-500"></i>
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
                        <button id="add-client-btn" class="group flex items-center justify-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-all shadow-md hover:shadow-lg" title="Add New Client (N)">
                            <i class="fas fa-plus text-sm"></i>
                            <span class="sidebar-text font-medium text-sm">New Client</span>
                        </button>
                    </div>
                </div>
            </aside>
