    <!-- Modal for Add/Edit Client -->
    <div id="client-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl w-full max-w-md mx-4">
            <div class="p-4 md:p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 id="client-modal-title" class="text-xl font-bold text-gray-800 dark:text-white">Add New Client</h3>
                    <button id="close-client-modal" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <form id="client-form">
                    <div class="mb-4">
                        <label for="client-name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Client Name</label>
                        <input type="text" id="client-name" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Enter client name" required>
                    </div>

                    @if(auth()->user()->isAdmin())
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Assign Users (Developers)</label>
                        <div id="assign-users-container" class="max-h-40 overflow-y-auto p-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg space-y-2">
                            <!-- Populated dynamically via JS -->
                        </div>
                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Selected users will be able to view and manage tasks for this client.</p>
                    </div>
                    @endif
                    
                    
                    <div class="flex flex-row gap-3 w-full">
                        <button type="button" id="cancel-client-btn" class="flex-1 px-3 py-2.5 md:px-5 md:py-3 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-300 rounded-lg transition-colors flex items-center justify-center text-sm md:text-base">
                            <i class="fas fa-times mr-2"></i>
                            Cancel
                        </button>
                        <button type="submit" id="save-client-btn" class="flex-1 px-3 py-2.5 md:px-5 md:py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors flex items-center justify-center text-sm md:text-base">
                            <i class="fas fa-save mr-2"></i>
                            Save Client
                        </button>
                        <button type="submit" id="update-client-btn" class="flex-1 px-3 py-2.5 md:px-5 md:py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors hidden items-center justify-center text-sm md:text-base">
                            <i class="fas fa-sync-alt mr-2"></i>
                            Update Client
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirmation-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[110] hidden">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl w-full max-w-md mx-4">
            <div class="p-4 md:p-6">
                <div class="flex items-center justify-center mb-6">
                    <div id="confirmation-icon-container" class="w-16 h-16 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center">
                        <i id="confirmation-icon" class="fas fa-exclamation-triangle text-3xl text-red-600 dark:text-red-400"></i>
                    </div>
                </div>
                
                <h3 id="confirmation-title" class="text-xl font-bold text-center text-gray-800 dark:text-white mb-4">Confirm Deletion</h3>
                <p id="confirmation-message" class="text-gray-600 dark:text-gray-400 text-center mb-8">
                    Are you sure you want to delete this item? This action cannot be undone.
                </p>
                
                <div class="flex justify-center gap-3 w-full">
                    <button id="cancel-confirmation-btn" class="flex-1 px-3 py-2.5 md:px-6 md:py-3 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-300 rounded-lg transition-colors flex items-center justify-center text-sm md:text-base">
                        <i id="confirm-cancel-icon" class="fas fa-times mr-2"></i>
                        <span id="confirm-cancel-text">Cancel</span>
                    </button>
                    <button id="confirm-delete-btn" class="flex-1 px-3 py-2.5 md:px-6 md:py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors flex items-center justify-center text-sm md:text-base">
                        <i id="confirm-action-icon" class="fas fa-trash-alt mr-2"></i>
                        <span id="confirm-action-text">Delete</span>
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- Profile Modal -->
    <div id="profile-modal" class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 hidden overflow-y-auto p-4">
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl w-full max-w-4xl overflow-hidden transform transition-all flex flex-col md:flex-row h-auto md:h-[600px]">
            <!-- Sidebar -->
            <div class="w-full md:w-72 bg-gray-50 dark:bg-gray-900/50 border-r border-gray-100 dark:border-gray-700 p-8 flex flex-col">
                <div class="flex items-center space-x-3 mb-10">
                    <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/20">
                        <i class="fas fa-user-cog text-white text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 dark:text-white">Settings</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Manage your account</p>
                    </div>
                </div>

                <nav class="space-y-2 flex-1">
                    <button onclick="switchProfileTab('info')" id="profile-tab-info" class="profile-nav-item w-full flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all bg-blue-50 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400">
                        <i class="fas fa-id-card w-5"></i>
                        <span>Profile Info</span>
                    </button>
                    <button onclick="switchProfileTab('security')" id="profile-tab-security" class="profile-nav-item w-full flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800">
                        <i class="fas fa-shield-alt w-5"></i>
                        <span>Security Settings</span>
                    </button>
                    <button onclick="switchProfileTab('delete')" id="profile-tab-delete" class="profile-nav-item w-full flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all text-gray-500 dark:text-gray-400 hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 dark:hover:text-red-400">
                        <i class="fas fa-user-times w-5"></i>
                        <span>Delete Account</span>
                    </button>
                </nav>

                <div class="pt-6 border-t border-gray-100 dark:border-gray-700 mt-auto">
                    <button id="close-profile-modal-sidebar" class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-semibold text-gray-500 dark:text-gray-400 hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 dark:hover:text-red-400 transition-all">
                        <i class="fas fa-sign-out-alt w-5"></i>
                        <span>Exit Settings</span>
                    </button>
                </div>
            </div>

            <!-- Content Area -->
            <div class="flex-1 flex flex-col relative bg-white dark:bg-gray-800 h-full">
                <button id="close-profile-modal" class="absolute top-6 right-6 w-10 h-10 flex items-center justify-center rounded-2xl hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-400 transition-all z-10">
                    <i class="fas fa-times"></i>
                </button>

                <div class="flex-1 overflow-y-auto p-10 custom-scrollbar">
                    <!-- Profile Information Section -->
                    <div id="profile-section-info" class="profile-section">
                        <div class="mb-8">
                            <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">Profile Information</h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Update your account's profile information and email address.</p>
                        </div>
                        
                        <form id="profile-form" class="space-y-6">
                            <div class="space-y-2">
                                <label for="profile-name" class="block text-sm font-bold text-gray-700 dark:text-gray-300">Display Name</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-500 transition-colors">
                                        <i class="fas fa-user text-sm"></i>
                                    </div>
                                    <input type="text" id="profile-name" class="w-full pl-11 pr-4 py-3.5 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm font-medium" value="{{ auth()->user()->name }}" required>
                                </div>
                            </div>
                            
                            <div class="space-y-2">
                                <label for="profile-email" class="block text-sm font-bold text-gray-700 dark:text-gray-300">Email Address</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-500 transition-colors">
                                        <i class="fas fa-envelope text-sm"></i>
                                    </div>
                                    <input type="email" id="profile-email" class="w-full pl-11 pr-4 py-3.5 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm font-medium" value="{{ auth()->user()->email }}" required>
                                </div>
                            </div>
                            
                            <div class="pt-4">
                                <button type="submit" class="w-full md:w-auto px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl shadow-lg shadow-blue-500/20 transition-all font-bold text-sm transform active:scale-[0.98]">
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Delete Account Section -->
                    <div id="profile-section-delete" class="profile-section hidden">
                        <div class="mb-8">
                            <h2 class="text-2xl font-bold text-red-600 dark:text-red-400 mb-2">Delete Account</h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Permanently delete your account and all associated data.</p>
                        </div>
                        
                        <div class="bg-red-50 dark:bg-red-900/10 border border-red-200 dark:border-red-900/30 rounded-2xl p-6 mb-8">
                            <div class="flex items-start space-x-4">
                                <div class="w-10 h-10 bg-red-100 dark:bg-red-900/20 text-red-600 dark:text-red-400 rounded-full flex items-center justify-center shrink-0">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-2">Warning: This action is irreversible</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                                        Once you delete your account, there is no going back. Please be certain. All your uploaded data, profile information, and resources will be permanently deleted.
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <form method="post" action="{{ route('profile.destroy') }}" class="space-y-6">
                            @csrf
                            @method('delete')
                            
                            <div class="space-y-2">
                                <label for="delete-password-input" class="block text-sm font-bold text-gray-700 dark:text-gray-300">Confirm Password</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-red-500 transition-colors">
                                        <i class="fas fa-lock text-sm"></i>
                                    </div>
                                    <input type="password" id="delete-password-input" name="password" class="w-full pl-11 pr-4 py-3.5 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-2xl focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all text-sm font-medium" placeholder="Enter your password to confirm" required>
                                </div>
                                @if($errors->userDeletion->has('password'))
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $errors->userDeletion->first('password') }}</p>
                                @endif
                            </div>
                            
                            <div class="pt-4">
                                <button type="submit" class="w-full md:w-auto px-8 py-4 bg-red-600 hover:bg-red-700 text-white rounded-2xl shadow-lg shadow-red-500/20 transition-all font-bold text-sm transform active:scale-[0.98]">
                                    Permanently Delete Account
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Password Change Section -->
                    <div id="profile-section-security" class="profile-section hidden">
                        <div class="mb-8">
                            <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">Security Settings</h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Ensure your account is using a long, random password to stay secure.</p>
                        </div>
                        
                        <form id="password-form" class="space-y-6">
                            <div class="space-y-2">
                                <label for="current-password" class="block text-sm font-bold text-gray-700 dark:text-gray-300">Current Password</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-500 transition-colors">
                                        <i class="fas fa-lock-open text-sm"></i>
                                    </div>
                                    <input type="password" id="current-password" class="w-full pl-11 pr-4 py-3.5 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm" placeholder="••••••••" required>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 gap-6">
                                <div class="space-y-2">
                                    <label for="new-password" class="block text-sm font-bold text-gray-700 dark:text-gray-300">New Password</label>
                                    <div class="relative group">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-500 transition-colors">
                                            <i class="fas fa-key text-sm"></i>
                                        </div>
                                        <input type="password" id="new-password" class="w-full pl-11 pr-4 py-3.5 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm" placeholder="Minimum 8 characters" required>
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <label for="new-password-confirmation" class="block text-sm font-bold text-gray-700 dark:text-gray-300">Confirm New Password</label>
                                    <div class="relative group">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-500 transition-colors">
                                            <i class="fas fa-check-circle text-sm"></i>
                                        </div>
                                        <input type="password" id="new-password-confirmation" class="w-full pl-11 pr-4 py-3.5 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm" placeholder="Repeat your new password" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="pt-4">
                                <button type="submit" class="w-full md:w-auto px-8 py-4 bg-gray-900 dark:bg-blue-500 text-white dark:text-gray-900 rounded-2xl shadow-lg transition-all font-bold text-sm transform active:scale-[0.98]">
                                    Update Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Activity Detail Modal -->
    <div id="activity-detail-modal" class="fixed inset-0 z-[110] flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm hidden animate-fadeIn">
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden transform transition-all flex flex-col max-h-[85vh]">
            <div class="p-6 md:p-8 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between bg-white dark:bg-gray-800 sticky top-0 z-10">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-indigo-50 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-400 rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-500/10 transition-transform group-hover:scale-110">
                        <i class="fas fa-chart-pie text-xl"></i>
                    </div>
                    <div>
                        <h3 id="activity-detail-title" class="text-xl font-black text-gray-900 dark:text-white leading-tight">Activity Breakdown</h3>
                        <p id="activity-detail-subtitle" class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mt-1">Detailed Contribution View</p>
                    </div>
                </div>
                <button onclick="window.closeActivityDetailModal()" class="w-10 h-10 rounded-xl flex items-center justify-center text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700 transition-all">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto p-6 md:p-8 custom-scrollbar bg-gray-50/30 dark:bg-gray-900/10">
                <div id="activity-detail-list" class="space-y-4">
                    <!-- Dynamic list will be injected here -->
                </div>

                <!-- Empty State within Modal -->
                <div id="activity-detail-empty" class="hidden py-16 text-center">
                    <div class="w-20 h-20 bg-gray-50 dark:bg-gray-800/50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-database text-3xl text-gray-200 dark:text-gray-700"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-2">No activity found</h3>
                    <p class="text-gray-500 dark:text-gray-400 text-sm italic">There are no records reported for this selection yet.</p>
                </div>
            </div>

            <div class="p-6 bg-gray-50 dark:bg-gray-800/80 border-t border-gray-100 dark:border-gray-700">
                <button onclick="window.closeActivityDetailModal()" class="w-full py-4 bg-gray-900 dark:bg-white text-white dark:text-gray-900 rounded-2xl font-black hover:bg-gray-800 dark:hover:bg-gray-100 transition-all shadow-xl shadow-gray-900/20 transform active:scale-[0.98]">
                    Dismiss Details
                </button>
            </div>
        </div>
    </div>

    <!-- Password Reset Success Modal -->
    <div id="password-reset-success-modal" class="fixed inset-0 z-[120] flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm hidden animate-fadeIn">
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl w-full max-w-sm overflow-hidden transform transition-all">
            <div class="p-8 text-center">
                <div class="w-16 h-16 bg-emerald-100 dark:bg-emerald-900/30 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-check-circle text-3xl text-emerald-600 dark:text-emerald-400"></i>
                </div>
                
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Password Reset!</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-6 text-sm">
                    The new temporary password is ready. Copy it below:
                </p>

                <div class="relative mb-8 group">
                    <input type="text" id="reset-success-password-input" readonly 
                        class="w-full bg-gray-50 dark:bg-gray-900/50 border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-2xl px-4 py-4 text-center text-xl font-mono font-bold text-indigo-600 dark:text-indigo-400 focus:outline-none tracking-wider select-all cursor-pointer">
                    <button id="copy-reset-btn" class="absolute right-3 top-1/2 -translate-y-1/2 p-2 text-gray-400 hover:text-indigo-600 transition-colors" title="Copy password">
                        <i class="fas fa-copy"></i>
                    </button>
                </div>

                <button id="close-reset-success-btn-final" class="w-full py-4 bg-gray-900 dark:bg-white text-white dark:text-gray-900 rounded-2xl font-bold hover:bg-gray-800 dark:hover:bg-gray-100 transition-all shadow-xl shadow-gray-900/20">
                    Done
                </button>
            </div>
        </div>
    </div>
    <!-- Assign Developer Task Modal -->
    <div id="assign-task-modal" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm hidden animate-fadeIn">
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden border border-white/20 dark:border-gray-700/50 transform transition-all duration-300 scale-100">
            <div class="px-8 py-6 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between bg-gray-50/50 dark:bg-gray-900/20">
                <div>
                    <h3 id="assign-task-modal-title" class="text-xl font-bold text-gray-900 dark:text-white">Assign Task</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Direct task assignment for <span id="assign-task-user-name" class="font-bold text-indigo-600 dark:text-indigo-400">Developer</span></p>
                </div>
                <button onclick="closeAssignTaskModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>

            <div class="p-8">
                <form id="assign-task-form" class="space-y-5">
                    <input type="hidden" id="assign-task-user-id">
                    <input type="hidden" id="assign-task-id">
                    
                    <div>
                        <label class="block text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-2">Task Title</label>
                        <input type="text" id="assign-task-title" required class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm transition-all" placeholder="Enter task title">
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-2">Description</label>
                        <textarea id="assign-task-description" rows="3" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm transition-all" placeholder="Describe the task instructions..."></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-2">Priority</label>
                            <select id="assign-task-priority" required class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm transition-all">
                                <option value="low">Low</option>
                                <option value="medium" selected>Medium</option>
                                <option value="high">High</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-2">Deadline (Optional)</label>
                            <input type="date" id="assign-task-deadline" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm transition-all">
                        </div>
                    </div>

                    <div class="flex gap-4 mt-10">
                        <button type="button" onclick="closeAssignTaskModal()" class="flex-1 px-6 py-3.5 border border-gray-200 dark:border-gray-700 rounded-2xl text-gray-600 dark:text-gray-400 font-bold hover:bg-gray-50 dark:hover:bg-gray-900/50 transition-all text-sm">
                            Cancel
                        </button>
                        <button type="submit" id="save-assign-task-btn" class="flex-1 px-6 py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-bold shadow-xl shadow-indigo-500/20 transition-all text-sm">
                            Assign Task
                        </button>
                        <button type="submit" id="update-assign-task-btn" class="flex-1 px-6 py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-2xl font-bold shadow-xl shadow-emerald-500/20 transition-all text-sm hidden">
                            Update Task
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- User Task History Modal -->
    <div id="user-task-history-modal" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm hidden animate-fadeIn">
        <div class="bg-gray-50 dark:bg-gray-900 rounded-3xl shadow-2xl w-full max-w-4xl overflow-hidden border border-white/20 dark:border-gray-700/50 transform transition-all duration-300 scale-100 flex flex-col max-h-[90vh]">
            <div class="px-8 py-6 border-b border-gray-200 dark:border-gray-800 flex items-center justify-between bg-white dark:bg-gray-800">
                <div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-3">
                        <i class="fas fa-history text-indigo-500"></i>
                        Task History: <span id="history-modal-user-name" class="text-indigo-600 dark:text-indigo-400">Developer</span>
                    </h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Audit and manage all tasks assigned to this user.</p>
                </div>
                <button onclick="closeUserTaskHistory()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>

            <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-800 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex bg-gray-100 dark:bg-gray-900 p-1 rounded-xl border border-gray-200 dark:border-gray-700">
                    <button onclick="filterHistoryTasks('all')" id="history-filter-all" class="history-filter px-4 py-1.5 rounded-lg text-xs font-bold transition-all bg-white dark:bg-gray-700 text-indigo-600 dark:text-indigo-400 shadow-sm">All</button>
                    <button onclick="filterHistoryTasks('pending')" id="history-filter-pending" class="history-filter px-4 py-1.5 rounded-lg text-xs font-bold text-gray-500 dark:text-gray-400 transition-all hover:text-gray-700 dark:hover:text-gray-200">Pending</button>
                    <button onclick="filterHistoryTasks('completed')" id="history-filter-completed" class="history-filter px-4 py-1.5 rounded-lg text-xs font-bold text-gray-500 dark:text-gray-400 transition-all hover:text-gray-700 dark:hover:text-gray-200">Completed</button>
                </div>
                <div class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">
                    Total Tasks: <span id="history-total-count" class="text-gray-900 dark:text-white">0</span>
                </div>
            </div>

            <div class="flex-1 overflow-y-auto p-8 space-y-4 no-scrollbar relative" id="history-tasks-container">
                <!-- User specific tasks -->
            </div>
            
            <div id="history-empty-state" class="hidden absolute inset-0 flex flex-col items-center justify-center p-12 text-center pointer-events-none mt-40">
                <i class="fas fa-folder-open text-4xl text-gray-200 dark:text-gray-700 mb-4"></i>
                <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">No tasks found for this user.</p>
            </div>

            <div class="px-8 py-6 bg-gray-50 dark:bg-gray-900/50 border-t border-gray-200 dark:border-gray-800 flex justify-end">
                <button onclick="closeUserTaskHistory()" class="px-6 py-2.5 bg-gray-900 dark:bg-white text-white dark:text-gray-900 rounded-xl font-bold hover:bg-gray-800 dark:hover:bg-gray-100 transition-all text-sm">
                    Close History
                </button>
            </div>
        </div>
    </div>

    <!-- Developer Task Comments Modal -->
    <div id="dev-task-comments-modal" class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-[120] hidden p-4">
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl w-full max-w-2xl h-[600px] flex flex-col overflow-hidden animate-zoomIn">
            <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between bg-white dark:bg-gray-800 sticky top-0 z-10">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-indigo-50 dark:bg-indigo-900/30 rounded-2xl flex items-center justify-center">
                        <i class="fas fa-comments text-indigo-600 dark:text-indigo-400"></i>
                    </div>
                    <div>
                        <h3 id="dev-task-comments-title" class="text-lg font-bold text-gray-900 dark:text-white">Task Discussion</h3>
                        <p id="dev-task-comments-subtitle" class="text-xs text-gray-500 dark:text-gray-400">Team chat about this assignment</p>
                    </div>
                </div>
                <button onclick="closeDevTaskComments()" class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-50 dark:bg-gray-700 text-gray-400 hover:text-gray-900 dark:hover:text-white transition-all">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div id="dev-task-comments-container" class="flex-1 overflow-y-auto p-6 space-y-4 no-scrollbar bg-gray-50/30 dark:bg-gray-900/10">
                <!-- Comments will be rendered here -->
            </div>

            <div class="p-6 border-t border-gray-100 dark:border-gray-700 bg-white dark:bg-gray-800">
                <form id="dev-task-comment-form" onsubmit="submitDevTaskComment(event)" class="relative">
                    <input type="hidden" id="dev-task-comment-task-id">
                    <div class="relative flex items-center gap-3">
                        <div class="relative flex-1">
                            <input type="text" id="dev-task-comment-input" 
                                class="w-full pl-5 pr-12 py-4 bg-gray-50 dark:bg-gray-700/50 border border-gray-100 dark:border-gray-600 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all dark:text-white" 
                                placeholder="Type your message here..." required>
                        </div>
                        <button type="submit" id="dev-task-comment-submit-btn" class="w-14 h-14 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-600/20 transition-all group">
                            <i class="fas fa-paper-plane group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
