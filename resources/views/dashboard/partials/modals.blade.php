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
                    
                    <div class="mb-6">
                        <label for="client-status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                        <select id="client-status" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="active">Active</option>
                            <option value="pending">Pending</option>
                            <option value="inactive">Inactive</option>
                            <option value="archived">Archived</option>
                        </select>
                    </div>
                    
                    <div class="flex justify-end space-x-3">
                        <button type="button" id="cancel-client-btn" class="px-5 py-3 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-300 rounded-lg transition-colors">
                            Cancel
                        </button>
                        <button type="submit" id="save-client-btn" class="px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                            Save Client
                        </button>
                        <button type="submit" id="update-client-btn" class="px-5 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors hidden">
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
                
                <div class="flex justify-center space-x-4">
                    <button id="cancel-confirmation-btn" class="px-6 py-3 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-300 rounded-lg transition-colors">
                        Cancel
                    </button>
                    <button id="confirm-delete-btn" class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors">
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Modal -->
    <div id="profile-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden overflow-y-auto">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl w-full max-w-md mx-4 my-8">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white">Profile & Security</h3>
                    <button id="close-profile-modal" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <!-- Profile Information Section -->
                <div class="mb-8">
                    <h4 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">Profile Information</h4>
                    <form id="profile-form">
                        <div class="mb-4">
                            <label for="profile-name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Display Name</label>
                            <input type="text" id="profile-name" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ auth()->user()->name }}" required>
                        </div>
                        
                        <div class="mb-6">
                            <label for="profile-email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email Address</label>
                            <input type="email" id="profile-email" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ auth()->user()->email }}" required>
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors text-sm font-medium">Update Info</button>
                        </div>
                    </form>
                </div>

                <div class="border-t border-gray-200 dark:border-gray-700 my-6"></div>

                <!-- Password Change Section -->
                <div>
                    <h4 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">Change Password</h4>
                    <form id="password-form">
                        <div class="mb-4">
                            <label for="current-password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Current Password</label>
                            <input type="password" id="current-password" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="••••••••" required>
                        </div>
                        
                        <div class="mb-4">
                            <label for="new-password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">New Password</label>
                            <input type="password" id="new-password" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="••••••••" required>
                        </div>

                        <div class="mb-6">
                            <label for="new-password-confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Confirm New Password</label>
                            <input type="password" id="new-password-confirmation" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="••••••••" required>
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="submit" class="px-5 py-2.5 bg-gray-800 dark:bg-gray-200 text-white dark:text-gray-800 hover:bg-gray-900 dark:hover:bg-white rounded-lg transition-colors text-sm font-medium">Update Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
