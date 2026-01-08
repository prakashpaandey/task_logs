            <main id="main-content" class="flex-1 overflow-y-auto p-6 bg-gray-50 dark:bg-gray-900 transition-all duration-300">
                <!-- Statistics Dashboard -->
                <div id="statistics-dashboard" class="h-full flex flex-col p-4 md:p-8 animate-fadeIn">
                    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 md:mb-8 gap-4">
                        <div>
                            <h2 class="text-xl md:text-2xl font-bold text-gray-800 dark:text-white flex items-center">
                                <i class="fas fa-chart-line mr-3 text-blue-600"></i>
                                Personal Productivity
                            </h2>
                            <p class="text-xs md:text-base text-gray-500 dark:text-gray-400 mt-1">Activity summary for {{ auth()->user()->name }}</p>
                        </div>
                        <button onclick="document.getElementById('add-client-btn').click()" class="self-start md:self-auto bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 md:px-5 md:py-2.5 rounded-lg md:rounded-xl font-bold transition-all shadow-lg hover:shadow-blue-500/20 flex items-center whitespace-nowrap text-sm md:text-base">
                            <i class="fas fa-user-plus mr-2"></i> New Client
                        </button>
                    </div>
                    
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3 md:gap-6 mb-6 md:mb-8">
                        <!-- Time Logs Section -->
                        <div class="bg-gradient-to-br from-blue-50 to-white dark:from-blue-900/10 dark:to-gray-800 p-3 md:p-6 rounded-xl md:rounded-2xl border border-blue-100 dark:border-blue-800/50 shadow-sm">
                            <div class="flex items-center justify-between mb-2 md:mb-4">
                                <span class="bg-blue-100 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400 text-[10px] md:text-xs font-bold px-2 py-0.5 md:px-3 md:py-1 rounded-full uppercase tracking-wider">Today</span>
                                <i class="fas fa-clock text-blue-500 text-sm md:text-base"></i>
                            </div>
                            <h3 id="stat-time-today" class="text-xl md:text-3xl font-bold text-gray-800 dark:text-white">0.0h</h3>
                            <p class="text-gray-500 dark:text-gray-400 text-[10px] md:text-sm mt-1">Logged today</p>
                        </div>

                        <div class="bg-gradient-to-br from-indigo-50 to-white dark:from-indigo-900/10 dark:to-gray-800 p-3 md:p-6 rounded-xl md:rounded-2xl border border-indigo-100 dark:border-indigo-800/50 shadow-sm">
                            <div class="flex items-center justify-between mb-2 md:mb-4">
                                <span class="bg-indigo-100 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-400 text-[10px] md:text-xs font-bold px-2 py-0.5 md:px-3 md:py-1 rounded-full uppercase tracking-wider">This Week</span>
                                <i class="fas fa-calendar-week text-indigo-500 text-sm md:text-base"></i>
                            </div>
                            <h3 id="stat-time-week" class="text-xl md:text-3xl font-bold text-gray-800 dark:text-white">0.0h</h3>
                            <p class="text-gray-500 dark:text-gray-400 text-[10px] md:text-sm mt-1">Weekly total</p>
                        </div>

                        <div class="bg-gradient-to-br from-purple-50 to-white dark:from-purple-900/10 dark:to-gray-800 p-3 md:p-6 rounded-xl md:rounded-2xl border border-purple-100 dark:border-purple-800/50 shadow-sm col-span-2 md:col-span-1">
                            <div class="flex items-center justify-between mb-2 md:mb-4">
                                <span class="bg-purple-100 dark:bg-purple-900/40 text-purple-600 dark:text-purple-400 text-[10px] md:text-xs font-bold px-2 py-0.5 md:px-3 md:py-1 rounded-full uppercase tracking-wider">This Month</span>
                                <i class="fas fa-calendar-alt text-purple-500 text-sm md:text-base"></i>
                            </div>
                            <h3 id="stat-time-month" class="text-xl md:text-3xl font-bold text-gray-800 dark:text-white">0.0h</h3>
                            <p class="text-gray-500 dark:text-gray-400 text-[10px] md:text-sm mt-1">Monthly total</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3 md:gap-6">
                        <!-- Comments Section -->
                        <div class="bg-gradient-to-br from-green-50 to-white dark:from-green-900/10 dark:to-gray-800 p-3 md:p-6 rounded-xl md:rounded-2xl border border-green-100 dark:border-green-800/50 shadow-sm">
                            <div class="flex items-center justify-between mb-2 md:mb-4">
                                <span class="bg-green-100 dark:bg-green-900/40 text-green-600 dark:text-green-400 text-[10px] md:text-xs font-bold px-2 py-0.5 md:px-3 md:py-1 rounded-full uppercase tracking-wider">Today</span>
                                <i class="fas fa-comment-dots text-green-500 text-sm md:text-base"></i>
                            </div>
                            <h3 id="stat-comments-today" class="text-xl md:text-3xl font-bold text-gray-800 dark:text-white">0</h3>
                            <p class="text-gray-500 dark:text-gray-400 text-[10px] md:text-sm mt-1">Comments posted</p>
                        </div>

                        <div class="bg-gradient-to-br from-teal-50 to-white dark:from-teal-900/10 dark:to-gray-800 p-3 md:p-6 rounded-xl md:rounded-2xl border border-teal-100 dark:border-teal-800/50 shadow-sm">
                            <div class="flex items-center justify-between mb-2 md:mb-4">
                                <span class="bg-teal-100 dark:bg-teal-900/40 text-teal-600 dark:text-teal-400 text-[10px] md:text-xs font-bold px-2 py-0.5 md:px-3 md:py-1 rounded-full uppercase tracking-wider">This Week</span>
                                <i class="fas fa-comments text-teal-500 text-sm md:text-base"></i>
                            </div>
                            <h3 id="stat-comments-week" class="text-xl md:text-3xl font-bold text-gray-800 dark:text-white">0</h3>
                            <p class="text-gray-500 dark:text-gray-400 text-[10px] md:text-sm mt-1">Weekly discussion</p>
                        </div>

                        <div class="bg-gradient-to-br from-cyan-50 to-white dark:from-cyan-900/10 dark:to-gray-800 p-3 md:p-6 rounded-xl md:rounded-2xl border border-cyan-100 dark:border-cyan-800/50 shadow-sm col-span-2 md:col-span-1">
                            <div class="flex items-center justify-between mb-2 md:mb-4">
                                <span class="bg-cyan-100 dark:bg-cyan-900/40 text-cyan-600 dark:text-cyan-400 text-[10px] md:text-xs font-bold px-2 py-0.5 md:px-3 md:py-1 rounded-full uppercase tracking-wider">This Month</span>
                                <i class="fas fa-comment-medical text-cyan-500 text-sm md:text-base"></i>
                            </div>
                            <h3 id="stat-comments-month" class="text-xl md:text-3xl font-bold text-gray-800 dark:text-white">0</h3>
                            <p class="text-gray-500 dark:text-gray-400 text-[10px] md:text-sm mt-1">Monthly total</p>
                        </div>
                    </div>
                    
                </div>

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

                <div id="client-content" class="hidden">
                    <!-- Client header -->
                    <div class="mb-6">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                            <div class="flex items-center space-x-4">
                                <div>
                                    <h2 id="selected-client-name" class="text-xl md:text-2xl font-bold text-gray-800 dark:text-white">Acme Corporation</h2>
                                    <div class="flex flex-wrap items-center mt-1 gap-3">
                                        <span class="text-gray-600 dark:text-gray-400 text-xs md:text-sm">
                                            <i class="fas fa-calendar-alt mr-1"></i>
                                            Joined: <span id="client-join-date">Jan 15, 2023</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex space-x-2 sm:space-x-3">
                                <button id="edit-client-btn" class="flex-1 md:flex-none justify-center bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-300 px-3 md:px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors text-sm">
                                    <i class="fas fa-edit"></i>
                                    <span class="hidden sm:inline">Edit Client</span>
                                    <span class="inline sm:hidden">Edit</span>
                                </button>
                                <button id="delete-client-btn" class="flex-1 md:flex-none justify-center bg-red-100 dark:bg-red-900/30 hover:bg-red-200 dark:hover:bg-red-900/50 text-red-700 dark:text-red-400 px-3 md:px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors text-sm">
                                    <i class="fas fa-trash-alt"></i>
                                    <span>Delete</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Two-panel layout for tasks -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-8">
                        <!-- Left Panel: Main Task Management -->
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-4 sm:p-6 border border-gray-200 dark:border-gray-700">
                            <div class="flex items-center justify-between mb-6">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800 dark:text-white">Main Tasks</h3>
                                    <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">Create and manage main tasks for this client</p>
                                </div>
                                <button id="add-main-task-btn" class="flex items-center bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg transition-all shadow-md group">
                                    <i class="fas fa-plus text-sm"></i>
                                    <span class="max-w-0 overflow-hidden group-hover:max-w-xs transition-all duration-300 ease-in-out opacity-0 group-hover:opacity-100 whitespace-nowrap text-xs md:text-sm font-medium pl-0 group-hover:pl-2">Add Task</span>
                                </button>
                            </div>
                            
                            <!-- Main Task Form -->
                            <div id="main-task-form" class="fade-in hidden">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label for="main-task-title" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Task Title</label>
                                        <input type="text" id="main-task-title" class="w-full px-3 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm" placeholder="Enter title">
                                    </div>
                                    
                                    <div>
                                        <label for="main-task-category" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Category</label>
                                        <div class="relative">
                                            <input type="hidden" id="main-task-category" name="category_id">
                                            <button type="button" id="category-dropdown-btn" class="w-full px-3 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-left flex items-center justify-between group h-[42px]">
                                                <span id="category-dropdown-text" class="text-sm text-gray-500 dark:text-gray-400">Select Category</span>
                                                <i class="fas fa-chevron-down text-gray-400 group-hover:text-blue-500 transition-colors text-xs"></i>
                                            </button>
                                            
                                            <!-- Dropdown Menu -->
                                            <div id="category-dropdown-menu" class="absolute z-50 w-full mt-1 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-xl hidden">
                                                <div class="p-2 border-b border-gray-100 dark:border-gray-700">
                                                    <input type="text" id="category-search" class="w-full px-3 py-1.5 text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="Search categories...">
                                                </div>
                                                <div id="category-options-list" class="max-h-56 overflow-y-auto py-1 custom-scrollbar">
                                                    <!-- Options will be populated here -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="main-task-description" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Description</label>
                                    <textarea id="main-task-description" rows="3" class="w-full px-3 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm" placeholder="Describe the main task"></textarea>
                                </div>
                                
                                <div class="mb-6">
                                    <div class="flex items-center justify-between">
                                        <span id="main-task-id-display" class="text-xs text-gray-500 dark:text-gray-400">New Task</span>
                                    </div>
                                </div>
                                
                                <div class="flex gap-3">
                                    <button id="save-main-task-btn" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-3 py-2.5 md:px-4 md:py-3 rounded-lg font-medium transition-colors text-sm md:text-base">
                                        <i class="fas fa-save mr-1.5 md:mr-2"></i>
                                        Save Task
                                    </button>
                                    <button id="update-main-task-btn" class="flex-1 bg-green-600 hover:bg-green-700 text-white px-3 py-2.5 md:px-4 md:py-3 rounded-lg font-medium transition-colors hidden text-sm md:text-base">
                                        <i class="fas fa-sync-alt mr-1.5 md:mr-2"></i>
                                        Update Task
                                    </button>
                                    <button id="cancel-main-task-btn" class="flex-1 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-300 px-3 py-2.5 md:px-4 md:py-3 rounded-lg transition-colors flex items-center justify-center text-sm md:text-base">
                                        <i class="fas fa-times mr-1.5 md:mr-2"></i>
                                        Cancel
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Main Tasks List -->
                            <div class="mt-8">
                                <h4 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-4">Select a Main Task to Manage</h4>
                                <div id="main-tasks-list" class="space-y-3 max-h-80 overflow-y-auto pr-2">
                                    <!-- Main tasks loaded dynamically -->
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
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-4 sm:p-6 border border-gray-200 dark:border-gray-700">
                            <div class="flex items-center justify-between mb-6">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800 dark:text-white">Subtasks</h3>
                                    <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">Manage subtasks for the selected main task</p>
                                </div>
                                <button id="add-subtask-btn" class="flex items-center bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-lg transition-all shadow-md disabled:opacity-50 disabled:cursor-not-allowed group" disabled title="Add New Subtask">
                                    <i class="fas fa-plus text-sm"></i>
                                    <span class="max-w-0 overflow-hidden group-hover:max-w-xs transition-all duration-300 ease-in-out opacity-0 group-hover:opacity-100 whitespace-nowrap text-xs md:text-sm font-medium pl-0 group-hover:pl-2">Add Subtask</span>
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
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label for="subtask-title" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Subtask Title</label>
                                        <input type="text" id="subtask-title" class="w-full px-3 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm" placeholder="Enter title">
                                    </div>
                                    
                                    <div>
                                        <label for="subtask-work-date" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Work Date</label>
                                        <input type="date" id="subtask-work-date" class="w-full px-3 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="subtask-description" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Description</label>
                                    <textarea id="subtask-description" rows="3" class="w-full px-3 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm" placeholder="Describe the subtask"></textarea>
                                </div>
                                
                                <div class="flex gap-3">
                                    <button id="save-subtask-btn" class="flex-1 bg-green-600 hover:bg-green-700 text-white px-3 py-2.5 md:px-4 md:py-3 rounded-lg font-medium transition-colors text-sm md:text-base">
                                        <i class="fas fa-save mr-1.5 md:mr-2"></i>
                                        Save
                                    </button>
                                    <button id="update-subtask-btn" class="flex-1 bg-yellow-600 hover:bg-yellow-700 text-white px-3 py-2.5 md:px-4 md:py-3 rounded-lg font-medium transition-colors hidden text-sm md:text-base">
                                        <i class="fas fa-sync-alt mr-1.5 md:mr-2"></i>
                                        Update
                                    </button>
                                    <button id="cancel-subtask-btn" class="flex-1 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-300 px-3 py-2.5 md:px-4 md:py-3 rounded-lg transition-colors flex items-center justify-center text-sm md:text-base">
                                        <i class="fas fa-times mr-1.5 md:mr-2"></i>
                                        Cancel
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Subtask Detail View (Tabs) -->
                            <div id="subtask-detail-view" class="mt-8 hidden">
                                <div class="flex items-center mb-6">
                                    <button id="back-to-subtasks-btn" class="mr-3 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition-colors" title="Back to Subtasks">
                                        <i class="fas fa-arrow-left text-lg"></i>
                                    </button>
                                    <h4 id="detail-subtask-title" class="text-xl font-bold text-gray-800 dark:text-white truncate">Subtask Detail</h4>
                                </div>
                                <div id="detail-subtask-description-container" class="mb-6 p-4 bg-gray-50 dark:bg-gray-700/30 rounded-2xl border border-gray-100 dark:border-gray-600 transition-all hidden">
                                    <div class="flex items-center space-x-2 mb-2 text-gray-500 dark:text-gray-400">
                                        <i class="fas fa-align-left text-[10px]"></i>
                                        <span class="text-[9px] font-bold uppercase tracking-widest">Description</span>
                                    </div>
                                    <p id="detail-subtask-description" class="text-gray-700 dark:text-gray-300 text-sm leading-relaxed whitespace-pre-line break-words max-h-32 overflow-y-auto custom-scrollbar pr-1"></p>
                                </div>

                                <!-- Tab Navigation -->
                                <div class="flex border-b border-gray-200 dark:border-gray-700 mb-6">
                                    <button id="tab-comments" onclick="switchSubtaskTab('comments')" class="subtask-tab px-6 py-3 border-b-2 font-medium text-sm transition-colors border-blue-600 text-blue-600 dark:text-blue-400">
                                        <i class="fas fa-comments mr-2"></i>Comments
                                    </button>
                                    <button id="tab-time-logs" onclick="switchSubtaskTab('time-logs')" class="subtask-tab px-6 py-3 border-b-2 font-medium text-sm transition-colors border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                                        <i class="fas fa-clock mr-2"></i>Time Logs
                                    </button>
                                </div>

                                <!-- Tab Content -->
                                <div id="subtask-detail-content">
                                    <!-- Comments Section -->
                                    <div id="subtask-comments-section" class="">
                                        <div class="flex items-center justify-between mb-4">
                                            <h5 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Conversation</h5>
                                            <button id="add-comment-btn" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 text-sm font-medium">
                                                <i class="fas fa-plus mr-1"></i> Add Comment
                                            </button>
                                        </div>
                                        
                                        <!-- Comment Form -->
                                        <div id="comment-form" class="mb-6 hidden bg-gray-50 dark:bg-gray-700/30 p-4 rounded-xl border border-gray-100 dark:border-gray-600">
                                            <div class="mb-4">
                                                <textarea id="comment-text" rows="3" class="w-full px-4 py-3 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm" placeholder="Enter your comment"></textarea>
                                            </div>
                                            <div class="flex justify-end space-x-3">
                                                <button id="save-comment-btn" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors text-sm font-medium">
                                                    Post Comment
                                                </button>
                                                <button id="cancel-comment-btn" class="bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors text-sm font-medium">
                                                    Cancel
                                                </button>
                                            </div>
                                        </div>
                                        
                                        <!-- Comments List -->
                                        <div id="comments-list" class="space-y-4 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar">
                                            <!-- Comments dynamically loaded -->
                                        </div>
                                    </div>

                                    <!-- Time Logs Section -->
                                    <div id="subtask-time-logs-section" class="hidden">
                                        <div class="flex items-center justify-between mb-4">
                                            <h5 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Time History</h5>
                                            <button id="add-time-log-btn" class="text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300 text-sm font-medium">
                                                <i class="fas fa-plus mr-1"></i> Add Time
                                            </button>
                                        </div>
                                        
                                        <!-- Time Log Form -->
                                        <div id="time-log-form" class="mb-6 hidden bg-gray-50 dark:bg-gray-700/30 p-4 rounded-xl border border-gray-100 dark:border-gray-600">
                                            <div class="flex items-end space-x-3">
                                                <div class="flex-1">
                                                    <label for="time-log-value" class="block text-xs font-medium text-gray-500 mb-1">Hours Spent</label>
                                                    <div class="relative">
                                                        <input type="number" id="time-log-value" step="0.5" min="0" class="w-full pl-4 pr-10 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm" placeholder="e.g. 1.5">
                                                        <span class="absolute right-3 top-2 text-gray-400 text-sm">hrs</span>
                                                    </div>
                                                </div>
                                                <div class="flex space-x-2">
                                                    <button id="save-time-log-btn" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">Log</button>
                                                    <button id="update-time-log-btn" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors hidden">Update</button>
                                                    <button id="cancel-time-log-btn" class="bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-lg text-sm font-medium transition-colors">Cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Time Logs List -->
                                        <div id="time-logs-list" class="space-y-3 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar">
                                            <!-- Time logs dynamically loaded -->
                                        </div>
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
