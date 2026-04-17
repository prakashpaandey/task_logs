    <script>
        // DOM Elements
        const appContainer = document.getElementById('app');
        const themeToggle = document.getElementById('theme-toggle');
        const themeIcon = document.getElementById('theme-icon');
        const userMenuButton = document.getElementById('user-menu-button');
        const userDropdown = document.getElementById('user-dropdown');
        const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebar-overlay');
        const closeSidebarBtn = document.getElementById('close-sidebar');
        const toggleSidebarBtn = document.getElementById('toggle-sidebar');
        const toggleIcon = document.getElementById('toggle-icon');
        const clientItems = document.querySelectorAll('.client-item');
        const clientSearch = document.getElementById('client-search');
        const addClientBtn = document.getElementById('add-client-btn');
        const quickAddClientBtn = document.getElementById('quick-add-client-btn');
        const addFirstClientBtn = document.getElementById('add-first-client-btn');
        const viewAllClientsBtn = document.getElementById('view-all-clients-btn');
        const clientSelectionPrompt = document.getElementById('statistics-dashboard');
        const clientContent = document.getElementById('client-content');
        const selectedClientName = document.getElementById('selected-client-name');
        const selectedClientStatus = document.getElementById('selected-client-status');
        const editClientBtn = document.getElementById('edit-client-btn');
        const deleteClientBtn = document.getElementById('delete-client-btn');
        const clientModal = document.getElementById('client-modal');
        const closeClientModal = document.getElementById('close-client-modal');
        const cancelClientBtn = document.getElementById('cancel-client-btn');
        const clientForm = document.getElementById('client-form');
        const clientModalTitle = document.getElementById('client-modal-title');
        const saveClientBtn = document.getElementById('save-client-btn');
        const updateClientBtn = document.getElementById('update-client-btn');
        const confirmationModal = document.getElementById('confirmation-modal');
        const cancelConfirmationBtn = document.getElementById('cancel-confirmation-btn');
        const confirmDeleteBtn = document.getElementById('confirm-delete-btn');
        const confirmationTitle = document.getElementById('confirmation-title');
        const confirmationMessage = document.getElementById('confirmation-message');
        const successNotification = document.getElementById('success-notification');
        const errorNotification = document.getElementById('error-notification');
        const successMessage = document.getElementById('success-message');
        const errorMessage = document.getElementById('error-message');
        
        // Notifications Elements
        const notificationsButton = document.getElementById('notifications-button');
        const notificationsDropdown = document.getElementById('notifications-dropdown');
        const notificationsBadge = document.getElementById('notifications-badge');
        const notificationsList = document.getElementById('notifications-list');
        const notificationsWrapper = document.getElementById('notifications-wrapper');
        
        // Profile & Security Elements
        const profileBtn = document.getElementById('profile-btn');
        const profileModal = document.getElementById('profile-modal');
        const closeProfileModal = document.getElementById('close-profile-modal');
        const cancelProfileBtn = document.getElementById('cancel-profile-btn');
        const profileForm = document.getElementById('profile-form');
        const passwordForm = document.getElementById('password-form');
        
        // Main Task Elements
        const addMainTaskBtn = document.getElementById('add-main-task-btn');
        const mainTaskForm = document.getElementById('main-task-form');
        const saveMainTaskBtn = document.getElementById('save-main-task-btn');
        const updateMainTaskBtn = document.getElementById('update-main-task-btn');
        const cancelMainTaskBtn = document.getElementById('cancel-main-task-btn');
        const mainTaskItems = document.querySelectorAll('.main-task-item');
        const mainTaskTitle = document.getElementById('main-task-title');
        const mainTaskDescription = document.getElementById('main-task-description');
        const taskStatusButtons = document.querySelectorAll('.task-status-btn');
        
        // Subtask Elements
        const addSubtaskBtn = document.getElementById('add-subtask-btn');
        const selectedMainTaskInfo = document.getElementById('selected-main-task-info');
        const selectedMainTaskTitle = document.getElementById('selected-main-task-title');
        const selectedMainTaskDescription = document.getElementById('selected-main-task-description');
        const changeMainTaskBtn = document.getElementById('change-main-task-btn');
        const subtaskForm = document.getElementById('subtask-form');
        const saveSubtaskBtn = document.getElementById('save-subtask-btn');
        const updateSubtaskBtn = document.getElementById('update-subtask-btn');
        const cancelSubtaskBtn = document.getElementById('cancel-subtask-btn');
        const subtaskTitle = document.getElementById('subtask-title');
        const subtaskDescription = document.getElementById('subtask-description');
        const subtaskWorkDate = document.getElementById('subtask-work-date');
        const subtaskItems = document.querySelectorAll('.subtask-item');
        const subtasksList = document.getElementById('subtasks-list');
        const subtaskCommentsSection = document.getElementById('subtask-comments-section');
        const addCommentBtn = document.getElementById('add-comment-btn');
        const commentForm = document.getElementById('comment-form');
        const saveCommentBtn = document.getElementById('save-comment-btn');
        const cancelCommentBtn = document.getElementById('cancel-comment-btn');
        const commentText = document.getElementById('comment-text');
        
        // Time Log Elements
        const subtaskTimeLogsSection = document.getElementById('subtask-time-logs-section');
        const addTimeLogBtn = document.getElementById('add-time-log-btn');
        const timeLogForm = document.getElementById('time-log-form');
        const saveTimeLogBtn = document.getElementById('save-time-log-btn');
        const updateTimeLogBtn = document.getElementById('update-time-log-btn');
        const cancelTimeLogBtn = document.getElementById('cancel-time-log-btn');
        const timeLogValue = document.getElementById('time-log-value');
        const timeLogsList = document.getElementById('time-logs-list');
        const subtaskDetailView = document.getElementById('subtask-detail-view');
        const detailSubtaskTitle = document.getElementById('detail-subtask-title');
        const detailSubtaskDescription = document.getElementById('detail-subtask-description');
        const detailSubtaskDescriptionContainer = document.getElementById('detail-subtask-description-container');
        
        // State variables
        let currentClientId = window.App.selectedClient ? window.App.selectedClient.id : null;
        let editingClientId = null;
        let currentMainTaskId = null;
        let currentSubtaskId = null;
        let currentCommentId = null;
        let editingTimeLogId = null;
        let deleteCallback = null;
        let currentDeleteType = null;
        let sidebarCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
        
        // Notifications state
        let notifications = [];
        let lastNotificationCount = 0;
        let isSuperAdmin = {{ auth()->user()->isAdmin() ? 'true' : 'false' }};
        
        // User Dashboard State
        if (!window.App.users) window.App.users = [];
        let userDashboardFilter = 'active'; // 'active' or 'deactivated'
        let userDashboardSearchTerm = '';
        
        // Helper for API calls
        async function apiCall(url, method = 'GET', data = null) {
            const options = {
                method,
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': window.App.csrfToken
                }
            };
            
            if (data) {
                options.body = JSON.stringify(data);
            }
            
            try {
                const response = await fetch(url, options);
                const result = await response.json();
                
                if (!response.ok) {
                    throw new Error(result.message || 'Something went wrong');
                }
                
                return result;
            } catch (error) {
                showErrorNotification(error.message);
                throw error;
            }
        }

        // Initialize the UI
        function init() {
            // Update icon state based on current theme (now applied in head)
            if (document.documentElement.classList.contains('dark')) {
                themeIcon.classList.remove('fa-moon');
                themeIcon.classList.add('fa-sun');
            } else {
                themeIcon.classList.remove('fa-sun');
                themeIcon.classList.add('fa-moon');
            }
            
            // Set default date for subtask work date
            const today = new Date().toISOString().split('T')[0];
            subtaskWorkDate.value = today;
            
            // Set up event listeners
            setupEventListeners();

            // Initialize sidebar state
            updateSidebarState();
            
            // Show initial state
            if (window.App.selectedClient) {
                switchView('client');
                // Optionally load main tasks if they aren't already in App.selectedClient
                renderMainTasks(window.App.selectedClient.main_tasks || []);
                
                // Set join date for initial client
                const joinDate = new Date(window.App.selectedClient.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                const joinDateEl = document.getElementById('client-join-date');
                if (joinDateEl) joinDateEl.textContent = joinDate;
            } else {
                switchView('statistics');
            }

            // Start Nepali Clock
            startNepaliClock();

            // Start Remote Logout Heartbeat
            startHeartbeat();

            // Start Global State Sync (Instant Updates)
            startPulseSync();
        }

        /**
         * Nepali Live Clock (UTC+5:45)
         */
        function startNepaliClock() {
            const clockEl = document.getElementById('nepali-clock');
            if (!clockEl) return;

            const updateTime = () => {
                // Get UTC time and adjust for Nepal Offset (+5:45)
                const now = new Date();
                const utc = now.getTime() + (now.getTimezoneOffset() * 60000);
                const nepalOffset = 5.75; // 5 hours and 45 minutes
                const nepalTime = new Date(utc + (3600000 * nepalOffset));

                const hours = nepalTime.getHours().toString().padStart(2, '0');
                const minutes = nepalTime.getMinutes().toString().padStart(2, '0');
                const seconds = nepalTime.getSeconds().toString().padStart(2, '0');
                
                clockEl.textContent = `${hours}:${minutes}:${seconds}`;
            };

            updateTime();
            setInterval(updateTime, 1000);
        }

        /**
         * Live Kick / Remote Logout Heartbeat
         * Periodically checks if the user's account has been flagged for force logout.
         */
        let heartbeatInterval = null;
        function startHeartbeat() {
            if (heartbeatInterval) clearInterval(heartbeatInterval);
            
            heartbeatInterval = setInterval(async () => {
                try {
                    const response = await fetch('{{ route('dashboard.account.status') }}', {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });
                    
                    if (response.status === 401 || response.status === 419) {
                        // Session already expired or kicked
                        window.location.href = '/login';
                        return;
                    }

                    const data = await response.json();
                    if (data.force_logout) {
                        clearInterval(heartbeatInterval);
                        // Immediate redirect if flagged
                        window.location.href = '/login?reason=reset';
                    }
                } catch (error) {
                    // Fail silently for network issues
                }
            }, 10000); // Check every 10 seconds
        }

        /**
         * Global State Sync Engine
         * Periodically fetches the latest state from the server to keep the UI in sync.
         */
        let syncInterval = null;
        let lastSyncData = null;
        let isUserTyping = false;

        function startPulseSync() {
            if (syncInterval) clearInterval(syncInterval);
            
            // Listen for typing events to avoid UI jumps while editing
            document.addEventListener('focusin', (e) => {
                if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA') {
                    isUserTyping = true;
                }
            });
            document.addEventListener('focusout', (e) => {
                if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA') {
                    isUserTyping = false;
                }
            });

            syncInterval = setInterval(async () => {
                // Skip sync if user is actively writing to avoid losing focus
                if (isUserTyping || typeof isSubmittingClient !== 'undefined' && isSubmittingClient || typeof isSubmittingMainTask !== 'undefined' && isSubmittingMainTask || typeof isSubmittingSubtask !== 'undefined' && isSubmittingSubtask || typeof isSubmittingTimeLog !== 'undefined' && isSubmittingTimeLog || typeof isSubmittingComment !== 'undefined' && isSubmittingComment) {
                    return;
                }

                try {
                    const response = await fetch('{{ route('dashboard.sync') }}', {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });
                    
                    if (!response.ok) return;

                    const data = await response.json();
                    if (data.success) {
                        handleSyncPulse(data);
                    }
                } catch (error) {
                    // Fail silently
                }
            }, 15000); // Pulse every 15 seconds
        }

        function handleSyncPulse(data) {
            // 1. Update Statistics (Cards)
            if (data.statistics && data.statistics.success) {
                updateStatisticsDisplay(data.statistics);
            }

            // 2. Update Global App State
            const oldClientsJson = JSON.stringify(window.App.clients);
            const newClientsJson = JSON.stringify(data.clients);

            if (oldClientsJson !== newClientsJson) {
                const wasEmpty = !window.App.clients || window.App.clients.length === 0;
                window.App.clients = data.clients;
                const isNowPopulated = window.App.clients && window.App.clients.length > 0;
                
                // Re-render Client List (Sidebar)
                if (typeof renderClientsList === 'function') renderClientsList();

                // If user was newly assigned their first client, show a success toast
                if (wasEmpty && isNowPopulated) {
                    showSuccessNotification('You have been assigned to new clients! Check your sidebar.');
                }

               // If we are currently viewing a client, refresh the active view
                if (currentClientId) {
                    const updatedClient = typeof findClient === 'function' ? findClient(currentClientId) : null;
                    if (updatedClient) {
                        // Refresh Main Tasks list if we are in the client view
                        if (!document.getElementById('client-content').classList.contains('hidden')) {
                            if (typeof renderMainTasks === 'function') renderMainTasks(updatedClient.main_tasks || []);
                            
                            // Refresh breadcrumb text in case client was renamed
                            if (typeof updateBreadcrumb === 'function') updateBreadcrumb();

                            // If a main task is selected, refresh its subtasks
                            if (currentMainTaskId) {
                                const updatedTask = typeof findMainTask === 'function' ? findMainTask(currentMainTaskId) : null;
                                if (updatedTask) {
                                    if (typeof renderSubtasks === 'function') renderSubtasks(updatedTask.subtasks || []);
                                    
                                    // If a subtask is selected, refresh its details/comments
                                    if (currentSubtaskId) {
                                        const updatedSubtask = typeof findSubtask === 'function' ? findSubtask(currentSubtaskId) : null;
                                        if (updatedSubtask) {
                                            if (typeof updateSubtaskDetailHeader === 'function') updateSubtaskDetailHeader(updatedSubtask);
                                            if (typeof renderComments === 'function') renderComments(updatedSubtask.comments || []);
                                            if (typeof renderTimeLogs === 'function') renderTimeLogs(updatedSubtask.time_logs || []);
                                            
                                            // Update details description if shown
                                            const subtaskDescEl = document.getElementById('detail-subtask-description');
                                            if (subtaskDescEl && updatedSubtask.description) {
                                                subtaskDescEl.textContent = updatedSubtask.description;
                                            }
                                        } else {
                                            // Subtask was deleted externally
                                            if (typeof resetSubtaskForm === 'function') resetSubtaskForm();
                                            showErrorNotification('The subtask you were viewing was deleted by another user.');
                                        }
                                    }
                                } else {
                                    // Main task was deleted externally
                                    if (typeof resetMainTaskSelection === 'function') resetMainTaskSelection();
                                    showErrorNotification('The task you were viewing was deleted by another user.');
                                }
                            }
                        }
                    } else {
                        // Client was likely deleted by another admin
                        if (typeof showClientSelectionPrompt === 'function') showClientSelectionPrompt();
                        showErrorNotification('The client you were viewing is no longer available.', 'warning');
                    }
                    
                    // Dynamic Cleanup: Handle entities that might have been deleted externally
                    handleDeletedEntities(data.clients);
                }
            }

            // 3. Process Notifications (Admins Only)
            if (typeof isSuperAdmin !== 'undefined' && isSuperAdmin && data.notifications) {
                processNotifications(data.notifications);
            }
        }

        function updateStatisticsDisplay(stats) {
            // Update Time Logs (Dashboard Cards)
            if (document.getElementById('stat-time-today'))
                document.getElementById('stat-time-today').textContent = parseFloat(stats.time_logs.today || 0).toFixed(1) + 'h';
            if (document.getElementById('stat-time-week'))
                document.getElementById('stat-time-week').textContent = parseFloat(stats.time_logs.week || 0).toFixed(1) + 'h';
            if (document.getElementById('stat-time-month'))
                document.getElementById('stat-time-month').textContent = parseFloat(stats.time_logs.month || 0).toFixed(1) + 'h';
            
            // Update Comments
            if (document.getElementById('stat-comments-today'))
                document.getElementById('stat-comments-today').textContent = stats.comments.today || 0;
            if (document.getElementById('stat-comments-week'))
                document.getElementById('stat-comments-week').textContent = stats.comments.week || 0;
            if (document.getElementById('stat-comments-month'))
                document.getElementById('stat-comments-month').textContent = stats.comments.month || 0;

            // Update Recent Activity Table
            const personalActivityTable = document.getElementById('personal-activity-table-body');
            if (personalActivityTable && stats.recent_activity) {
                if (stats.recent_activity.length > 0) {
                    personalActivityTable.innerHTML = stats.recent_activity.map(log => `
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/30 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-xs font-bold text-gray-700 dark:text-gray-300">${new Date(log.created_at).toLocaleDateString()}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="text-[10px] font-black text-blue-600 dark:text-blue-400 uppercase tracking-tighter">${log.subtask?.main_task?.client?.name || 'N/A'}</span>
                                    <span class="text-xs font-semibold text-gray-800 dark:text-gray-200 mt-0.5 line-clamp-1">${log.subtask?.main_task?.title || 'Unknown Task'}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <span class="inline-flex px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded-lg text-xs font-black text-gray-700 dark:text-gray-200">
                                    ${log.time}h
                                </span>
                            </td>
                        </tr>
                    `).join('');
                }
            }
        }

        // Load Statistics
        async function loadStatistics() {
            try {
                const response = await apiCall('{{ route('dashboard.statistics') }}');
                if (response.success) {
                    // Update Titles based on user role
                    const titleEl = document.getElementById('stat-dashboard-title');
                    const subtitleEl = document.getElementById('stat-dashboard-subtitle');
                    
                    if (response.is_admin) {
                        if (titleEl) titleEl.textContent = 'System Overview';
                        if (subtitleEl) subtitleEl.textContent = 'Global activity summary for all users';
                        window.App.statBreakdown = response.breakdown;
                    } else {
                        if (titleEl) titleEl.textContent = 'Personal Productivity';
                        if (subtitleEl) subtitleEl.textContent = `Activity summary for ${window.App.user.name}`;
                        window.App.statBreakdown = null;
                    }

                    // Update Time Logs
                    if (document.getElementById('stat-time-today'))
                        document.getElementById('stat-time-today').textContent = parseFloat(response.time_logs.today || 0).toFixed(1) + 'h';
                    if (document.getElementById('stat-time-week'))
                        document.getElementById('stat-time-week').textContent = parseFloat(response.time_logs.week || 0).toFixed(1) + 'h';
                    if (document.getElementById('stat-time-month'))
                        document.getElementById('stat-time-month').textContent = parseFloat(response.time_logs.month || 0).toFixed(1) + 'h';
                    
                    // Update Comments
                    if (document.getElementById('stat-comments-today'))
                        document.getElementById('stat-comments-today').textContent = response.comments.today || 0;
                    if (document.getElementById('stat-comments-week'))
                        document.getElementById('stat-comments-week').textContent = response.comments.week || 0;
                    if (document.getElementById('stat-comments-month'))
                        document.getElementById('stat-comments-month').textContent = response.comments.month || 0;

                    // Update Recent Activity Table
                    const personalActivityTable = document.getElementById('personal-activity-table-body');
                    const personalActivityTitle = document.querySelector('#personal-activity-dashboard h3');

                    if (personalActivityTable) {
                        if (response.recent_activity && response.recent_activity.length > 0) {
                            if (personalActivityTitle) {
                                personalActivityTitle.textContent = response.is_admin ? 'Latest System Activity' : 'Recent Activity';
                            }
                            
                            personalActivityTable.innerHTML = response.recent_activity.map(log => `
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/30 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-xs font-bold text-gray-700 dark:text-gray-300">
                                            ${new Date(log.created_at).toLocaleDateString()}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span class="text-[10px] font-black text-blue-600 dark:text-blue-400 uppercase tracking-tighter">
                                                ${log.subtask?.main_task?.client?.name || 'N/A'}
                                            </span>
                                            <span class="text-xs font-semibold text-gray-800 dark:text-gray-200 mt-0.5 line-clamp-1">
                                                ${log.subtask?.main_task?.title || 'Unknown Task'}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <span class="inline-flex px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded-lg text-xs font-black text-gray-700 dark:text-gray-200">
                                            ${log.time}h
                                        </span>
                                    </td>
                                </tr>
                            `).join('');
                        } else {
                            personalActivityTable.innerHTML = `
                                <tr>
                                    <td colspan="3" class="px-6 py-12 text-center text-gray-400 dark:text-gray-500 text-sm italic">
                                        No recent activity reported in the last 30 days.
                                    </td>
                                </tr>
                            `;
                        }
                    }
                }
            } catch (error) {
                console.error('Error loading statistics:', error);
            }
        }

        
        // Activity Detail Modal Handlers
        window.showActivityDetails = function(period, type) {
            if (!window.App.statBreakdown) return;
            
            const breakdownData = window.App.statBreakdown[type][period];
            const listContainer = document.getElementById('activity-detail-list');
            const titleEl = document.getElementById('activity-detail-title');
            const subtitleEl = document.getElementById('activity-detail-subtitle');
            const emptyEl = document.getElementById('activity-detail-empty');
            const modal = document.getElementById('activity-detail-modal');

            if (!modal || !listContainer) return;

            // Set Title
            const periodLabel = period.charAt(0).toUpperCase() + period.slice(1);
            const typeLabel = type === 'time' ? 'Time Tracking' : 'Communication';
            titleEl.textContent = `${typeLabel} Breakdown`;
            subtitleEl.textContent = `Showing contributions for ${periodLabel}`;

            listContainer.innerHTML = '';
            
            if (!breakdownData || breakdownData.length === 0) {
                emptyEl.classList.remove('hidden');
            } else {
                emptyEl.classList.add('hidden');
                breakdownData.forEach(item => {
                    listContainer.innerHTML += `
                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-2xl border border-gray-100 dark:border-gray-600 hover:shadow-md transition-shadow">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500 to-blue-600 flex items-center justify-center text-white font-bold shadow-sm">
                                    ${item.initials}
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-bold text-gray-900 dark:text-white truncate">${item.user_name}</p>
                                    <p class="text-[10px] text-gray-500 dark:text-gray-400 truncate">${item.user_email}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-black text-indigo-600 dark:text-indigo-400">${item.value}</p>
                                <p class="text-[9px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">${type === 'time' ? 'Logged' : 'Posted'}</p>
                            </div>
                        </div>
                    `;
                });
            }

            modal.classList.remove('hidden');
        };

        window.closeActivityDetailModal = function() {
            const modal = document.getElementById('activity-detail-modal');
            if (modal) modal.classList.add('hidden');
        };

        // Sidebar Collapse Logic
        function updateSidebarState() {
            if (!sidebar || !toggleIcon || !toggleSidebarBtn) return;
            
            if (sidebarCollapsed) {
                sidebar.classList.add('sidebar-collapsed');
                toggleIcon.classList.remove('fa-angles-left');
                toggleIcon.classList.add('fa-angles-right');
                toggleSidebarBtn.title = "Expand Sidebar";
            } else {
                sidebar.classList.remove('sidebar-collapsed');
                toggleIcon.classList.remove('fa-angles-right');
                toggleIcon.classList.add('fa-angles-left');
                toggleSidebarBtn.title = "Collapse Sidebar";
            }
        }
        
        // Set up all event listeners
        function setupEventListeners() {
            // Theme toggle
            if (themeToggle) themeToggle.addEventListener('click', toggleDarkMode);
            
            // User dropdown
            if (userMenuButton) userMenuButton.addEventListener('click', toggleUserDropdown);
            
            // Mobile menu toggle
            if (mobileMenuToggle) {
                mobileMenuToggle.addEventListener('click', toggleMobileMenu);
            }
            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', closeMobileMenu);
            }
            if (closeSidebarBtn) {
                closeSidebarBtn.addEventListener('click', closeMobileMenu);
            }
            
            if (toggleSidebarBtn) {
                toggleSidebarBtn.addEventListener('click', () => {
                    sidebarCollapsed = !sidebarCollapsed;
                    localStorage.setItem('sidebarCollapsed', sidebarCollapsed);
                    updateSidebarState();
                });
            }

            if (userMenuButton && userDropdown) {
                document.addEventListener('click', (e) => {
                    if (!userMenuButton.contains(e.target) && !userDropdown.contains(e.target)) {
                        userDropdown.classList.add('hidden');
                    }
                });
            }
            
            // Client selection (Delegation)
            const clientsListContainer = document.getElementById('clients-list-container');
            if (clientsListContainer) {
                clientsListContainer.addEventListener('click', (e) => {
                    const item = e.target.closest('.client-item');
                    if (item) selectClient(item);
                });
            }
            
            // Client search
            if (clientSearch) {
                clientSearch.addEventListener('input', filterClients);
            }
            
            // Add client buttons
            if (addClientBtn) addClientBtn.addEventListener('click', () => openClientModal('add'));
            if (quickAddClientBtn) quickAddClientBtn.addEventListener('click', () => openClientModal('add'));
            if (addFirstClientBtn) addFirstClientBtn.addEventListener('click', () => openClientModal('add'));
            
            // View all clients
            if (viewAllClientsBtn) {
                viewAllClientsBtn.addEventListener('click', () => {
                    if (clientSearch) {
                        clientSearch.value = '';
                        filterClients();
                        clientSearch.focus();
                    }
                    
                    // On mobile, open sidebar to show clients
                    if (window.innerWidth < 768) {
                        toggleMobileMenu();
                    } else {
                        // On desktop, maybe pulse the sidebar or just clear
                        sidebar.classList.add('ring-2', 'ring-blue-500', 'ring-inset');
                        setTimeout(() => sidebar.classList.remove('ring-2', 'ring-blue-500', 'ring-inset'), 1000);
                    }
                });
            }
            
            // Client modal
            if (closeClientModal) closeClientModal.addEventListener('click', () => closeClientModalFunc());
            if (cancelClientBtn) cancelClientBtn.addEventListener('click', () => closeClientModalFunc());
            if (clientForm) clientForm.addEventListener('submit', handleClientFormSubmit);
            
            // Edit and delete client buttons
            if (editClientBtn) {
                editClientBtn.addEventListener('click', () => {
                    const client = window.App.clients.find(c => c.id == currentClientId);
                    if (client) openClientModal('edit', client.id, client.name);
                });
            }
            if (deleteClientBtn) {
                deleteClientBtn.addEventListener('click', () => {
                    const client = window.App.clients.find(c => c.id == currentClientId);
                    if (client) openConfirmationModal('client', client.name, deleteCurrentClient);
                });
            }
            
            // Confirmation modal
            if (cancelConfirmationBtn) cancelConfirmationBtn.addEventListener('click', () => closeConfirmationModal());
            
            // Main task buttons
            if (addMainTaskBtn) {
                addMainTaskBtn.addEventListener('click', () => {
                    if (mainTaskForm) {
                        if (mainTaskForm.classList.contains('hidden')) {
                            openMainTaskForm('add');
                        } else {
                            resetMainTaskForm();
                        }
                    }
                });
            }
            if (cancelMainTaskBtn) cancelMainTaskBtn.addEventListener('click', resetMainTaskForm);
            if (saveMainTaskBtn) saveMainTaskBtn.addEventListener('click', saveMainTask);
            if (updateMainTaskBtn) updateMainTaskBtn.addEventListener('click', updateMainTask);
            
            // Task status buttons logic removed
            
            // Main task list event delegation
            const mainTasksList = document.getElementById('main-tasks-list');
            if (mainTasksList) {
                mainTasksList.addEventListener('click', (e) => {
                    const item = e.target.closest('.main-task-item');
                    if (!item) return;

                    if (e.target.closest('.edit-main-task-btn')) {
                        e.stopPropagation();
                        const taskId = item.getAttribute('data-task-id');
                        const task = findMainTask(taskId);
                        if (task) openMainTaskForm('edit', task.id, task.title, task.description, task.category_id);
                    } else if (e.target.closest('.delete-main-task-btn')) {
                        e.stopPropagation();
                        const taskId = item.getAttribute('data-task-id');
                        const task = findMainTask(taskId);
                        if (task) openConfirmationModal('main task', task.title, () => deleteMainTask(taskId));
                    } else {
                        selectMainTask(item);
                    }
                });
            }
            
            // Subtask buttons
            if (addSubtaskBtn) {
                addSubtaskBtn.addEventListener('click', () => {
                    if (subtaskForm) {
                        if (subtaskForm.classList.contains('hidden')) {
                            openSubtaskForm('add');
                        } else {
                            resetSubtaskForm();
                        }
                    }
                });
            }
            
            // Profile & Security listeners
            if (profileBtn) profileBtn.addEventListener('click', openProfileModal);
            if (closeProfileModal) closeProfileModal.addEventListener('click', closeProfileModalFunc);
            if (document.getElementById('close-profile-modal-sidebar')) {
                document.getElementById('close-profile-modal-sidebar').addEventListener('click', closeProfileModalFunc);
            }
            if (cancelProfileBtn) cancelProfileBtn.addEventListener('click', closeProfileModalFunc);
            if (profileForm) profileForm.addEventListener('submit', handleProfileUpdate);
            if (passwordForm) passwordForm.addEventListener('submit', handlePasswordUpdate);
            if (cancelSubtaskBtn) cancelSubtaskBtn.addEventListener('click', resetSubtaskForm);
            if (saveSubtaskBtn) saveSubtaskBtn.addEventListener('click', saveSubtask);
            if (updateSubtaskBtn) updateSubtaskBtn.addEventListener('click', updateSubtask);
            if (changeMainTaskBtn) changeMainTaskBtn.addEventListener('click', () => resetMainTaskSelection());
            
            // Subtasks list event delegation
            const subtasksContainer = document.getElementById('subtasks-container');
            if (subtasksContainer) {
                subtasksContainer.addEventListener('click', (e) => {
                    const item = e.target.closest('.subtask-item');
                    if (!item) return;

                    if (e.target.closest('.edit-subtask-btn')) {
                        e.stopPropagation();
                        const subtaskId = item.getAttribute('data-subtask-id');
                        const subtask = findSubtask(subtaskId);
                        if (subtask) openSubtaskForm('edit', subtask.id, subtask.title, subtask.work_date, subtask.description);
                    } else if (e.target.closest('.delete-subtask-btn')) {
                        e.stopPropagation();
                        const subtaskId = item.getAttribute('data-subtask-id');
                        const subtask = findSubtask(subtaskId);
                        if (subtask) openConfirmationModal('subtask', subtask.title, () => deleteSubtask(subtaskId));
                    } else {
                        selectSubtask(item);
                    }
                });
            }
            
            // Comment buttons
            if (addCommentBtn) addCommentBtn.addEventListener('click', () => openCommentForm('add'));
            if (cancelCommentBtn) cancelCommentBtn.addEventListener('click', resetCommentForm);
            if (saveCommentBtn) saveCommentBtn.addEventListener('click', saveComment);
            
            // Comments list event delegation
            const commentsList = document.getElementById('comments-list');
            if (commentsList) {
                commentsList.addEventListener('click', (e) => {
                    const item = e.target.closest('.comment-item');
                    if (!item) return;

                    if (e.target.closest('.edit-comment-btn')) {
                        const commentId = item.getAttribute('data-comment-id');
                        const comment = findComment(commentId);
                        if (comment) openCommentForm('edit', comment.id, comment.comment);
                    } else if (e.target.closest('.delete-comment-btn')) {
                        const commentId = item.getAttribute('data-comment-id');
                        openConfirmationModal('comment', 'this comment', () => deleteComment(commentId));
                    }
                });
            }

            // Back to subtasks button
            const backToSubtasksBtnEl = document.getElementById('back-to-subtasks-btn');
            if (backToSubtasksBtnEl) {
                backToSubtasksBtnEl.addEventListener('click', () => {
                    if (subtaskDetailView) subtaskDetailView.classList.add('hidden');
                    if (subtasksList) subtasksList.classList.remove('hidden');
                    currentSubtaskId = null;
                });
            }

            // Time Log Events
            if (addTimeLogBtn) addTimeLogBtn.addEventListener('click', () => openTimeLogForm('add'));
            if (cancelTimeLogBtn) cancelTimeLogBtn.addEventListener('click', resetTimeLogForm);
            if (saveTimeLogBtn) saveTimeLogBtn.addEventListener('click', saveTimeLog);
            if (updateTimeLogBtn) updateTimeLogBtn.addEventListener('click', updateTimeLog);

            // User Management (Dashboard Listeners)

            // New User Management Dashboard Listeners
            const userDashSearch = document.getElementById('user-dashboard-search');
            if (userDashSearch) {
                userDashSearch.addEventListener('input', (e) => {
                    userDashboardSearchTerm = e.target.value.toLowerCase();
                    applyUserDashboardFilters();
                });
            }

            // Button listeners removed for All Client Overview

            const manageUsersBtn = document.getElementById('sidebar-manage-users-btn');
            if (manageUsersBtn) {
                manageUsersBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    switchView('user-management');
                });
            }

            const dashAddUserBtn = document.getElementById('dashboard-add-user-btn');
            if (dashAddUserBtn) {
                dashAddUserBtn.addEventListener('click', () => openAdminUserModal('add'));
            }

            const dashUserForm = document.getElementById('dashboard-user-form');
            if (dashUserForm) {
                dashUserForm.addEventListener('submit', handleDashboardUserFormSubmit);
            }

            setupKeyboardShortcuts();
            setupGlobalKeyboardShortcuts();
        }

        function setupKeyboardShortcuts() {
            // Main Task Form
            if (mainTaskTitle) {
                mainTaskTitle.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        const catBtn = document.getElementById('category-dropdown-btn');
                        if (catBtn) catBtn.click();
                    }
                });
            }
            if (mainTaskDescription) {
                mainTaskDescription.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter' && e.ctrlKey) {
                        e.preventDefault();
                        if (updateMainTaskBtn && !updateMainTaskBtn.classList.contains('hidden')) {
                            updateMainTask();
                        } else {
                            saveMainTask();
                        }
                    }
                });
            }

            // Subtask Form
            if (subtaskTitle) {
                subtaskTitle.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        if (subtaskWorkDate) subtaskWorkDate.focus();
                    }
                });
            }
            if (subtaskWorkDate) {
                subtaskWorkDate.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        if (subtaskDescription) subtaskDescription.focus();
                    }
                });
            }
            if (subtaskDescription) {
                subtaskDescription.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter' && e.ctrlKey) {
                        e.preventDefault();
                        if (updateSubtaskBtn && !updateSubtaskBtn.classList.contains('hidden')) {
                            updateSubtask();
                        } else {
                            saveSubtask();
                        }
                    }
                });
            }

            // Comment Form
            if (commentText) {
                commentText.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter' && e.ctrlKey) {
                        e.preventDefault();
                        saveComment();
                    }
                });
            }

            // Time Log Form
            if (timeLogValue) {
                timeLogValue.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        if (updateTimeLogBtn && !updateTimeLogBtn.classList.contains('hidden')) {
                            updateTimeLog();
                        } else {
                            saveTimeLog();
                        }
                    }
                });
            }

            // Client Modal Form - Global Enter Key Handler
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' && e.target.id === 'client-name') {
                    e.preventDefault();
                    e.stopPropagation(); // Stop bubbling
                    
                    // Determine which button to click
                    if (editingClientId) {
                        const btn = document.getElementById('update-client-btn');
                        if (btn && !btn.disabled) btn.click();
                    } else {
                        const btn = document.getElementById('save-client-btn');
                        if (btn && !btn.disabled) btn.click();
                    }
                }
            });
            
            // Client Modal Form (Legacy removal, can be kept empty or removed)
        }
        
        // Setup global keyboard shortcuts for quick actions
        function setupGlobalKeyboardShortcuts() {
            document.addEventListener('keydown', (e) => {
                // Ignore if user is typing in input/textarea (except for Escape key)
                if (['INPUT', 'TEXTAREA'].includes(e.target.tagName) && e.key !== 'Escape') {
                    return;
                }
                
                // Single key shortcuts (when not in input)
                if (!e.ctrlKey && !e.metaKey && !e.altKey) {
                    switch(e.key.toLowerCase()) {
                        case 'n':
                            // N - New Client
                            e.preventDefault();
                            if (clientModal && !clientModal.classList.contains('hidden')) {
                                closeClientModalFunc();
                            } else {
                                if (addClientBtn) addClientBtn.click();
                            }
                            break;
                        case 't':
                            // T - Add Main Task (when client selected)
                            if (currentClientId) {
                                e.preventDefault();
                                if (mainTaskForm && !mainTaskForm.classList.contains('hidden')) {
                                    resetMainTaskForm();
                                } else {
                                    const addMainTaskBtn = document.getElementById('add-main-task-btn');
                                    if (addMainTaskBtn) addMainTaskBtn.click();
                                }
                            } else {
                                // Show feedback if no client selected
                                e.preventDefault();
                                showErrorNotification('Please select a client to add tasks');
                            }
                            break;
                        case 's':
                            // S - Add Subtask (when main task selected)
                            if (currentMainTaskId) {
                                e.preventDefault();
                                const addSubtaskBtn = document.getElementById('add-subtask-btn');
                                if (addSubtaskBtn && !addSubtaskBtn.disabled) addSubtaskBtn.click();
                            }
                            break;
                        case 'escape':
                            // Escape - Close active forms/modals
                            e.preventDefault();
                            closeActiveModals();
                            break;
                        case '/':
                            // / - Focus search
                            e.preventDefault();
                            if (clientSearch) {
                                clientSearch.focus();
                                clientSearch.select();
                            }
                            break;
                    }
                }
                
                // Ctrl/Cmd + key shortcuts
                if ((e.ctrlKey || e.metaKey) && !e.altKey && !e.shiftKey) {
                    switch(e.key.toLowerCase()) {
                        case 'b':
                            // Ctrl+B - Toggle Sidebar
                            e.preventDefault();
                            if (toggleSidebarBtn) toggleSidebarBtn.click();
                            break;
                        case 'd':
                            // Ctrl+D - Toggle Dark Mode
                            e.preventDefault();
                            toggleDarkMode();
                            break;
                    }
                }
            });
        }
        
        // Helper function to close active modals/forms
        function closeActiveModals() {
            // Close client modal
            if (clientModal && !clientModal.classList.contains('hidden')) {
                resetClientForm();
            }
            // Close profile modal
            if (profileModal && !profileModal.classList.contains('hidden')) {
                if (closeProfileModal) closeProfileModal.click();
            }
            // Close confirmation modal
            if (confirmationModal && !confirmationModal.classList.contains('hidden')) {
                if (cancelConfirmationBtn) cancelConfirmationBtn.click();
            }
            // Close main task form
            const mainTaskForm = document.getElementById('main-task-form');
            if (mainTaskForm && !mainTaskForm.classList.contains('hidden')) {
                resetMainTaskForm();
            }
            // Close subtask form
            const subtaskForm = document.getElementById('subtask-form');
            if (subtaskForm && !subtaskForm.classList.contains('hidden')) {
                resetSubtaskForm();
            }
            // Close user dropdown
            if (userDropdown && !userDropdown.classList.contains('hidden')) {
                userDropdown.classList.add('hidden');
            }
        }
        
        // Theme functionality
        function toggleDarkMode() {
            if (document.documentElement.classList.contains('dark')) {
                disableDarkMode();
                localStorage.setItem('theme', 'light');
            } else {
                enableDarkMode();
                localStorage.setItem('theme', 'dark');
            }
        }
        
        function enableDarkMode() {
            document.documentElement.classList.add('dark');
            themeIcon.classList.remove('fa-moon');
            themeIcon.classList.add('fa-sun');
        }
        
        function disableDarkMode() {
            document.documentElement.classList.remove('dark');
            themeIcon.classList.remove('fa-sun');
            themeIcon.classList.add('fa-moon');
        }
        
        // User dropdown functionality
        function toggleUserDropdown() {
            userDropdown.classList.toggle('hidden');
        }
        
        function toggleMobileMenu() {
            sidebar.classList.toggle('-translate-x-full');
            sidebarOverlay.classList.toggle('hidden');
            document.body.classList.toggle('overflow-hidden');
        }
        
        function closeMobileMenu() {
            sidebar.classList.add('-translate-x-full');
            sidebarOverlay.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        // User Management Dashboard Specifics
        function switchView(viewName) {
            const views = {
                'statistics': document.getElementById('statistics-dashboard'),
                'client': document.getElementById('client-content'),
                'user-management': document.getElementById('user-management-dashboard')
            };

            const breadcrumb = document.getElementById('breadcrumb-nav');
            
            // Hide all views
            Object.values(views).forEach(v => {
                if (v) v.classList.add('hidden');
            });

            // Show target view
            if (views[viewName]) {
                views[viewName].classList.remove('hidden');
                views[viewName].classList.add('animate-fadeIn');
            }

            // Breadcrumb visibility
            if (breadcrumb) {
                if (viewName === 'client') breadcrumb.classList.remove('hidden');
                else breadcrumb.classList.add('hidden');
            }

            // Update Sidebar Highlight
            const sidebarLinks = document.querySelectorAll('.sidebar-nav-item');
            sidebarLinks.forEach(link => {
                link.classList.remove('active');
            });

            if (viewName === 'statistics') {
                loadStatistics();
            } else if (viewName === 'user-management') {
                const btn = document.getElementById('sidebar-manage-users-btn');
                if (btn) btn.classList.add('active');
                loadUserDashboardData();
            }

            // Scroll to top
            const mainContent = document.getElementById('main-content');
            if (mainContent) mainContent.scrollTop = 0;
        }

        async function loadUserDashboardData() {
            try {
                const response = await apiCall('{{ route('admin.users.index') }}');
                if (response && response.users) {
                    window.App.users = response.users;
                } else if (response && Array.isArray(response)) {
                    window.App.users = response;
                }
                applyUserDashboardFilters();
            } catch (error) {
                console.error('Failed to load users:', error);
            }
        }

        function switchUserDashboardTab(tabName) {
            userDashboardFilter = tabName;
            
            // Update UI
            const tabs = document.querySelectorAll('.user-dashboard-tab');
            tabs.forEach(tab => {
                const indicator = tab.querySelector('div.absolute');
                if (tab.id === `user-tab-${tabName}`) {
                    tab.classList.remove('text-gray-400', 'dark:text-gray-500');
                    tab.classList.add('text-indigo-600', 'dark:text-indigo-400');
                    if (indicator) {
                        indicator.classList.remove('bg-transparent');
                        indicator.classList.add('bg-indigo-600', 'dark:bg-indigo-500');
                    }
                } else {
                    tab.classList.add('text-gray-400', 'dark:text-gray-500');
                    tab.classList.remove('text-indigo-600', 'dark:text-indigo-400');
                    if (indicator) {
                        indicator.classList.add('bg-transparent');
                        indicator.classList.remove('bg-indigo-600', 'dark:bg-indigo-500');
                    }
                }
            });
            
            applyUserDashboardFilters();
        }

        function applyUserDashboardFilters() {
            if (!window.App.users) return;

            const filtered = window.App.users.filter(user => {
                const matchesTab = userDashboardFilter === 'active' ? user.status === 'active' : user.status !== 'active';
                const matchesSearch = (user.name || '').toLowerCase().includes(userDashboardSearchTerm) || 
                                     (user.email || '').toLowerCase().includes(userDashboardSearchTerm);
                return matchesTab && matchesSearch;
            });

            renderUsersDashboardTable(filtered);
            
            const activeCount = window.App.users.filter(u => u.status === 'active').length;
            const deactivatedCount = window.App.users.length - activeCount;
            
            const activeEl = document.getElementById('active-user-count');
            const deactiveEl = document.getElementById('deactivated-user-count');
            if (activeEl) activeEl.textContent = activeCount;
            if (deactiveEl) deactiveEl.textContent = deactivatedCount;
        }

        function renderUsersDashboardTable(users) {
            const tbody = document.getElementById('user-dashboard-table-body');
            const emptyState = document.getElementById('user-dashboard-empty');
            if (!tbody) return;

            if (users.length === 0) {
                tbody.innerHTML = '';
                if (emptyState) emptyState.classList.remove('hidden');
                return;
            }

            if (emptyState) emptyState.classList.add('hidden');
            tbody.innerHTML = users.map(user => {
                const initials = user.name.split(' ').map(n => n[0]).join('').toUpperCase().substring(0, 2);
                return `
                    <tr class="group hover:bg-gray-50/50 dark:hover:bg-gray-900/30 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-xs font-bold shadow-sm whitespace-nowrap">
                                    ${initials}
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-bold text-gray-900 dark:text-white truncate">${user.name}</p>
                                    <p class="text-[11px] text-gray-500 dark:text-gray-400 truncate">${user.email}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider
                                ${user.role === 'super_admin' 
                                    ? 'bg-purple-100 text-purple-700 dark:bg-purple-900/40 dark:text-purple-300 border border-purple-200 dark:border-purple-800' 
                                    : 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300 border border-blue-200 dark:border-blue-800'}">
                                ${user.role === 'super_admin' ? 'Super Admin' : 'Developer'}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <div class="w-2 h-2 rounded-full ${user.status === 'active' ? 'bg-emerald-500 animate-pulse' : 'bg-gray-400'}"></div>
                                <span class="text-xs font-medium ${user.status === 'active' ? 'text-emerald-600 dark:text-emerald-400' : 'text-gray-500 dark:text-gray-400'}">
                                    ${user.status === 'active' ? 'Active' : 'Offline'}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-xs text-gray-600 dark:text-gray-400">
                                ${new Date(user.created_at).toLocaleDateString()}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                 ${user.id !== window.App.user.id ? `
                                    <button onclick="openAssignTaskModal(${user.id}, '${user.name.replace(/'/g, "\\'")}')" class="p-2 text-gray-400 hover:text-emerald-500 transition-colors" title="Assign Task">
                                        <i class="fas fa-plus-circle text-xs"></i>
                                    </button>
                                    <button onclick="openUserTaskHistory(${user.id}, '${user.name.replace(/'/g, "\\'")}')" class="p-2 text-gray-400 hover:text-blue-500 transition-colors" title="Manage Tasks">
                                        <i class="fas fa-tasks text-xs"></i>
                                    </button>
                                    <button onclick="confirmResetPassword(${user.id}, '${user.name}')" class="p-2 text-gray-400 hover:text-amber-500 transition-colors" title="Forgot Password">
                                        <i class="fas fa-user-lock text-xs"></i>
                                    </button>
                                    <button onclick="openAdminUserModal('edit', ${user.id})" class="p-2 text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors" title="Edit User">
                                        <i class="fas fa-edit text-xs"></i>
                                    </button>
                                    <button onclick="confirmDeleteUser(${user.id}, '${user.name}')" class="p-2 text-gray-400 hover:text-red-500 transition-colors" title="Delete User">
                                        <i class="fas fa-trash-alt text-xs"></i>
                                    </button>
                                ` : '<span class="text-xs text-gray-400 italic px-2">Current User</span>'}
                            </div>
                        </td>
                    </tr>
                `;
            }).join('');
        }

        // Dashboard User Form Handlers
        let editingDashboardUserId = null;

        function openAdminUserModal(mode, userId = null) {
            const modal = document.getElementById('admin-user-modal');
            const title = document.getElementById('admin-user-modal-title');
            const saveBtn = document.getElementById('db-save-user-btn');
            const updateBtn = document.getElementById('db-update-user-btn');
            const statusContainer = document.getElementById('db-user-status-container');
            const passwordDisplay = document.getElementById('db-password-display');
            const form = document.getElementById('dashboard-user-form');
            if (!modal) return;
            
            form.reset();
            passwordDisplay.classList.add('hidden');
            
            if (mode === 'add') {
                title.textContent = 'Create New User';
                saveBtn.classList.remove('hidden');
                updateBtn.classList.add('hidden');
                statusContainer.classList.add('hidden');
                editingDashboardUserId = null;
            } else {
                const user = window.App.users.find(u => u.id == userId);
                if (!user) return;
                
                title.textContent = 'Edit User Profile';
                saveBtn.classList.add('hidden');
                updateBtn.classList.remove('hidden');
                statusContainer.classList.remove('hidden');
                
                document.getElementById('db-user-name').value = user.name;
                document.getElementById('db-user-email').value = user.email;
                document.getElementById('db-user-role').value = user.role;
                document.getElementById('db-user-status').value = user.status;
                
                editingDashboardUserId = userId;
            }
            
            modal.classList.remove('hidden');
            modal.querySelector('input').focus();
        }

        function closeAdminUserModal() {
            const modal = document.getElementById('admin-user-modal');
            if (modal) modal.classList.add('hidden');
            editingDashboardUserId = null;
        }

        async function handleDashboardUserFormSubmit(e) {
            e.preventDefault();
            
            const data = {
                name: document.getElementById('db-user-name').value,
                email: document.getElementById('db-user-email').value,
                role: document.getElementById('db-user-role').value,
                status: document.getElementById('db-user-status').value,
            };

            const saveBtn = document.getElementById('db-save-user-btn');

            try {
                if (editingDashboardUserId) {
                    const response = await apiCall(`/dashboard/users/${editingDashboardUserId}`, 'PUT', data);
                    if (response.success) {
                        showSuccessNotification(response.message);
                        closeAdminUserModal();
                        await loadUserDashboardData();
                    }
                } else {
                    saveBtn.disabled = true;
                    const response = await apiCall('/dashboard/users', 'POST', data);
                    if (response.success) {
                        showSuccessNotification(response.message);
                        document.getElementById('db-generated-password').value = response.generated_password;
                        document.getElementById('db-password-display').classList.remove('hidden');
                        saveBtn.classList.add('hidden');
                        await loadUserDashboardData();
                    }
                }
            } catch (error) {
                console.error('User action failed:', error);
            } finally {
                if (saveBtn) saveBtn.disabled = false;
            }
        }

        window.confirmDeleteUser = function(userId, name) {
            openConfirmationModal('user', name, () => deleteUser(userId));
        };

        window.confirmResetPassword = function(userId, name) {
            openConfirmationModal('reset-password', name, () => resetUserPassword(userId));
        };

        async function resetUserPassword(userId) {
            try {
                const url = '{{ route('admin.users.reset-password', ['user' => ':id']) }}'.replace(':id', userId);
                const response = await apiCall(url, 'POST');
                
                if (response.success) {
                    closeConfirmationModal();
                    
                    const successModal = document.getElementById('password-reset-success-modal');
                    const passInput = document.getElementById('reset-success-password-input');
                    
                    if (successModal && passInput) {
                        passInput.value = response.generated_password;
                        successModal.classList.remove('hidden');
                    }
                    
                    showSuccessNotification(response.message);
                }
            } catch (error) {
                console.error('Password reset failed:', error);
            }
        }

        window.copyResetPassword = function() {
            const passInput = document.getElementById('reset-success-password-input');
            if (passInput) {
                passInput.select();
                document.execCommand('copy');
                showSuccessNotification('Password copied to clipboard!');
            }
        };

        window.closePasswordResetSuccessModal = function() {
            const modal = document.getElementById('password-reset-success-modal');
            if (modal) modal.classList.add('hidden');
        };

        const closeResetSuccessBtn = document.getElementById('close-reset-success-btn-final');
        if (closeResetSuccessBtn) {
            closeResetSuccessBtn.onclick = window.closePasswordResetSuccessModal;
        }

        const copyResetBtn = document.getElementById('copy-reset-btn');
        if (copyResetBtn) {
            copyResetBtn.addEventListener('click', () => {
                const passInput = document.getElementById('reset-success-password-input');
                if (!passInput || !passInput.value) return;

                const text = passInput.value;

                if (navigator.clipboard && navigator.clipboard.writeText) {
                    navigator.clipboard.writeText(text).then(() => {
                        showSuccessNotification('Password copied to clipboard!');
                        copyResetBtn.innerHTML = '<i class="fas fa-check text-emerald-500"></i>';
                        setTimeout(() => {
                            copyResetBtn.innerHTML = '<i class="fas fa-copy"></i>';
                        }, 2000);
                    }).catch(() => {
                        // fallback
                        passInput.select();
                        document.execCommand('copy');
                        showSuccessNotification('Password copied!');
                    });
                } else {
                    passInput.select();
                    document.execCommand('copy');
                    showSuccessNotification('Password copied!');
                }
            });
        }

        async function deleteUser(userId) {
            try {
                const response = await apiCall(`/dashboard/users/${userId}`, 'DELETE');
                if (response.success) {
                    showSuccessNotification(response.message);
                    closeConfirmationModal();
                    await loadUserDashboardData();
                }
            } catch (error) {
                console.error('Delete user failed:', error);
            }
        }

        window.copyDBPassword = function() {
            const passField = document.getElementById('db-generated-password');
            if (passField) {
                passField.select();
                document.execCommand('copy');
                showSuccessNotification('Password copied to clipboard!');
            }
        }

        window.closeAdminUserModal = closeAdminUserModal;
        window.switchUserDashboardTab = switchUserDashboardTab;
        window.switchView = switchView;
        // End User Management Dashboard Specifics
        
        // Client functionality
        async function selectClient(clientItem) {
            const clientId = clientItem.getAttribute('data-client-id');
            
            // Switch view first for smoother feel
            switchView('client');

            if (clientId == currentClientId) {
                return;
            }

            // Update UI instantly for feedback
            const items = document.querySelectorAll('.client-item');
            items.forEach(item => {
                item.classList.remove('bg-blue-50', 'dark:bg-blue-900/20', 'border-blue-200', 'dark:border-blue-800');
                item.classList.add('bg-white', 'dark:bg-gray-800', 'border-gray-200', 'dark:border-gray-700');
            });
            clientItem.classList.remove('bg-white', 'dark:bg-gray-800', 'border-gray-200', 'dark:border-gray-700');
            clientItem.classList.add('bg-blue-50', 'dark:bg-blue-900/20', 'border-blue-200', 'dark:border-blue-800');
            
            currentClientId = clientId;
            
            // Close mobile menu if open
            if (window.innerWidth < 768) {
                closeMobileMenu();
            }
            
            // Load client data
            try {
                const client = window.App.clients.find(c => c.id == clientId);
                if (client) {
                    selectedClientName.textContent = client.name;
                    
                    renderMainTasks(client.main_tasks || []);
                    
                    const joinDate = new Date(client.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                    document.getElementById('client-join-date').textContent = joinDate;
                    
                    document.getElementById('breadcrumb-client-name').innerHTML = `
                        <a href="#" onclick="showClientContent()" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">${client.name}</a>
                    `;
                    
                    showClientContent();
                    resetMainTaskForm();
                    resetMainTaskSelection();

                    if (window.innerWidth < 768) {
                        document.getElementById('client-content').scrollIntoView({ behavior: 'smooth' });
                    }
                }
            } catch (error) {
                showErrorNotification("Failed to load client details");
            }
        }
        
        function renderMainTasks(tasks) {
            const list = document.getElementById('main-tasks-list');
            if (tasks.length === 0) {
                list.innerHTML = `
                    <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                        <i class="fas fa-info-circle mb-2"></i>
                        <p>No main tasks found for this client.</p>
                    </div>`;
                return;
            }
            
            list.innerHTML = tasks.map(task => {
                const isActive = task.id == currentMainTaskId;
                return `
                <div class="main-task-item p-4 border rounded-lg cursor-pointer transition-all duration-200 
                    ${isActive 
                        ? 'bg-blue-50 dark:bg-blue-900/25 border-blue-300 dark:border-blue-700 shadow-sm' 
                        : 'bg-white dark:bg-gray-800/60 border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50'}" 
                    data-task-id="${task.id}">
                    <div class="flex items-start justify-between">
                        <div class="flex items-start space-x-3">
                            <div class="w-10 h-10 ${isActive ? 'bg-blue-600 text-white' : 'bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400'} rounded-lg flex items-center justify-center shrink-0 mt-0.5 transition-colors">
                                <i class="fas fa-project-diagram"></i>
                            </div>
                            <div>
                                <h5 class="font-bold flex flex-wrap items-center gap-2 mb-0.5 ${isActive ? 'text-blue-800 dark:text-white' : 'text-gray-800 dark:text-white'}">
                                    <span class="break-words">${task.title}</span>
                                    ${task.category ? `<span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800 whitespace-nowrap">${task.category.name}</span>` : ''}
                                </h5>
                                <p class="text-sm line-clamp-1 ${isActive ? 'text-blue-600/80 dark:text-blue-300/80' : 'text-gray-600 dark:text-gray-200'}">${task.description || 'No description'}</p>
                                <div class="mt-1.5 flex items-center text-xs ${isActive ? 'text-blue-500 font-bold' : 'text-blue-600 dark:text-blue-400'}">
                                    <i class="fas fa-user-circle mr-1.5 text-[10px]"></i>
                                    <span>Created by: ${task.user_id == window.App.user.id ? 'You' : (task.user ? task.user.name : 'Unknown')}</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col sm:flex-row items-center gap-2 shrink-0 ml-2">
                            ${(window.App.user.role === 'super_admin' || task.user_id == window.App.user.id) ? `
                                <button class="edit-main-task-btn ${isActive ? 'text-blue-700 hover:text-blue-900' : 'text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300'} p-1">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="delete-main-task-btn text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 p-1">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            ` : ''}
                        </div>
                    </div>
                </div>
            `;}).join('');
        }

        function switchView(viewName) {
            const views = {
                'statistics': document.getElementById('statistics-dashboard'),
                'client': document.getElementById('client-content'),
                'user-management': document.getElementById('user-management-dashboard'),
                'reports': document.getElementById('reports-section'),
                'developer-tasks': document.getElementById('assigned-tasks-dashboard')
            };

            const breadcrumb = document.getElementById('breadcrumb-nav');

            // Hide all views
            Object.values(views).forEach(view => {
                if (view) view.classList.add('hidden');
            });

            // Show selected view
            const activeView = views[viewName];
            if (activeView) activeView.classList.remove('hidden');

            // Handle breadcrumb visibility
            if (breadcrumb) {
                if (viewName === 'client') {
                    breadcrumb.classList.remove('hidden');
                } else {
                    breadcrumb.classList.add('hidden');
                }
            }

            // Update sidebar active states
            const manageUsersBtn = document.getElementById('sidebar-manage-users-btn');
            const reportsBtn = document.getElementById('sidebar-activity-reports-btn');
            const assignedTasksBtn = document.getElementById('sidebar-assigned-tasks-btn');

            if (manageUsersBtn) manageUsersBtn.classList.toggle('active', viewName === 'user-management');
            if (reportsBtn) reportsBtn.classList.toggle('active', viewName === 'reports');
            if (assignedTasksBtn) assignedTasksBtn.classList.toggle('active', viewName === 'developer-tasks');

            // Sync data on view switch
            if (viewName === 'statistics') {
                loadStatistics();
            } else if (viewName === 'user-management') {
                loadUserDashboardData();
            } else if (viewName === 'reports') {
                loadReportsData(1);
            } else if (viewName === 'developer-tasks') {
                loadInitialDeveloperTasks();
            }
        }

        function showClientSelectionPrompt() {
            switchView('statistics');
        }

        function showClientContent() {
            switchView('client');
        }

        function filterClients() {
            const searchTerm = clientSearch.value.toLowerCase();
            let visibleCount = 0;
            
            const items = document.querySelectorAll('.client-item');
            items.forEach(item => {
                const nameEl = item.querySelector('p.text-sm');
                const clientName = nameEl ? nameEl.textContent.toLowerCase() : '';
                if (clientName.includes(searchTerm)) {
                    item.classList.remove('hidden');
                    visibleCount++;
                } else {
                    item.classList.add('hidden');
                }
            });
            
            const noClientsMessage = document.getElementById('no-clients-message');
            if (visibleCount === 0 && searchTerm !== '') {
                noClientsMessage.classList.remove('hidden');
            } else {
                noClientsMessage.classList.add('hidden');
            }
        }
        
        function openClientModal(mode, clientId = null, clientName = '') {
            // Reset checkboxes
            const checkboxes = document.querySelectorAll('.user-assignment-checkbox');
            checkboxes.forEach(cb => cb.checked = false);

            if (mode === 'add') {
                clientModalTitle.textContent = 'Add New Client';
                saveClientBtn.classList.remove('hidden');
                updateClientBtn.classList.add('hidden');
                document.getElementById('client-name').value = '';
                editingClientId = null;
            } else if (mode === 'edit') {
                clientModalTitle.textContent = 'Edit Client';
                saveClientBtn.classList.add('hidden');
                updateClientBtn.classList.remove('hidden');
                document.getElementById('client-name').value = clientName;
                editingClientId = clientId;

                // Pre-select assigned users
                const client = window.App.clients.find(c => c.id == clientId);
                if (client && client.users) {
                    const assignedUserIds = client.users.map(u => u.id);
                    checkboxes.forEach(cb => {
                        if (assignedUserIds.includes(parseInt(cb.value))) {
                            cb.checked = true;
                        }
                    });
                }
            }
            clientModal.classList.remove('hidden');
            if (saveClientBtn) saveClientBtn.disabled = false;
            if (updateClientBtn) updateClientBtn.disabled = false;
            isSubmittingClient = false;
            setTimeout(() => {
                const nameInput = document.getElementById('client-name');
                if (nameInput) nameInput.focus();
            }, 50);
        }
        
        function closeClientModalFunc() {
            clientModal.classList.add('hidden');
        }
        
        async function handleClientFormSubmit(e) {
            e.preventDefault();
            
            if (isSubmittingClient) return;
            
            const name = document.getElementById('client-name').value;
            const status = 'active';
            
            // Collect user assignments if present
            const selectedUserIds = Array.from(document.querySelectorAll('.user-assignment-checkbox:checked')).map(cb => cb.value);
            
            isSubmittingClient = true;
            if (saveClientBtn) saveClientBtn.disabled = true;
            if (updateClientBtn) updateClientBtn.disabled = true;
            
            try {
                const payload = { name, status, user_ids: selectedUserIds };
                
                if (!editingClientId) {
                    const result = await apiCall('{{ route('dashboard.clients.store') }}', 'POST', payload);
                    if (result.client) {
                        window.App.clients.push(result.client);
                        showSuccessNotification(result.message);
                        renderClientsList();
                    }
                } else {
                    const url = '{{ route('dashboard.clients.update', ['client' => ':id']) }}'.replace(':id', editingClientId);
                    const result = await apiCall(url, 'PUT', payload);
                    const index = window.App.clients.findIndex(c => c.id == editingClientId);
                    if (index !== -1) {
                        window.App.clients[index] = { ...window.App.clients[index], ...result.client };
                    }
                    showSuccessNotification(result.message);
                    renderClientsList();
                    loadStatistics(); // Refresh dashboard cards
                    if (selectedClientName && currentClientId == editingClientId) {
                        selectedClientName.textContent = name;
                    }
                }
                closeClientModalFunc();
            } catch (error) {
                console.error('Client form submit error:', error);
            } finally {
                isSubmittingClient = false;
                if (saveClientBtn) saveClientBtn.disabled = false;
                if (updateClientBtn) updateClientBtn.disabled = false;
            }
        }

        async function deleteCurrentClient() {
            if (!currentClientId) return;
            
            try {
                const url = '{{ route('dashboard.clients.destroy', ['client' => ':id']) }}'.replace(':id', currentClientId);
                const result = await apiCall(url, 'DELETE');
                window.App.clients = window.App.clients.filter(c => c.id != currentClientId);
                
                showSuccessNotification(result.message);
                renderClientsList();
                
                currentClientId = null;
                showClientSelectionPrompt();
                closeConfirmationModal();
            } catch (error) {}
        }
        
        const clientAvatarColors = [
            'from-emerald-400 to-teal-500',
            'from-violet-400 to-purple-600',
            'from-blue-400 to-indigo-600',
            'from-rose-400 to-pink-600',
            'from-amber-400 to-orange-500',
            'from-cyan-400 to-sky-600',
        ];

        function renderClientsList() {
            const container = document.getElementById('clients-list-container');
            const noClientsMsg = document.getElementById('no-clients-message');
            if (!container) return;

            if (!window.App.clients || window.App.clients.length === 0) {
                container.innerHTML = '';
                if (noClientsMsg) noClientsMsg.classList.remove('hidden');
                return;
            }

            if (noClientsMsg) noClientsMsg.classList.add('hidden');
            
            container.innerHTML = window.App.clients.map(client => {
                const initials = getInitials(client.name);
                const color = clientAvatarColors[client.id % clientAvatarColors.length];
                const isActive = currentClientId == client.id;
                return `
                    <div class="client-item group relative flex items-center gap-3 px-3 py-3 rounded-xl border cursor-pointer transition-all duration-200 overflow-hidden
                        ${isActive
                            ? 'bg-blue-50 dark:bg-blue-900/25 border-blue-300 dark:border-blue-700 shadow-sm'
                            : 'bg-white dark:bg-gray-800/60 border-gray-200 dark:border-gray-700/60 hover:bg-gray-50 dark:hover:bg-gray-700/60 hover:border-gray-300 dark:hover:border-gray-600 hover:shadow-sm'}"
                        data-client-id="${client.id}" title="${client.name}">
                        ${isActive ? '<div class="absolute left-0 top-2 bottom-2 w-1 bg-blue-500 dark:bg-blue-400 rounded-r-full"></div>' : ''}
                        <div class="relative shrink-0">
                            <div class="w-9 h-9 rounded-xl bg-gradient-to-br ${color} flex items-center justify-center text-white text-xs font-bold shadow-md">
                                ${initials}
                            </div>
                            ${isActive ? '<span class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 bg-emerald-400 border-2 border-white dark:border-gray-800 rounded-full"></span>' : ''}
                        </div>
                        <div class="sidebar-hide-content min-w-0 flex-1">
                            <p class="text-sm font-semibold truncate ${isActive ? 'text-blue-700 dark:text-blue-300' : 'text-gray-800 dark:text-gray-100'}">
                                ${client.name}
                            </p>
                            <p class="text-xs text-gray-400 dark:text-gray-500 truncate">Client</p>
                        </div>
                        <div class="sidebar-hide-content shrink-0 opacity-0 group-hover:opacity-100 transition-opacity duration-150">
                            <i class="fas fa-chevron-right text-[10px] text-gray-400 dark:text-gray-500"></i>
                        </div>
                    </div>
                `;
            }).join('');
        }
        
        function openMainTaskForm(mode, taskId = null, title = '', description = '', categoryId = null) {
            // Setup Custom Dropdown Logic
            setupCategoryDropdown();

            if (mode === 'add') {
                mainTaskTitle.value = '';
                mainTaskDescription.value = '';
                if (document.getElementById('main-task-category')) document.getElementById('main-task-category').value = '';
                if (document.getElementById('category-dropdown-text')) document.getElementById('category-dropdown-text').textContent = 'Select Category';
                if (document.getElementById('category-dropdown-text')) document.getElementById('category-dropdown-text').classList.add('text-gray-500', 'dark:text-gray-400');
                if (document.getElementById('category-dropdown-text')) document.getElementById('category-dropdown-text').classList.remove('text-gray-800', 'dark:text-white');
                saveMainTaskBtn.classList.remove('hidden');
                updateMainTaskBtn.classList.add('hidden');
                document.getElementById('main-task-id-display').textContent = 'New Task';
                
                isSubmittingMainTask = false;
                if (saveMainTaskBtn) saveMainTaskBtn.disabled = false;
                if (updateMainTaskBtn) updateMainTaskBtn.disabled = false;
            } else if (mode === 'edit') {
                mainTaskTitle.value = title;
                mainTaskDescription.value = description;
                if (document.getElementById('main-task-category')) {
                    document.getElementById('main-task-category').value = categoryId || '';
                    if (categoryId && window.App.categories) {
                        const cat = window.App.categories.find(c => c.id == categoryId);
                        if (cat) {
                            const textEl = document.getElementById('category-dropdown-text');
                            textEl.textContent = cat.name;
                            textEl.classList.remove('text-gray-500', 'dark:text-gray-400');
                            textEl.classList.add('text-gray-800', 'dark:text-white');
                        }
                    }
                }
                saveMainTaskBtn.classList.add('hidden');
                updateMainTaskBtn.classList.remove('hidden');
                document.getElementById('main-task-id-display').textContent = `Task ID: ${taskId}`;
                currentMainTaskId = taskId;
            }
            mainTaskForm.classList.remove('hidden');
            addMainTaskBtn.innerHTML = '<i class="fas fa-eye-slash text-sm"></i><span class="max-w-0 overflow-hidden group-hover:max-w-xs transition-all duration-300 ease-in-out opacity-0 group-hover:opacity-100 whitespace-nowrap text-xs md:text-sm font-medium pl-0 group-hover:pl-2">Hide</span>';
            addMainTaskBtn.classList.replace('bg-blue-600', 'bg-gray-500');
            addMainTaskBtn.classList.replace('hover:bg-blue-700', 'hover:bg-gray-600');
            
            setTimeout(() => {
                if (mainTaskTitle) mainTaskTitle.focus();
            }, 50);
        }
        
        function resetMainTaskForm() {
            mainTaskForm.classList.add('hidden');
            mainTaskTitle.value = '';
            mainTaskDescription.value = '';
            addMainTaskBtn.innerHTML = '<i class="fas fa-plus text-sm"></i><span class="max-w-0 overflow-hidden group-hover:max-w-xs transition-all duration-300 ease-in-out opacity-0 group-hover:opacity-100 whitespace-nowrap text-xs md:text-sm font-medium pl-0 group-hover:pl-2">Add Task</span>';
            addMainTaskBtn.classList.replace('bg-gray-500', 'bg-blue-600');
            addMainTaskBtn.classList.replace('hover:bg-gray-600', 'hover:bg-blue-700');
        }
        
        let isSubmittingMainTask = false;

        async function saveMainTask() {
            if (isSubmittingMainTask) return;
            
            const title = mainTaskTitle.value;
            const description = mainTaskDescription.value;
            if (!title.trim()) return showErrorNotification('Please enter a task title');
            
            isSubmittingMainTask = true;
            if (saveMainTaskBtn) saveMainTaskBtn.disabled = true;
            if (updateMainTaskBtn) updateMainTaskBtn.disabled = true;

            try {
                const categorySelect = document.getElementById('main-task-category');
                const category_id = categorySelect ? categorySelect.value : null;

                const result = await apiCall('{{ route('main-task.store') }}', 'POST', {
                    client_id: currentClientId,
                    title,
                    description,
                    category_id
                });
                const client = findClient(currentClientId);
                if (client) {
                    if (!client.main_tasks) client.main_tasks = [];
                    client.main_tasks.push(result.mainTask);
                }
                renderMainTasks(client.main_tasks);
                renderClientsList();
                showSuccessNotification(result.message);
                resetMainTaskForm();
                loadStatistics(); // Refresh dashboard cards
            } catch (error) {
                // Error handled by apiCall or global handler, but we must reset state
            } finally {
                isSubmittingMainTask = false;
                if (saveMainTaskBtn) saveMainTaskBtn.disabled = false;
                if (updateMainTaskBtn) updateMainTaskBtn.disabled = false;
            }
        }
        
        async function updateMainTask() {
            if (isSubmittingMainTask) return;
            
            const title = mainTaskTitle.value;
            const description = mainTaskDescription.value;
            if (!title.trim()) return showErrorNotification('Please enter a task title');
            
            isSubmittingMainTask = true;
            if (saveMainTaskBtn) saveMainTaskBtn.disabled = true;
            if (updateMainTaskBtn) updateMainTaskBtn.disabled = true;

            try {
                const categorySelect = document.getElementById('main-task-category');
                const category_id = categorySelect ? categorySelect.value : null;

                const url = '{{ route('main-task.update', ['main_task' => ':id']) }}'.replace(':id', currentMainTaskId);
                const result = await apiCall(url, 'PUT', {
                    title,
                    description,
                    category_id
                });
                const client = findClient(currentClientId);
                const taskIndex = client.main_tasks.findIndex(t => t.id == currentMainTaskId);
                if (taskIndex !== -1) {
                    client.main_tasks[taskIndex] = { ...client.main_tasks[taskIndex], ...result.mainTask };
                    
                    if (currentMainTaskId == result.mainTask.id) {
                        selectedMainTaskTitle.textContent = result.mainTask.title;
                        selectedMainTaskDescription.textContent = result.mainTask.description || 'No description';
                    }
                }
                
                renderMainTasks(client.main_tasks);
                showSuccessNotification(result.message);
                resetMainTaskForm();
                loadStatistics(); // Refresh dashboard cards
            } catch (error) {
            } finally {
                isSubmittingMainTask = false;
                if (saveMainTaskBtn) saveMainTaskBtn.disabled = false;
                if (updateMainTaskBtn) updateMainTaskBtn.disabled = false;
            }
        }
        
        function selectMainTask(taskItem) {
            const taskId = taskItem.getAttribute('data-task-id');
            const task = findMainTask(taskId);
            if (!task) return;

            currentMainTaskId = taskId;
            
            // Re-render to show active state
            renderMainTasks(findClient(currentClientId).main_tasks || []);
            
            selectedMainTaskTitle.textContent = task.title;
            selectedMainTaskDescription.textContent = task.description || 'No description';
            selectedMainTaskInfo.classList.remove('hidden');
            addSubtaskBtn.disabled = false;
            
            renderSubtasks(task.subtasks || []);

            if (window.innerWidth < 1024) {
                document.getElementById('subtasks-list').scrollIntoView({ behavior: 'smooth' });
            }
            
            updateBreadcrumb();
            
            currentSubtaskId = null;
            subtaskDetailView.classList.add('hidden');
            subtasksList.classList.remove('hidden');
            subtaskForm.classList.add('hidden');
            if (subtaskCommentsSection) subtaskCommentsSection.classList.add('hidden');
        }

        function updateBreadcrumb() {
            const breadcrumbEl = document.getElementById('breadcrumb-client-name');
            if (!breadcrumbEl) return;
            
            const client = findClient(currentClientId);
            if (!client) return;
            
            let html = `<a href="#" onclick="showClientContent()" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">${client.name}</a>`;
            
            if (currentMainTaskId) {
                const task = findMainTask(currentMainTaskId);
                if (task) {
                    html += ` <i class="fas fa-chevron-right text-[10px] mx-1 opacity-50"></i> <span class="text-gray-400 font-medium">${task.title}</span>`;
                }
            }
            
            breadcrumbEl.innerHTML = html;
        }
        
        function renderSubtasks(subtasks) {
            const container = document.getElementById('subtasks-container');
            if (subtasks.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-12 text-gray-500 dark:text-gray-400">
                        <div class="mx-auto w-12 h-12 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-3">
                            <i class="fas fa-list-ul text-xl text-gray-400 dark:text-gray-500"></i>
                        </div>
                        <p class="text-sm">No subtasks found.</p>
                    </div>`;
                return;
            }
            
            container.innerHTML = subtasks.map(s => {
                const isActive = s.id == currentSubtaskId;
                return `
                <div class="subtask-item p-4 border rounded-lg cursor-pointer transition-all duration-200 
                    ${isActive 
                        ? 'bg-blue-50 dark:bg-blue-900/25 border-blue-300 dark:border-blue-700 shadow-sm' 
                        : 'bg-white dark:bg-gray-800/60 border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50'}" 
                    data-subtask-id="${s.id}">
                    <div class="flex items-start justify-between">
                        <div class="flex items-start space-x-3">
                            <div class="w-10 h-10 ${isActive ? 'bg-blue-600 text-white' : 'bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400'} rounded-lg flex items-center justify-center shrink-0 mt-0.5 transition-colors">
                                <i class="fas fa-pencil-alt"></i>
                            </div>
                            <div>
                                <h5 class="font-bold ${isActive ? 'text-blue-800 dark:text-white' : 'text-gray-800 dark:text-white'}">${s.title}</h5>
                                <div class="flex flex-wrap items-center text-sm gap-x-3 gap-y-1 mt-0.5 ${isActive ? 'text-blue-600/80 dark:text-blue-300' : 'text-gray-600 dark:text-gray-200'}">
                                    <div class="flex items-center font-bold"><i class="fas fa-clock mr-1.5"></i><span>${s.total_time_logged || 0}h total</span></div>
                                    <div class="flex items-center"><i class="fas fa-calendar-alt mr-1.5 opacity-60"></i><span>${s.work_date}</span></div>
                                </div>
                                <div class="mt-1.5 flex items-center text-xs ${isActive ? 'text-blue-500 font-bold' : 'text-blue-600 dark:text-blue-400'}">
                                    <i class="fas fa-user-circle mr-1.5 text-[10px]"></i>
                                    <span>Created by: ${s.user_id == window.App.user.id ? 'You' : (s.user ? s.user.name : 'Unknown')}</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col sm:flex-row items-center gap-2 shrink-0 ml-2">
                            ${(window.App.user.role === 'super_admin' || s.user_id == window.App.user.id) ? `
                                <button class="edit-subtask-btn ${isActive ? 'text-blue-700 hover:text-blue-900' : 'text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300'} p-1"><i class="fas fa-edit"></i></button>
                                <button class="delete-subtask-btn text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 p-1"><i class="fas fa-trash-alt"></i></button>
                            ` : ''}
                        </div>
                    </div>
                </div>
            `;}).join('');
        }

        function resetMainTaskSelection() {
            selectedMainTaskInfo.classList.add('hidden');
            addSubtaskBtn.disabled = true;
            subtaskForm.classList.add('hidden');
            subtasksList.classList.remove('hidden');
            subtaskDetailView.classList.add('hidden');
            currentMainTaskId = null;
            currentSubtaskId = null;
            
            document.getElementById('subtasks-container').innerHTML = `
                <div class="text-center py-12 text-gray-500 dark:text-gray-400">
                    <div class="mx-auto w-12 h-12 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-3">
                        <i class="fas fa-list-ul text-xl text-gray-400 dark:text-gray-500"></i>
                    </div>
                    <p class="text-sm">Select a main task to view its subtasks.</p>
                </div>`;
            document.getElementById('comments-list').innerHTML = '';
            
            const breadcrumbEl = document.getElementById('breadcrumb-client-name');
            if (breadcrumbEl && breadcrumbEl.textContent.includes(' > ')) {
                const clientName = breadcrumbEl.textContent.split(' > ')[0];
                breadcrumbEl.textContent = clientName;
            }
        }
        
        async function deleteMainTask(taskId) {
            try {
                const url = '{{ route('main-task.destroy', ['main_task' => ':id']) }}'.replace(':id', taskId);
                const result = await apiCall(url, 'DELETE');
                const client = findClient(currentClientId);
                client.main_tasks = client.main_tasks.filter(t => t.id != taskId);
                renderMainTasks(client.main_tasks);
                renderClientsList();
                showSuccessNotification(result.message);
                if (currentMainTaskId == taskId) resetMainTaskSelection();
                closeConfirmationModal();
            } catch (error) {}
        }
        
        // Subtask functionality
        function openSubtaskForm(mode, subtaskId = null, title = '', workDate = '', description = '') {
            if (mode === 'add') {
                subtaskTitle.value = '';
                subtaskDescription.value = '';
                subtaskWorkDate.value = new Date().toISOString().split('T')[0];
                saveSubtaskBtn.classList.remove('hidden');
                updateSubtaskBtn.classList.add('hidden');
                currentSubtaskId = null;
                
                isSubmittingSubtask = false;
                if (saveSubtaskBtn) saveSubtaskBtn.disabled = false;
                if (updateSubtaskBtn) updateSubtaskBtn.disabled = false;
            } else if (mode === 'edit') {
                subtaskTitle.value = title;
                subtaskDescription.value = description;
                subtaskWorkDate.value = workDate;
                saveSubtaskBtn.classList.add('hidden');
                updateSubtaskBtn.classList.remove('hidden');
                currentSubtaskId = subtaskId;
            }
            subtaskForm.classList.remove('hidden');
            subtasksList.classList.add('hidden');
            subtaskDetailView.classList.add('hidden');
            addSubtaskBtn.innerHTML = '<i class="fas fa-eye-slash text-sm"></i><span class="max-w-0 overflow-hidden group-hover:max-w-xs transition-all duration-300 ease-in-out opacity-0 group-hover:opacity-100 whitespace-nowrap text-xs md:text-sm font-medium pl-0 group-hover:pl-2">Hide Form</span>';
            addSubtaskBtn.classList.replace('bg-green-600', 'bg-gray-500');
            addSubtaskBtn.classList.replace('hover:bg-green-700', 'hover:bg-gray-600');
        }
        
        function resetSubtaskForm() {
            subtaskForm.classList.add('hidden');
            subtasksList.classList.remove('hidden');
            currentSubtaskId = null;
            addSubtaskBtn.innerHTML = '<i class="fas fa-plus text-sm"></i><span class="max-w-0 overflow-hidden group-hover:max-w-xs transition-all duration-300 ease-in-out opacity-0 group-hover:opacity-100 whitespace-nowrap text-xs md:text-sm font-medium pl-0 group-hover:pl-2">Add Subtask</span>';
            addSubtaskBtn.classList.replace('bg-gray-500', 'bg-green-600');
            addSubtaskBtn.classList.replace('hover:bg-gray-600', 'hover:bg-green-700');
        }
        
        let isSubmittingSubtask = false;
        
        async function saveSubtask() {
            if (isSubmittingSubtask) return;
            
            const title = subtaskTitle.value;
            const description = subtaskDescription.value;
            const work_date = subtaskWorkDate.value;
            if (!title.trim()) return showErrorNotification('Please enter a subtask title');
            
            isSubmittingSubtask = true;
            if (saveSubtaskBtn) saveSubtaskBtn.disabled = true;
            if (updateSubtaskBtn) updateSubtaskBtn.disabled = true;
            
            try {
                const result = await apiCall('{{ route('subtask.store') }}', 'POST', {
                    main_task_id: currentMainTaskId,
                    title,
                    description,
                    work_date
                });
                const task = findMainTask(currentMainTaskId);
                if (!task.subtasks) task.subtasks = [];
                task.subtasks.push(result.subtask);
                renderSubtasks(task.subtasks);
                showSuccessNotification(result.message);
                resetSubtaskForm();
                loadStatistics(); // Refresh dashboard cards
            } catch (error) {
                console.error('Save subtask error:', error);
            } finally {
                isSubmittingSubtask = false;
                if (saveSubtaskBtn) saveSubtaskBtn.disabled = false;
                if (updateSubtaskBtn) updateSubtaskBtn.disabled = false;
            }
        }
        
        async function updateSubtask() {
            if (isSubmittingSubtask) return;
            
            const title = subtaskTitle.value;
            const description = subtaskDescription.value;
            const work_date = subtaskWorkDate.value;
            if (!title.trim()) return showErrorNotification('Please enter a subtask title');
            
            isSubmittingSubtask = true;
            if (saveSubtaskBtn) saveSubtaskBtn.disabled = true;
            if (updateSubtaskBtn) updateSubtaskBtn.disabled = true;
            
            try {
                const url = '{{ route('subtask.update', ['subtask' => ':id']) }}'.replace(':id', currentSubtaskId);
                const result = await apiCall(url, 'PUT', {
                    title,
                    description,
                    work_date
                });
                const task = findMainTask(currentMainTaskId);
                const idx = task.subtasks.findIndex(s => s.id == currentSubtaskId);
                if (idx !== -1) {
                    task.subtasks[idx] = { ...task.subtasks[idx], ...result.subtask };
                }
                renderSubtasks(task.subtasks);
                showSuccessNotification(result.message);
                resetSubtaskForm();
                loadStatistics(); // Refresh dashboard cards
            } catch (error) {
                console.error('Update subtask error:', error);
            } finally {
                isSubmittingSubtask = false;
                if (saveSubtaskBtn) saveSubtaskBtn.disabled = false;
                if (updateSubtaskBtn) updateSubtaskBtn.disabled = false;
            }
        }
        
        function updateSubtaskDetailHeader(subtask) {
            detailSubtaskTitle.innerHTML = `
                <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-3 items-start">
                    <span class="text-lg md:text-xl font-bold text-gray-800 dark:text-white break-words leading-tight">${subtask.title}</span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-300 shrink-0 mt-1 md:mt-0">
                        <i class="fas fa-clock mr-1 text-[10px]"></i>
                        ${parseFloat(subtask.total_time_logged || 0).toFixed(2)}h total
                    </span>
                </div>
            `;
        }

        function selectSubtask(subtaskItem) {
            const subtaskId = subtaskItem.getAttribute('data-subtask-id');
            const subtask = findSubtask(subtaskId);
            if (!subtask) return;

            currentSubtaskId = subtaskId;
            updateSubtaskDetailHeader(subtask);
            
            // Set subtask description and container visibility
            if (detailSubtaskDescription && detailSubtaskDescriptionContainer) {
                if (subtask.description && subtask.description.trim() !== '') {
                    detailSubtaskDescription.textContent = subtask.description;
                    detailSubtaskDescriptionContainer.classList.remove('hidden');
                } else {
                    detailSubtaskDescriptionContainer.classList.add('hidden');
                }
            }
            
            renderComments(subtask.comments || []);
            renderTimeLogs(subtask.time_logs || []);
            
            switchSubtaskTab('comments'); 
            
            subtaskDetailView.classList.remove('hidden');
            subtasksList.classList.add('hidden');
            subtaskForm.classList.add('hidden');
        }

        function switchSubtaskTab(tabName) {
            const tabs = document.querySelectorAll('.subtask-tab');
            const commentsSection = document.getElementById('subtask-comments-section');
            const timeLogsSection = document.getElementById('subtask-time-logs-section');

            tabs.forEach(tab => {
                tab.classList.remove('border-blue-600', 'text-blue-600', 'dark:text-blue-400');
                tab.classList.add('border-transparent', 'text-gray-500', 'dark:text-gray-400');
            });

            const activeTab = document.getElementById(`tab-${tabName}`);
            activeTab.classList.add('border-blue-600', 'text-blue-600', 'dark:text-blue-400');
            activeTab.classList.remove('border-transparent', 'text-gray-500', 'dark:text-gray-400');

            if (tabName === 'comments') {
                commentsSection.classList.remove('hidden');
                timeLogsSection.classList.add('hidden');
            } else {
                commentsSection.classList.add('hidden');
                timeLogsSection.classList.remove('hidden');
            }
        }
        window.switchSubtaskTab = switchSubtaskTab;

        function switchProfileTab(tabName) {
            const tabs = document.querySelectorAll('.profile-nav-item');
            const sections = document.querySelectorAll('.profile-section');

            // Reset all styles
            tabs.forEach(tab => {
                tab.classList.remove('bg-blue-50', 'dark:bg-blue-900/40', 'text-blue-600', 'dark:text-blue-400', 'shadow-sm');
                tab.classList.add('text-gray-500', 'dark:text-gray-400', 'hover:bg-gray-100', 'dark:hover:bg-gray-800');
            });

            // Hide all sections
            sections.forEach(sec => sec.classList.add('hidden'));

            // Set active tab
            const activeTab = document.getElementById(`profile-tab-${tabName}`);
            activeTab.classList.add('bg-blue-50', 'dark:bg-blue-900/40', 'text-blue-600', 'dark:text-blue-400', 'shadow-sm');
            activeTab.classList.remove('text-gray-500', 'dark:text-gray-400', 'hover:bg-gray-100', 'dark:hover:bg-gray-800');

            // Show active section
            document.getElementById(`profile-section-${tabName}`).classList.remove('hidden');
        }
        window.switchProfileTab = switchProfileTab;

        function openTimeLogForm(mode, logId = null, time = '') {
            if (mode === 'add') {
                timeLogValue.value = '';
                editingTimeLogId = null;
                saveTimeLogBtn.classList.remove('hidden');
                updateTimeLogBtn.classList.add('hidden');
            } else if (mode === 'edit') {
                timeLogValue.value = time;
                editingTimeLogId = logId;
                saveTimeLogBtn.classList.add('hidden');
                updateTimeLogBtn.classList.remove('hidden');
            }
            
            isSubmittingTimeLog = false;
            if (saveTimeLogBtn) saveTimeLogBtn.disabled = false;
            if (updateTimeLogBtn) updateTimeLogBtn.disabled = false;
            
            timeLogForm.classList.remove('hidden');
            timeLogValue.focus();
        }

        function resetTimeLogForm() {
            timeLogForm.classList.add('hidden');
            timeLogValue.value = '';
            editingTimeLogId = null;
        }

        function renderTimeLogs(timeLogs) {
            if (timeLogs.length === 0) {
                timeLogsList.innerHTML = `
                    <div class="text-center py-10 opacity-60">
                        <svg class="w-16 h-16 mx-auto mb-4 text-gray-300 dark:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">No time entries</p>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Keep track of your work hours.</p>
                    </div>`;
                return;
            }
            
            timeLogsList.innerHTML = timeLogs.map(log => `
                <div class="flex items-center justify-between p-2 bg-gray-50 dark:bg-gray-700/30 rounded border border-gray-100 dark:border-gray-600">
                    <div class="flex items-center space-x-3">
                        <span class="font-bold text-blue-600 dark:text-blue-400">${log.time}h</span>
                        <span class="text-xs text-gray-500 dark:text-gray-400">${new Date(log.created_at).toLocaleDateString()} by ${log.user_id == window.App.user.id ? 'You' : (log.user ? log.user.name : 'User')}</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        ${(window.App.user.role === 'super_admin' || log.user_id == window.App.user.id) ? `
                            <button onclick="openTimeLogForm('edit', ${log.id}, ${log.time})" class="text-blue-500 hover:text-blue-700 p-1">
                                <i class="fas fa-edit text-xs"></i>
                            </button>
                            <button onclick="deleteTimeLog(${log.id})" class="text-red-500 hover:text-red-700 p-1">
                                <i class="fas fa-trash-alt text-xs"></i>
                            </button>
                        ` : ''}
                    </div>
                </div>
            `).join('');
        }

        let isSubmittingTimeLog = false;
        
        async function saveTimeLog() {
            if (isSubmittingTimeLog) return;
            
            const val = timeLogValue.value;
            if (!val || val <= 0) return showErrorNotification('Please enter a valid amount of time');
            
            isSubmittingTimeLog = true;
            if (saveTimeLogBtn) saveTimeLogBtn.disabled = true;
            if (updateTimeLogBtn) updateTimeLogBtn.disabled = true;
            
            try {
                const result = await apiCall('{{ route('dashboard.time-logs.store') }}', 'POST', {
                    sub_task_id: currentSubtaskId,
                    time: val
                });
                
                const subtask = findSubtask(currentSubtaskId);
                if (!subtask.time_logs) subtask.time_logs = [];
                subtask.time_logs.push(result.time_log);
                
                subtask.total_time_logged = (parseFloat(subtask.total_time_logged) || 0) + parseFloat(val);
                
                updateSubtaskDetailHeader(subtask);
                renderTimeLogs(subtask.time_logs);
                renderSubtasks(findMainTask(currentMainTaskId).subtasks);
                resetTimeLogForm();
                showSuccessNotification(result.message);
                loadStatistics(); // Refresh dashboard cards
            } catch (error) {
                console.error('Save time log error:', error);
            } finally {
                isSubmittingTimeLog = false;
                if (saveTimeLogBtn) saveTimeLogBtn.disabled = false;
                if (updateTimeLogBtn) updateTimeLogBtn.disabled = false;
            }
        }

        async function updateTimeLog() {
            if (isSubmittingTimeLog) return;
            
            const val = timeLogValue.value;
            if (!val || val <= 0) return showErrorNotification('Please enter a valid amount of time');
            
            isSubmittingTimeLog = true;
            if (saveTimeLogBtn) saveTimeLogBtn.disabled = true;
            if (updateTimeLogBtn) updateTimeLogBtn.disabled = true;
            
            try {
                const url = '{{ route('dashboard.time-logs.update', ['time_log' => ':id']) }}'.replace(':id', editingTimeLogId);
                const result = await apiCall(url, 'PUT', {
                    sub_task_id: currentSubtaskId,
                    time: val
                });
                
                const subtask = findSubtask(currentSubtaskId);
                const logIndex = subtask.time_logs.findIndex(l => l.id == editingTimeLogId);
                if (logIndex !== -1) {
                    const oldTime = parseFloat(subtask.time_logs[logIndex].time);
                    subtask.time_logs[logIndex] = { ...subtask.time_logs[logIndex], ...result.time_log };
                    subtask.total_time_logged = (parseFloat(subtask.total_time_logged) || 0) - oldTime + parseFloat(val);
                }
                
                updateSubtaskDetailHeader(subtask);
                renderTimeLogs(subtask.time_logs);
                renderSubtasks(findMainTask(currentMainTaskId).subtasks);
                resetTimeLogForm();
                showSuccessNotification(result.message);
                loadStatistics(); // Refresh dashboard cards
            } catch (error) {
                console.error('Update time log error:', error);
            } finally {
                isSubmittingTimeLog = false;
                if (saveTimeLogBtn) saveTimeLogBtn.disabled = false;
                if (updateTimeLogBtn) updateTimeLogBtn.disabled = false;
            }
        }

        function deleteTimeLog(id) {
            const subtask = findSubtask(currentSubtaskId);
            if (!subtask) return;
            const log = subtask.time_logs.find(l => l.id == id);
            if (!log) return;

            openConfirmationModal('time log', `${log.time} hours`, async () => {
                try {
                    const url = '{{ route('dashboard.time-logs.destroy', ['time_log' => ':id']) }}'.replace(':id', id);
                    const result = await apiCall(url, 'DELETE');
                    
                    subtask.total_time_logged = (parseFloat(subtask.total_time_logged) || 0) - parseFloat(log.time);
                    
                    subtask.time_logs = subtask.time_logs.filter(l => l.id != id);
                    updateSubtaskDetailHeader(subtask);
                    renderTimeLogs(subtask.time_logs);
                    renderSubtasks(findMainTask(currentMainTaskId).subtasks);
                    showSuccessNotification(result.message);
                    closeConfirmationModal();
                } catch (error) {
                    console.error('Delete time log error:', error);
                }
            });
        }
        window.deleteTimeLog = deleteTimeLog;
        
        function renderComments(comments) {
            const container = document.getElementById('comments-list');
            if (comments.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-10 opacity-60">
                        <svg class="w-16 h-16 mx-auto mb-4 text-gray-300 dark:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">No comments yet</p>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Start the conversation below.</p>
                    </div>`;
                return;
            }
            
            container.innerHTML = comments.map(c => `
                <div class="comment-item p-4 border border-gray-200 dark:border-gray-700 rounded-lg" data-comment-id="${c.id}">
                    <div class="flex justify-between items-start">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-purple-100 dark:bg-purple-900/30 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-purple-600 dark:text-purple-400"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800 dark:text-white">${c.user_id == window.App.user.id ? 'You' : (c.user ? c.user.name : 'Unknown User')}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">${new Date(c.created_at).toLocaleString()}</p>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            ${(window.App.user.role === 'super_admin' || c.user_id == window.App.user.id) ? `
                                <button class="edit-comment-btn text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300"><i class="fas fa-edit"></i></button>
                                <button class="delete-comment-btn text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300"><i class="fas fa-trash-alt"></i></button>
                            ` : ''}
                        </div>
                    </div>
                    <p class="mt-3 text-gray-700 dark:text-gray-200">${c.comment}</p>
                </div>
            `).join('');
        }

        async function deleteSubtask(subtaskId) {
            try {
                const url = '{{ route('subtask.destroy', ['subtask' => ':id']) }}'.replace(':id', subtaskId);
                const result = await apiCall(url, 'DELETE');
                const task = findMainTask(currentMainTaskId);
                task.subtasks = task.subtasks.filter(s => s.id != subtaskId);
                renderSubtasks(task.subtasks);
                showSuccessNotification(result.message);
                if (currentSubtaskId == subtaskId) {
                    subtaskDetailView.classList.add('hidden');
                    subtasksList.classList.remove('hidden');
                }
                closeConfirmationModal();
            } catch (error) {}
        }
        
        function openCommentForm(mode, commentId = null, text = '') {
            if (mode === 'add') {
                commentText.value = '';
                currentCommentId = null;
                isSubmittingComment = false;
            } else if (mode === 'edit') {
                commentText.value = text;
                currentCommentId = commentId;
            }
            commentForm.classList.remove('hidden');
        }
        
        function resetCommentForm() {
            commentForm.classList.add('hidden');
            commentText.value = '';
            currentCommentId = null;
        }
        
        let isSubmittingComment = false;
        
        async function saveComment() {
            if (isSubmittingComment) return;
            
            const comment = commentText.value;
            if (!comment.trim()) return showErrorNotification('Please enter a comment');
            
            isSubmittingComment = true;
            
            try {
                if (!currentCommentId) {
                    const result = await apiCall('{{ route('dashboard.comments.store') }}', 'POST', {
                        sub_task_id: currentSubtaskId,
                        comment
                    });
                    const subtask = findSubtask(currentSubtaskId);
                    if (!subtask.comments) subtask.comments = [];
                    subtask.comments.push(result.comment);
                    renderComments(subtask.comments);
                    showSuccessNotification(result.message);
                    loadStatistics();
                } else {
                    const url = '{{ route('dashboard.comments.update', ['comment' => ':id']) }}'.replace(':id', currentCommentId);
                    const result = await apiCall(url, 'PUT', { comment });
                    const subtask = findSubtask(currentSubtaskId);
                    const idx = subtask.comments.findIndex(c => c.id == currentCommentId);
                    if (idx !== -1) subtask.comments[idx] = result.comment;
                    renderComments(subtask.comments);
                    showSuccessNotification(result.message);
                    loadStatistics();
                }
                resetCommentForm();
            } catch (error) {
            } finally {
                isSubmittingComment = false;
            }
        }
        
        // Profile & Security
        function openProfileModal() {
            profileModal.classList.remove('hidden');
            userDropdown.classList.add('hidden');
            document.body.classList.add('overflow-hidden');
            passwordForm.reset();
            switchProfileTab('info');
        }

        // Auto-open if deletion has errors (server-side validation redirect)
        @if($errors->userDeletion->isNotEmpty())
            document.addEventListener('DOMContentLoaded', () => {
                openProfileModal();
                switchProfileTab('delete');
            });
        @endif

        function closeProfileModalFunc() {
            profileModal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        async function handleProfileUpdate(e) {
            e.preventDefault();
            const name = document.getElementById('profile-name').value;
            const email = document.getElementById('profile-email').value;

            try {
                const result = await apiCall('{{ route('profile.update') }}', 'PATCH', { name, email });
                
                document.getElementById('user-display-name').textContent = name;
                document.getElementById('user-email-display').textContent = email;
                
                const initials = name.substring(0, 2).toUpperCase();
                document.getElementById('user-initials').textContent = initials;
                
                window.App.user.name = name;
                window.App.user.email = email;
                
                showSuccessNotification(result.message);
            } catch (error) {}
        }

        async function handlePasswordUpdate(e) {
            e.preventDefault();
            const current_password = document.getElementById('current-password').value;
            const password = document.getElementById('new-password').value;
            const password_confirmation = document.getElementById('new-password-confirmation').value;

            try {
                const result = await apiCall('{{ route('password.update') }}', 'PUT', { 
                    current_password, 
                    password, 
                    password_confirmation 
                });
                
                showSuccessNotification(result.message);
                passwordForm.reset();
            } catch (error) {}
        }
        
        async function deleteComment(commentId) {
            try {
                const url = '{{ route('dashboard.comments.destroy', ['comment' => ':id']) }}'.replace(':id', commentId);
                const result = await apiCall(url, 'DELETE');
                const subtask = findSubtask(currentSubtaskId);
                subtask.comments = subtask.comments.filter(c => c.id != commentId);
                renderComments(subtask.comments);
                showSuccessNotification(result.message);
                closeConfirmationModal();
            } catch (error) {}
        }
        
        function getInitials(name) {
            return name.split(' ').map(n => n[0]).join('').toUpperCase().substring(0, 2);
        }

        // Data helpers
        function findClient(id) { return window.App.clients.find(c => c.id == id); }
        function findMainTask(id) {
            for (let c of window.App.clients) {
                if (c.main_tasks) {
                    let t = c.main_tasks.find(mt => mt.id == id);
                    if (t) return t;
                }
            }
            return null;
        }
        function findSubtask(id) {
            for (let c of window.App.clients) {
                if (c.main_tasks) {
                    for (let t of c.main_tasks) {
                        if (t.subtasks) {
                            let s = t.subtasks.find(st => st.id == id);
                            if (s) return s;
                        }
                    }
                }
            }
            return null;
        }
        function findComment(id) {
            const s = findSubtask(currentSubtaskId);
            return s ? s.comments.find(c => c.id == id) : null;
        }

        // Confirmation modal
        function openConfirmationModal(type, name, callback) {
            const icon = document.getElementById('confirmation-icon');
            const iconContainer = document.getElementById('confirmation-icon-container');
            const actionText = document.getElementById('confirm-action-text');
            const actionIcon = document.getElementById('confirm-action-icon');
            const cancelText = document.getElementById('confirm-cancel-text');
            const confirmBtn = document.getElementById('confirm-delete-btn');
            
            if (type === 'reset-password') {
                confirmationTitle.textContent = 'Forgot Password?';
                confirmationMessage.textContent = `Do you want to reset the password of this user? If yes, a new password will be generated and "${name}" will be logged out globally.`;
                
                if (icon) icon.className = 'fas fa-user-lock text-3xl text-blue-600';
                if (iconContainer) iconContainer.className = 'mx-auto w-20 h-20 bg-blue-100 dark:bg-blue-900/40 rounded-full flex items-center justify-center mb-6';
                
                if (actionText) actionText.textContent = 'Yes, Reset';
                if (actionIcon) actionIcon.className = 'fas fa-check mr-2';
                if (cancelText) cancelText.textContent = 'No, Cancel';
                
                if (confirmBtn) {
                    confirmBtn.className = 'flex-1 px-3 py-2.5 md:px-6 md:py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors flex items-center justify-center text-sm md:text-base shadow-lg shadow-blue-500/20';
                }
            } else {
                confirmationTitle.textContent = `Delete ${type.charAt(0).toUpperCase() + type.slice(1)}`;
                confirmationMessage.textContent = `Are you sure you want to delete "${name}"? This action cannot be undone.`;
                
                if (icon) icon.className = 'fas fa-exclamation-triangle text-3xl text-red-600';
                if (iconContainer) iconContainer.className = 'mx-auto w-20 h-20 bg-red-100 dark:bg-red-800/40 rounded-full flex items-center justify-center mb-6';
                
                if (actionText) actionText.textContent = 'Delete';
                if (actionIcon) actionIcon.className = 'fas fa-trash-alt mr-2';
                if (cancelText) cancelText.textContent = 'Cancel';

                if (confirmBtn) {
                    confirmBtn.className = 'flex-1 px-3 py-2.5 md:px-6 md:py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors flex items-center justify-center text-sm md:text-base shadow-lg shadow-red-500/20';
                }
            }

            deleteCallback = callback;
            currentDeleteType = type;
            confirmationModal.classList.remove('hidden');
        }
        
        function closeConfirmationModal() {
            confirmationModal.classList.add('hidden');
            deleteCallback = null;
            currentDeleteType = null;
        }
        
        // Notifications
        function showSuccessNotification(message) {
            successMessage.textContent = message;
            successNotification.classList.remove('invisible');
            successNotification.classList.remove('translate-x-[150%]');
            setTimeout(() => {
                successNotification.classList.add('translate-x-[150%]');
                setTimeout(() => successNotification.classList.add('invisible'), 300);
            }, 3000);
        }
        
        function showErrorNotification(message) {
            errorMessage.textContent = message;
            errorNotification.classList.remove('invisible');
            errorNotification.classList.remove('translate-x-[150%]');
            setTimeout(() => {
                errorNotification.classList.add('translate-x-[150%]');
                setTimeout(() => errorNotification.classList.add('invisible'), 300);
            }, 3000);
        }
        
        // Initialize the application
        init();
        
        if (confirmDeleteBtn) {
            confirmDeleteBtn.addEventListener('click', () => {
                if (deleteCallback) deleteCallback();
            });
        }

        function setupCategoryDropdown() {
            const btn = document.getElementById('category-dropdown-btn');
            const menu = document.getElementById('category-dropdown-menu');
            const search = document.getElementById('category-search');
            const list = document.getElementById('category-options-list');
            const input = document.getElementById('main-task-category');
            const text = document.getElementById('category-dropdown-text');
            
            if (!btn || !menu || !list) return;

            // Populate logic
            if (list.children.length === 0 && window.App.categories) {
                renderCategoryOptions(window.App.categories);
            }

            // Remove old listeners to prevent duplicates (simple approach: clone or check property)
            // Ideally we just set this up once, but openMainTaskForm is called multiple times.
            // Let's stick to a robust simple toggle.
            
            btn.onclick = (e) => {
                e.stopPropagation();
                menu.classList.toggle('hidden');
                if (!menu.classList.contains('hidden')) {
                    search.focus();
                }
            };
            
            let selectedIndex = -1;

            search.onkeydown = (e) => {
                const items = list.querySelectorAll('div[onclick]'); // Only selectable items
                if (items.length === 0) return;

                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    selectedIndex = (selectedIndex + 1) % items.length;
                    updateHighlight(items, selectedIndex);
                } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    selectedIndex = (selectedIndex - 1 + items.length) % items.length;
                    updateHighlight(items, selectedIndex);
                } else if (e.key === 'Enter') {
                    e.preventDefault();
                    if (selectedIndex >= 0 && items[selectedIndex]) {
                        items[selectedIndex].click();
                    }
                }
            };
            
            function updateHighlight(items, index) {
                items.forEach((item, i) => {
                    // Reset base styles
                    item.className = 'px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer text-sm text-gray-700 dark:text-gray-200 transition-colors';
                    
                    if (i === index) {
                        item.classList.remove('hover:bg-gray-100', 'dark:hover:bg-gray-700');
                        item.classList.add('bg-blue-100', 'dark:bg-blue-900', 'font-medium');
                        item.scrollIntoView({ block: 'nearest' });
                    }
                });
            }

            search.oninput = (e) => {
                const term = e.target.value.toLowerCase();
                const filtered = window.App.categories.filter(c => c.name.toLowerCase().includes(term));
                renderCategoryOptions(filtered);
                selectedIndex = -1; // Reset selection on search
            };

            // Close when clicking outside
            document.addEventListener('click', (e) => {
                if (!menu.contains(e.target) && !btn.contains(e.target)) {
                    menu.classList.add('hidden');
                }
            });
        }

        function renderCategoryOptions(categories) {
            const list = document.getElementById('category-options-list');
            const menu = document.getElementById('category-dropdown-menu');
            const input = document.getElementById('main-task-category');
            const text = document.getElementById('category-dropdown-text');

            if (!list) return;
            
            if (categories.length === 0) {
                list.innerHTML = '<div class="px-3 py-2 text-sm text-gray-500 dark:text-gray-400">No categories found</div>';
                return;
            }

            list.innerHTML = categories.map(c => `
                <div class="px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer text-sm text-gray-700 dark:text-gray-200" onclick="selectCategory('${c.id}', '${c.name.replace(/'/g, "\\'")}')">
                    ${c.name}
                </div>
            `).join('');
        }

        function selectCategory(id, name) {
            const input = document.getElementById('main-task-category');
            const text = document.getElementById('category-dropdown-text');
            const menu = document.getElementById('category-dropdown-menu');
            
            if (input) input.value = id;
            if (text) {
                text.textContent = name;
                text.classList.remove('text-gray-500', 'dark:text-gray-400');
                text.classList.add('text-gray-800', 'dark:text-white');
            }
            if (menu) menu.classList.add('hidden');
        }

        /* --- Activity Reports Logic --- */
        let currentReportData = [];

        window.handleReportTypeChange = function() {
            const type = document.getElementById('report-type-select').value;
            const targetLabel = document.getElementById('report-target-label');
            const targetSelect = document.getElementById('report-target-select');
            
            if (type === 'user') {
                if (targetLabel) targetLabel.textContent = 'Target Developer';
                if (targetSelect) {
                    targetSelect.innerHTML = '<option value="">All Developers</option>' + 
                        @json(\App\Models\User::all()).map(u => `<option value="${u.id}">${u.name}</option>`).join('');
                }
            } else {
                if (targetLabel) targetLabel.textContent = 'Target Client';
                if (targetSelect) {
                    targetSelect.innerHTML = '<option value="">All Clients</option>' + 
                        @json(\App\Models\Client::all()).map(c => `<option value="${c.id}">${c.name}</option>`).join('');
                }
            }
        };

        window.handleReportPeriodChange = function() {
            const period = document.getElementById('report-period-select').value;
            const customContainer = document.getElementById('report-custom-date-container');
            if (period === 'custom') {
                customContainer.classList.remove('hidden');
            } else {
                customContainer.classList.add('hidden');
            }
        };

        window.loadReportsData = async function(page = 1) {
            const typeSelect = document.getElementById('report-type-select');
            const targetSelect = document.getElementById('report-target-select');
            const periodSelect = document.getElementById('report-period-select');
            const startTime = document.getElementById('report-start-date');
            const endTime = document.getElementById('report-end-date');

            const params = new URLSearchParams({
                page: page,
                type: typeSelect ? typeSelect.value : 'user',
                period: periodSelect ? periodSelect.value : 'week'
            });

            if (targetSelect && targetSelect.value) params.append('target_id', targetSelect.value);
            if (startTime && startTime.value) params.append('start_date', startTime.value);
            if (endTime && endTime.value) params.append('end_date', endTime.value);

            try {
                const response = await fetch(`/dashboard/reports/data?${params.toString()}`);
                const result = await response.json();
                
                if (result.success) {
                    currentReportData = result.data;
                    renderReportTable(result.data);
                    renderPagination(result.pagination);
                    updateReportSummary(result.summary, result.filters.type);
                }
            } catch (error) {
                console.error('Error loading reports:', error);
                showNotification('Failed to load report data', 'error');
            }
        };

        function renderReportTable(data) {
            const tbody = document.getElementById('report-table-body');
            const emptyState = document.getElementById('report-empty-state');
            
            if (!data || data.length === 0) {
                tbody.innerHTML = '';
                emptyState.classList.remove('hidden');
                return;
            }

            emptyState.classList.add('hidden');
            tbody.innerHTML = data.map(log => `
                <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/30 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-xs font-bold text-gray-700 dark:text-gray-300">${new Date(log.created_at).toLocaleDateString()}</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-col">
                            <span class="text-[10px] font-black text-blue-600 dark:text-blue-400 uppercase tracking-tighter">${log.subtask?.main_task?.client?.name || 'N/A'}</span>
                            <span class="text-sm font-black text-gray-900 dark:text-white mt-0.5 line-clamp-1">${log.subtask?.main_task?.title || 'Unknown Task'}</span>
                            <span class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mt-0.5">${log.subtask?.title || 'No Subtask Title'}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 rounded-full bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center text-[10px] font-bold text-indigo-600">
                                ${log.user?.name.charAt(0)}
                            </div>
                            <span class="text-xs font-semibold text-gray-600 dark:text-gray-400">${log.user?.name}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-2 max-w-xs italic">
                            ${log.subtask?.description || 'No work description reported'}
                        </p>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <span class="inline-flex px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded-lg text-xs font-black text-gray-700 dark:text-gray-200">
                            ${log.time}h
                        </span>
                    </td>
                </tr>
            `).join('');
        }

        function updateReportSummary(summary, type) {
            document.getElementById('report-summary-hours').textContent = summary.total_hours + 'h';
            document.getElementById('report-summary-tasks').textContent = summary.task_count;
            
            const extraCard = document.getElementById('report-summary-extra-card');
            const extraLabel = document.getElementById('report-summary-extra-label');
            const extraValue = document.getElementById('report-summary-extra-value');

            if (type === 'client') {
                extraCard.classList.remove('hidden');
                extraLabel.textContent = 'Project Contributors';
                
                // Detailed breakdown for easy viewing by Super Admin
                let breakdownHtml = `<div class="mt-2 text-2xl font-black text-gray-900 dark:text-white">${summary.developer_count}</div>`;
                if (summary.developer_breakdown && summary.developer_breakdown.length > 0) {
                    breakdownHtml += `
                        <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700 space-y-2">
                            ${summary.developer_breakdown.map(dev => `
                                <div class="flex justify-between items-center">
                                    <span class="text-[10px] font-bold text-gray-500 uppercase">${dev.user_name}</span>
                                    <span class="text-xs font-black text-blue-600">${dev.hours}h</span>
                                </div>
                            `).join('')}
                        </div>`;
                }
                extraValue.parentElement.innerHTML = `
                    <p id="report-summary-extra-label" class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-1">${extraLabel.textContent}</p>
                    <div id="report-summary-extra-value">${breakdownHtml}</div>
                `;
            } else {
                extraCard.classList.add('hidden');
            }
        }

        function renderPagination(pagination) {
            const info = document.getElementById('report-pagination-info');
            const pages = document.getElementById('report-pages');
            const prevBtn = document.getElementById('report-prev-page');
            const nextBtn = document.getElementById('report-next-page');

            info.textContent = `Showing ${pagination.total > 0 ? (pagination.current_page - 1) * pagination.per_page + 1 : 0} to ${Math.min(pagination.current_page * pagination.per_page, pagination.total)} of ${pagination.total} records`;

            prevBtn.disabled = pagination.current_page === 1;
            prevBtn.onclick = () => loadReportsData(pagination.current_page - 1);

            nextBtn.disabled = pagination.current_page === pagination.last_page || pagination.total === 0;
            nextBtn.onclick = () => loadReportsData(pagination.current_page + 1);

            pages.innerHTML = '';
            for (let i = 1; i <= Math.min(5, pagination.last_page); i++) {
                const btn = document.createElement('button');
                btn.className = `w-8 h-8 rounded-lg text-xs font-bold transition-all ${i === pagination.current_page ? 'bg-blue-600 text-white shadow-lg' : 'text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700'}`;
                btn.textContent = i;
                btn.onclick = () => loadReportsData(i);
                pages.appendChild(btn);
            }
        }

        window.exportReportToCSV = function() {
            if (!currentReportData || currentReportData.length === 0) {
                showNotification('No data available to export', 'warning');
                return;
            }

            const headers = ['Date', 'Client', 'Main Task', 'Subtask', 'User', 'Description', 'Hours'];
            const rows = currentReportData.map(log => [
                new Date(log.created_at).toLocaleDateString(),
                log.subtask?.main_task?.client?.name || 'N/A',
                log.subtask?.main_task?.title || 'N/A',
                log.subtask?.title || 'N/A',
                log.user?.name || 'N/A',
                (log.subtask?.description || '').replace(/,/g, ';'),
                log.time
            ]);

            let csvContent = "data:text/csv;charset=utf-8," 
                + headers.join(",") + "\n"
                + rows.map(e => e.join(",")).join("\n");

            const encodedUri = encodeURI(csvContent);
            const link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", `activity_report_${new Date().toISOString().split('T')[0]}.csv`);
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        };
        // Notification Functions
        if (isSuperAdmin && notificationsButton) {
            notificationsButton.addEventListener('click', (e) => {
                e.stopPropagation();
                notificationsDropdown.classList.toggle('hidden');
                userDropdown.classList.add('hidden'); // Close user menu
            });

            document.addEventListener('click', (e) => {
                if (notificationsDropdown && !notificationsDropdown.contains(e.target) && !notificationsButton.contains(e.target)) {
                    notificationsDropdown.classList.add('hidden');
                }
            });
        }

        function processNotifications(newNotifications) {
            const oldNotificationsJson = JSON.stringify(notifications);
            const newNotificationsJson = JSON.stringify(newNotifications);
            
            if (oldNotificationsJson !== newNotificationsJson) {
                const prevCount = notifications.length;
                notifications = newNotifications;
                
                renderNotifications();
                
                if (notifications.length > prevCount) {
                    const latest = notifications[0];
                    showSuccessNotification(`New Activity: ${latest.message}`);
                }
            }
        }

        async function jumpToNotification(notifId) {
            const notif = notifications.find(n => n.id == notifId);
            if (!notif) return;

            // Close dropdown
            if (notificationsDropdown) notificationsDropdown.classList.add('hidden');

            try {
                // 1. Switch to Client View
                switchView('client');

                // 2. Select the client
                if (notif.client_id) {
                    const client = window.App.clients.find(c => c.id == notif.client_id);
                    if (client) {
                        // Use the existing selection logic
                        currentClientId = client.id;
                        renderMainTasks(client.main_tasks || []);
                        renderClientsList();
                        updateBreadcrumb();
                        
                        // Set join date
                        const joinDate = new Date(client.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                        const joinDateEl = document.getElementById('client-join-date');
                        if (joinDateEl) joinDateEl.textContent = joinDate;
                    }
                }

                // 3. Select the Main Task
                if (notif.main_task_id) {
                    const client = window.App.clients.find(c => c.id == notif.client_id);
                    const task = client?.main_tasks?.find(t => t.id == notif.main_task_id);
                    if (task) {
                        currentMainTaskId = task.id;
                        selectedMainTaskTitle.textContent = task.title;
                        selectedMainTaskDescription.textContent = task.description || 'No description';
                        selectedMainTaskInfo.classList.remove('hidden');
                        addSubtaskBtn.disabled = false;
                        renderSubtasks(task.subtasks || []);
                        updateBreadcrumb();
                        
                        // Update active state in UI
                        renderMainTasks(client.main_tasks);
                    }
                }

                // 4. Open Subtask Details
                if (notif.sub_task_id) {
                    const client = window.App.clients.find(c => c.id == notif.client_id);
                    const task = client?.main_tasks?.find(t => t.id == notif.main_task_id);
                    const subtask = task?.subtasks?.find(s => s.id == notif.sub_task_id);
                    
                    if (subtask) {
                        // Use existing logic to open detail view
                        currentSubtaskId = subtask.id;
                        detailSubtaskTitle.textContent = subtask.title;
                        detailSubtaskDescription.textContent = subtask.description || 'No description';
                        
                        // Update UI toggles
                        subtaskDetailView.classList.remove('hidden');
                        subtasksList.classList.add('hidden');
                        subtaskForm.classList.add('hidden');
                        
                        if (typeof updateSubtaskDetailHeader === 'function') updateSubtaskDetailHeader(subtask);
                        if (typeof renderComments === 'function') renderComments(subtask.comments || []);
                        if (typeof renderTimeLogs === 'function') renderTimeLogs(subtask.time_logs || []);
                        
                        // Switch to comments tab if it was a comment notification
                        if (notif.type === 'comment') {
                            const commentTab = document.querySelector('[onclick*="comments"]');
                            if (commentTab) commentTab.click();
                        }
                    }
                }

                // Scroll to content
                const mainContent = document.getElementById('main-content');
                if (mainContent) mainContent.scrollTop = 0;

            } catch (error) {
                console.error('Navigation failed:', error);
                showErrorNotification('Could not navigate to the selected item.');
            }
        }
        window.jumpToNotification = jumpToNotification;

        function renderNotifications() {
            if (!notificationsList) return;
            const count = notifications.length;
            if (notificationsBadge) {
                if (count > 0) {
                    notificationsBadge.textContent = count > 99 ? '99+' : count;
                    notificationsBadge.classList.remove('hidden');
                } else {
                    notificationsBadge.classList.add('hidden');
                }
            }
            if (count === 0) {
                notificationsList.innerHTML = `<div class="p-8 text-center text-gray-500 dark:text-gray-400">
                    <i class="fas fa-bell-slash mb-2 text-2xl opacity-20"></i>
                    <p class="text-sm font-medium">No new notifications</p>
                </div>`;
                return;
            }
            notificationsList.innerHTML = notifications.map(notif => {
                const time = new Date(notif.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                let icon = 'fa-info-circle', iconBg = 'bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400';
                if (notif.type === 'comment') { icon = 'fa-comments'; iconBg = 'bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400'; }
                else if (notif.type === 'time_log') { icon = 'fa-clock'; iconBg = 'bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400'; }
                else if (notif.type === 'main_task' || notif.type === 'subtask') { icon = 'fa-tasks'; iconBg = 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400'; }
                
                return `<div class="p-4 border-b border-gray-50 dark:border-gray-700/50 hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors cursor-pointer" onclick="jumpToNotification(${notif.id})">
                    <div class="flex space-x-3">
                        <div class="w-10 h-10 rounded-full ${iconBg} flex items-center justify-center shrink-0">
                            <i class="fas ${icon}"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm text-gray-800 dark:text-gray-200">${notif.message}</p>
                            <p class="text-[10px] text-gray-400 mt-1 uppercase font-bold tracking-wider">${time}</p>
                        </div>
                    </div>
                </div>`;
            }).join('');
        }

        async function markNotificationsAsRead() {
            try {
                const response = await fetch('{{ route('dashboard.notifications.mark-read') }}', {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
                });
                if (response.ok) {
                    notifications = [];
                    renderNotifications();
                }
            } catch (error) { console.error('Failed to clear notifications:', error); }
        }
        window.markNotificationsAsRead = markNotificationsAsRead;
        // Developer Task Management Logic
        let developerTasks = [];
        let devTaskFilter = 'all';
        let historyTaskFilter = 'all';
        let currentHistoryUserId = null;

        function renderDeveloperTasks() {
            const container = document.getElementById('dev-tasks-container');
            const emptyState = document.getElementById('dev-tasks-empty');
            if (!container) return;

            const filtered = developerTasks.filter(t => {
                if (devTaskFilter === 'all') return true;
                return t.status === devTaskFilter;
            });

            if (filtered.length === 0) {
                container.innerHTML = '';
                if (emptyState) emptyState.classList.remove('hidden');
                return;
            }

            if (emptyState) emptyState.classList.add('hidden');
            container.innerHTML = filtered.map(task => {
                const deadline = task.deadline ? new Date(task.deadline).toLocaleDateString() : 'No deadline';
                const priorityClass = {
                    'low': 'bg-gray-100 text-gray-600 dark:bg-gray-700/50 dark:text-gray-400',
                    'medium': 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300',
                    'high': 'bg-rose-100 text-rose-700 dark:bg-rose-900/40 dark:text-rose-300'
                }[task.priority];

                return `
                    <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 border border-gray-100 dark:border-gray-700/50 shadow-sm hover:shadow-xl hover:shadow-indigo-500/5 transition-all duration-300 group">
                        <div class="flex justify-between items-start mb-4">
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider ${priorityClass}">
                                ${task.priority} Priority
                            </span>
                            <div class="flex items-center gap-2">
                                ${task.status === 'completed' 
                                    ? '<span class="flex items-center gap-1.5 text-xs font-bold text-emerald-500"><i class="fas fa-check-circle"></i> Completed</span>'
                                    : '<span class="flex items-center gap-1.5 text-xs font-bold text-amber-500"><i class="fas fa-clock"></i> Pending</span>'}
                            </div>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">${task.title}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-6 line-clamp-3">${task.description || 'No description provided.'}</p>
                        
                        <div class="flex items-center justify-between pt-6 border-t border-gray-50 dark:border-gray-700/50">
                            <div class="flex items-center gap-2 text-xs text-gray-400">
                                <i class="fas fa-calendar-alt"></i>
                                <span>${deadline}</span>
                            </div>
                            ${task.status === 'pending' ? `
                                <button onclick="markTaskComplete(${task.id})" class="px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl text-xs font-bold transition-all shadow-lg shadow-emerald-500/20">
                                    Mark Done
                                </button>
                            ` : `
                                <div class="text-[10px] text-gray-400 italic">
                                    Done: ${new Date(task.completed_at).toLocaleDateString()}
                                </div>
                            `}
                        </div>
                    </div>
                `;
            }).join('');
        }

        window.filterDevTasks = function(filter) {
            devTaskFilter = filter;
            document.querySelectorAll('.dev-task-filter').forEach(btn => {
                btn.classList.remove('bg-white', 'dark:bg-gray-700', 'text-indigo-600', 'dark:text-indigo-400', 'shadow-sm');
                btn.classList.add('text-gray-500', 'dark:text-gray-400');
            });
            const activeBtn = document.getElementById(`dev-task-filter-${filter}`);
            if (activeBtn) {
                activeBtn.classList.add('bg-white', 'dark:bg-gray-700', 'text-indigo-600', 'dark:text-indigo-400', 'shadow-sm');
                activeBtn.classList.remove('text-gray-500', 'dark:text-gray-400');
            }
            renderDeveloperTasks();
        };

        window.markTaskComplete = async function(taskId) {
            try {
                const result = await apiCall(`/dashboard/developer-tasks/${taskId}`, 'PATCH', { status: 'completed' });
                if (result.success) {
                    showSuccessNotification('Great job! Task marked as completed.');
                    // Update local state
                    const task = developerTasks.find(t => t.id == taskId);
                    if (task) {
                        task.status = 'completed';
                        task.completed_at = new Date().toISOString();
                    }
                    renderDeveloperTasks();
                    if (typeof loadStatistics === 'function') loadStatistics();
                }
            } catch (error) {
                console.error('Failed to update task:', error);
            }
        };

        // Admin Task Management
        window.openAssignTaskModal = function(userId, userName) {
            const modal = document.getElementById('assign-task-modal');
            const form = document.getElementById('assign-task-form');
            const nameSpan = document.getElementById('assign-task-user-name');
            const idInput = document.getElementById('assign-task-user-id');
            const taskIdInput = document.getElementById('assign-task-id');
            
            if (!modal || !form) return;
            form.reset();
            idInput.value = userId;
            taskIdInput.value = '';
            if (nameSpan) nameSpan.textContent = userName;
            
            const saveBtn = document.getElementById('save-assign-task-btn');
            const updateBtn = document.getElementById('update-assign-task-btn');
            const titleEl = document.getElementById('assign-task-modal-title');
            
            if (saveBtn) saveBtn.classList.remove('hidden');
            if (updateBtn) updateBtn.classList.add('hidden');
            if (titleEl) titleEl.textContent = 'Assign Task';

            modal.classList.remove('hidden');
            const titleInput = document.getElementById('assign-task-title');
            if (titleInput) titleInput.focus();
        };

        window.closeAssignTaskModal = function() {
            const modal = document.getElementById('assign-task-modal');
            if (modal) modal.classList.add('hidden');
        };

        const assignTaskForm = document.getElementById('assign-task-form');
        if (assignTaskForm) {
            assignTaskForm.onsubmit = async (e) => {
                e.preventDefault();
                const userId = document.getElementById('assign-task-user-id').value;
                const taskId = document.getElementById('assign-task-id').value;
                const data = {
                    user_id: userId,
                    title: document.getElementById('assign-task-title').value,
                    description: document.getElementById('assign-task-description').value,
                    priority: document.getElementById('assign-task-priority').value,
                    deadline: document.getElementById('assign-task-deadline').value || null
                };

                try {
                    let result;
                    if (taskId) {
                        result = await apiCall(`/dashboard/developer-tasks/${taskId}`, 'PUT', data);
                        if (result.success) {
                            const idx = developerTasks.findIndex(t => t.id == taskId);
                            if (idx !== -1) developerTasks[idx] = result.task;
                        }
                    } else {
                        result = await apiCall('/dashboard/developer-tasks', 'POST', data);
                        if (result.success) {
                            developerTasks.push(result.task);
                        }
                    }

                    if (result.success) {
                        showSuccessNotification(result.message);
                        closeAssignTaskModal();
                        
                        // Update UI instantly
                        if (document.getElementById('assigned-tasks-dashboard')) renderDeveloperTasks();
                        if (currentHistoryUserId == userId) renderUserTaskHistoryUI();
                    }
                } catch (error) {
                    console.error('Task assignment failed:', error);
                }
            };
        }

        window.openUserTaskHistory = function(userId, userName) {
            currentHistoryUserId = userId;
            const nameEl = document.getElementById('history-modal-user-name');
            if (nameEl) nameEl.textContent = userName;
            const modal = document.getElementById('user-task-history-modal');
            if (modal) modal.classList.remove('hidden');
            filterHistoryTasks('all');
        };

        window.closeUserTaskHistory = function() {
            const modal = document.getElementById('user-task-history-modal');
            if (modal) modal.classList.add('hidden');
            currentHistoryUserId = null;
        };

        window.filterHistoryTasks = function(filter) {
            historyTaskFilter = filter;
            document.querySelectorAll('.history-filter').forEach(btn => {
                btn.classList.remove('bg-white', 'dark:bg-gray-700', 'text-indigo-600', 'dark:text-indigo-400', 'shadow-sm');
                btn.classList.add('text-gray-500', 'dark:text-gray-400');
            });
            const activeBtn = document.getElementById(`history-filter-${filter}`);
            if (activeBtn) {
                activeBtn.classList.add('bg-white', 'dark:bg-gray-700', 'text-indigo-600', 'dark:text-indigo-400', 'shadow-sm');
                activeBtn.classList.remove('text-gray-500', 'dark:text-gray-400');
            }
            renderUserTaskHistoryUI();
        };

        function renderUserTaskHistoryUI() {
            const container = document.getElementById('history-tasks-container');
            const emptyState = document.getElementById('history-empty-state');
            const totalCountEl = document.getElementById('history-total-count');
            
            if (!container) return;

            // Use global developerTasks (for Admin it contains all tasks)
            const userTasks = developerTasks.filter(t => t.user_id == currentHistoryUserId);
            const filtered = userTasks.filter(t => {
                if (historyTaskFilter === 'all') return true;
                return t.status === historyTaskFilter;
            });

            if (totalCountEl) totalCountEl.textContent = userTasks.length;

            if (filtered.length === 0) {
                container.innerHTML = '';
                if (emptyState) emptyState.classList.remove('hidden');
                return;
            }

            if (emptyState) emptyState.classList.add('hidden');
            container.innerHTML = filtered.map(task => {
                const deadline = task.deadline ? new Date(task.deadline).toLocaleDateString() : 'No deadline';
                const isCompleted = task.status === 'completed';
                return `
                    <div class="bg-gray-50 dark:bg-gray-900/40 rounded-2xl p-5 border border-gray-100 dark:border-gray-800/60 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-1">
                                <h4 class="font-bold text-gray-900 dark:text-white">${task.title}</h4>
                                <span class="text-[10px] font-bold uppercase px-2 py-0.5 rounded-md ${isCompleted ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300' : 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300'}">
                                    ${task.status}
                                </span>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-1">${task.description || 'No description'}</p>
                            <div class="flex items-center gap-4 mt-2">
                                <span class="text-[10px] text-gray-400 font-medium italic">Priority: ${task.priority}</span>
                                <span class="text-[10px] text-gray-400 font-medium">Deadline: ${deadline}</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            ${!isCompleted ? `
                                <button onclick="editTaskFromHistory(${task.id})" class="p-2 text-gray-400 hover:text-indigo-600 transition-colors" title="Edit Task">
                                    <i class="fas fa-edit text-xs"></i>
                                </button>
                            ` : `
                                <span class="text-[10px] text-gray-400 font-bold uppercase mr-2">${new Date(task.completed_at).toLocaleDateString()}</span>
                            `}
                            <button onclick="deleteTaskFromHistory(${task.id})" class="p-2 text-gray-400 hover:text-red-500 transition-colors" title="Delete Task">
                                <i class="fas fa-trash-alt text-xs"></i>
                            </button>
                        </div>
                    </div>
                `;
            }).join('');
        }

        window.editTaskFromHistory = function(taskId) {
            const task = developerTasks.find(t => t.id == taskId);
            if (!task) return;

            const modal = document.getElementById('assign-task-modal');
            const form = document.getElementById('assign-task-form');
            const idInput = document.getElementById('assign-task-user-id');
            const taskIdInput = document.getElementById('assign-task-id');
            
            if (!modal || !form) return;
            form.reset();
            idInput.value = task.user_id;
            taskIdInput.value = task.id;
            const nameSpan = document.getElementById('assign-task-user-name');
            if (nameSpan) nameSpan.textContent = task.developer ? task.developer.name : 'Developer';
            
            document.getElementById('assign-task-title').value = task.title;
            document.getElementById('assign-task-description').value = task.description;
            document.getElementById('assign-task-priority').value = task.priority;
            document.getElementById('assign-task-deadline').value = task.deadline;

            const saveBtn = document.getElementById('save-assign-task-btn');
            const updateBtn = document.getElementById('update-assign-task-btn');
            const titleEl = document.getElementById('assign-task-modal-title');

            if (saveBtn) saveBtn.classList.add('hidden');
            if (updateBtn) updateBtn.classList.remove('hidden');
            if (titleEl) titleEl.textContent = 'Edit Task';

            modal.classList.remove('hidden');
        };

        window.deleteTaskFromHistory = function(taskId) {
            openConfirmationModal('task', 'this assignment', async () => {
                try {
                    const result = await apiCall(`/dashboard/developer-tasks/${taskId}`, 'DELETE');
                    if (result.success) {
                        showSuccessNotification(result.message);
                        developerTasks = developerTasks.filter(t => t.id != taskId);
                        renderUserTaskHistoryUI();
                        closeConfirmationModal();
                    }
                } catch (error) {
                    console.error('Delete task failed:', error);
                }
            });
        };

        // Integration with existing pulse system
        const originalStartPulseSync = typeof startPulseSync === 'function' ? startPulseSync : null;
        window.startPulseSync = function() {
            if (originalStartPulseSync) originalStartPulseSync();
            
            // Additional pulse for developer tasks
            setInterval(async () => {
                if (document.hidden) return;
                try {
                    const response = await fetch('{{ route('dashboard.sync') }}');
                    const data = await response.json();
                    
                    if (data.success && data.developer_tasks) {
                        const oldJson = JSON.stringify(developerTasks);
                        const newJson = JSON.stringify(data.developer_tasks);
                        
                        if (oldJson !== newJson) {
                            developerTasks = data.developer_tasks;
                            if (document.getElementById('assigned-tasks-dashboard')) renderDeveloperTasks();
                            if (currentHistoryUserId) renderUserTaskHistoryUI();
                        }
                    }
                } catch (e) { }
            }, 15000);
        };

        // Initialize developer views
        document.addEventListener('DOMContentLoaded', () => {
            if (window.App && window.App.user) {
                loadInitialDeveloperTasks();
            }
        });

        async function loadInitialDeveloperTasks() {
            try {
                const response = await apiCall('/dashboard/developer-tasks');
                if (response.success) {
                    developerTasks = response.tasks;
                    renderDeveloperTasks();
                }
            } catch (error) { }
        }

        window.renderDeveloperTasks = renderDeveloperTasks;
        window.loadInitialDeveloperTasks = loadInitialDeveloperTasks;
    </script>
