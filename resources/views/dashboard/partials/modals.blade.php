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
                    
                    
                    <div class="flex flex-row space-x-3 w-full">
                        <button type="button" id="cancel-client-btn" class="flex-1 px-5 py-3 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-300 rounded-lg transition-colors flex items-center justify-center">
                            <i class="fas fa-times mr-2"></i>
                            Cancel
                        </button>
                        <button type="submit" id="save-client-btn" class="flex-1 px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors flex items-center justify-center">
                            <i class="fas fa-save mr-2"></i>
                            Save Client
                        </button>
                        <button type="submit" id="update-client-btn" class="flex-1 px-5 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors hidden items-center justify-center">
                            <i class="fas fa-sync-alt mr-2"></i>
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
                
                <div class="flex justify-center space-x-3 w-full">
                    <button id="cancel-confirmation-btn" class="flex-1 px-6 py-3 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-300 rounded-lg transition-colors flex items-center justify-center">
                        <i class="fas fa-times mr-2"></i>
                        Cancel
                    </button>
                    <button id="confirm-delete-btn" class="flex-1 px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors flex items-center justify-center">
                        <i class="fas fa-trash-alt mr-2"></i>
                        Delete
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
