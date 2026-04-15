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

            // Start Remote Logout Heartbeat
            startHeartbeat();
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
            
            list.innerHTML = tasks.map(task => `
                <div class="main-task-item p-4 border border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors" data-task-id="${task.id}">
                    <div class="flex items-start justify-between">
                        <div class="flex items-start space-x-3">
                            <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg flex items-center justify-center shrink-0 mt-0.5">
                                <i class="fas fa-project-diagram"></i>
                            </div>
                            <div>
                                <h5 class="font-medium text-gray-800 dark:text-white flex flex-wrap items-center gap-2 mb-0.5">
                                    <span class="break-words">${task.title}</span>
                                    ${task.category ? `<span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800 whitespace-nowrap">${task.category.name}</span>` : ''}
                                </h5>
                                <p class="text-sm text-gray-600 dark:text-gray-200 line-clamp-1">${task.description || 'No description'}</p>
                                <div class="mt-1.5 flex items-center text-xs text-blue-600 dark:text-blue-400">
                                    <i class="fas fa-user-circle mr-1.5 text-[10px]"></i>
                                    <span>Created by: ${task.user_id == window.App.user.id ? 'You' : (task.user ? task.user.name : 'Unknown')}</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col sm:flex-row items-center gap-2 shrink-0 ml-2">
                            ${task.user_id == window.App.user.id ? `
                                <button class="edit-main-task-btn text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 p-1">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="delete-main-task-btn text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 p-1">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            ` : ''}
                        </div>
                    </div>
                </div>
            `).join('');
        }

        function switchView(viewName) {
            const views = {
                'statistics': document.getElementById('statistics-dashboard'),
                'client': document.getElementById('client-content'),
                'user-management': document.getElementById('user-management-dashboard')
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
            if (manageUsersBtn) {
                if (viewName === 'user-management') {
                    manageUsersBtn.classList.add('active');
                } else {
                    manageUsersBtn.classList.remove('active');
                }
            }

            // Sync data on view switch
            if (viewName === 'statistics') {
                loadStatistics();
            } else if (viewName === 'user-management') {
                loadUserDashboardData();
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
            if (!container) return;
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

            selectedMainTaskTitle.textContent = task.title;
            selectedMainTaskDescription.textContent = task.description || 'No description';
            selectedMainTaskInfo.classList.remove('hidden');
            addSubtaskBtn.disabled = false;
            currentMainTaskId = taskId;
            
            renderSubtasks(task.subtasks || []);

            if (window.innerWidth < 1024) {
                document.getElementById('subtasks-list').scrollIntoView({ behavior: 'smooth' });
            }
            
            const breadcrumbEl = document.getElementById('breadcrumb-client-name');
            const clientName = breadcrumbEl.textContent.split(' > ')[0];
            breadcrumbEl.textContent = `${clientName} > ${task.title}`;
            
            currentSubtaskId = null;
            subtaskDetailView.classList.add('hidden');
            subtasksList.classList.remove('hidden');
            subtaskForm.classList.add('hidden');
            subtaskCommentsSection.classList.add('hidden');
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
            
            container.innerHTML = subtasks.map(s => `
                <div class="subtask-item p-4 border border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors" data-subtask-id="${s.id}">
                    <div class="flex items-start justify-between">
                        <div class="flex items-start space-x-3">
                            <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg flex items-center justify-center shrink-0 mt-0.5">
                                <i class="fas fa-pencil-alt"></i>
                            </div>
                            <div>
                                <h5 class="font-medium text-gray-800 dark:text-white">${s.title}</h5>
                                <div class="flex flex-wrap items-center text-sm text-gray-600 dark:text-gray-200 gap-x-3 gap-y-1 mt-0.5">
                                    <div class="flex items-center"><i class="fas fa-clock mr-1.5"></i><span>${s.total_time_logged || 0}h total</span></div>
                                    <div class="flex items-center"><i class="fas fa-calendar-alt mr-1.5"></i><span>${s.work_date}</span></div>
                                </div>
                                <div class="mt-1.5 flex items-center text-xs text-blue-600 dark:text-blue-400">
                                    <i class="fas fa-user-circle mr-1.5 text-[10px]"></i>
                                    <span>Created by: ${s.user_id == window.App.user.id ? 'You' : (s.user ? s.user.name : 'Unknown')}</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col sm:flex-row items-center gap-2 shrink-0 ml-2">
                            ${s.user_id == window.App.user.id ? `
                                <button class="edit-subtask-btn text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 p-1"><i class="fas fa-edit"></i></button>
                                <button class="delete-subtask-btn text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 p-1"><i class="fas fa-trash-alt"></i></button>
                            ` : ''}
                        </div>
                    </div>
                </div>
            `).join('');
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
                        ${log.user_id == window.App.user.id ? `
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
                            ${c.user_id == window.App.user.id ? `
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
                } else {
                    const url = '{{ route('dashboard.comments.update', ['comment' => ':id']) }}'.replace(':id', currentCommentId);
                    const result = await apiCall(url, 'PUT', { comment });
                    const subtask = findSubtask(currentSubtaskId);
                    const idx = subtask.comments.findIndex(c => c.id == currentCommentId);
                    if (idx !== -1) subtask.comments[idx] = result.comment;
                    renderComments(subtask.comments);
                    showSuccessNotification(result.message);
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
    </script>
