            <main class="flex-1 overflow-y-auto p-6 bg-gray-50 dark:bg-gray-900">
                <div id="client-selection-prompt" class="h-full flex flex-col items-center justify-center p-4 sm:p-8">
                    <div class="max-w-md text-center">
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 w-20 h-20 md:w-24 md:h-24 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-users text-3xl md:text-4xl text-white"></i>
                        </div>
                        <h2 class="text-xl md:text-2xl font-bold text-gray-800 dark:text-white mb-3">Select a Client</h2>
                        <p class="text-gray-600 dark:text-gray-400 mb-8 text-sm md:text-base">
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
                                        <span id="selected-client-status" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                                            <span class="w-2 h-2 bg-blue-500 rounded-full mr-2"></span>
                                            Active
                                        </span>
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
                                <button id="add-main-task-btn" class="flex items-center space-x-2 bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 md:px-4 md:py-2.5 rounded-lg transition-all shadow-md group" title="Add New Main Task">
                                    <i class="fas fa-plus text-sm"></i>
                                    <span class="font-medium text-xs md:text-sm">Add Task</span>
                                </button>
                            </div>
                            
                            <!-- Main Task Form -->
                            <div id="main-task-form" class="fade-in hidden">
                                <div class="mb-6">
                                    <label for="main-task-title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Task Title</label>
                                    <input type="text" id="main-task-title" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Enter main task title">
                                </div>
                                
                                <div class="mb-6">
                                    <label for="main-task-description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
                                    <textarea id="main-task-description" rows="4" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Describe the main task"></textarea>
                                </div>
                                
                                <div class="mb-6">
                                    <div class="flex items-center justify-between">
                                        <span id="main-task-id-display" class="text-xs text-gray-500 dark:text-gray-400">New Task</span>
                                    </div>
                                </div>
                                
                                <div class="flex space-x-3">
                                    <button id="save-main-task-btn" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-lg font-medium transition-colors">
                                        <i class="fas fa-save mr-2"></i>
                                        Save Task
                                    </button>
                                    <button id="update-main-task-btn" class="flex-1 bg-green-600 hover:bg-green-700 text-white px-4 py-3 rounded-lg font-medium transition-colors hidden">
                                        <i class="fas fa-sync-alt mr-2"></i>
                                        Update Task
                                    </button>
                                    <button id="cancel-main-task-btn" class="flex-1 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-300 px-4 py-3 rounded-lg transition-colors flex items-center justify-center">
                                        <i class="fas fa-times mr-2"></i>
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
                                <button id="add-subtask-btn" class="flex items-center space-x-2 bg-green-600 hover:bg-green-700 text-white px-3 py-2 md:px-4 md:py-2.5 rounded-lg transition-all shadow-md disabled:opacity-50 disabled:cursor-not-allowed group" disabled title="Add New Subtask">
                                    <i class="fas fa-plus text-sm"></i>
                                    <span class="font-medium text-xs md:text-sm">Add Subtask</span>
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
                                
                                <div class="flex space-x-3">
                                    <button id="save-subtask-btn" class="flex-1 bg-green-600 hover:bg-green-700 text-white px-4 py-3 rounded-lg font-medium transition-colors text-sm sm:text-base">
                                        <i class="fas fa-save mr-1 sm:mr-2"></i>
                                        Save
                                    </button>
                                    <button id="update-subtask-btn" class="flex-1 bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-3 rounded-lg font-medium transition-colors hidden text-sm sm:text-base">
                                        <i class="fas fa-sync-alt mr-1 sm:mr-2"></i>
                                        Update
                                    </button>
                                    <button id="cancel-subtask-btn" class="flex-1 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-300 px-4 py-3 rounded-lg transition-colors flex items-center justify-center text-sm sm:text-base">
                                        <i class="fas fa-times mr-1 sm:mr-2"></i>
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
