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
