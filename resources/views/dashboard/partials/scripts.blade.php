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
        const clientItems = document.querySelectorAll('.client-item');
        const clientSearch = document.getElementById('client-search');
        const addClientBtn = document.getElementById('add-client-btn');
        const quickAddClientBtn = document.getElementById('quick-add-client-btn');
        const addFirstClientBtn = document.getElementById('add-first-client-btn');
        const viewAllClientsBtn = document.getElementById('view-all-clients-btn');
        const clientSelectionPrompt = document.getElementById('client-selection-prompt');
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
        const cancelTimeLogBtn = document.getElementById('cancel-time-log-btn');
        const timeLogValue = document.getElementById('time-log-value');
        const timeLogsList = document.getElementById('time-logs-list');
        const subtaskDetailView = document.getElementById('subtask-detail-view');
        const detailSubtaskTitle = document.getElementById('detail-subtask-title');
        
        // State variables
        let currentClientId = window.App.selectedClient ? window.App.selectedClient.id : null;
        let editingClientId = null;
        let currentMainTaskId = null;
        let currentSubtaskId = null;
        let currentCommentId = null;
        let deleteCallback = null;
        let currentDeleteType = null;
        
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
            
            // Show initial state
            if (window.App.selectedClient) {
                showClientContent();
                // Optionally load main tasks if they aren't already in App.selectedClient
                renderMainTasks(window.App.selectedClient.main_tasks || []);
                
                // Set join date for initial client
                const joinDate = new Date(window.App.selectedClient.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                document.getElementById('client-join-date').textContent = joinDate;
            } else {
                showClientSelectionPrompt();
            }
        }
        
        // Set up all event listeners
        function setupEventListeners() {
            // Theme toggle
            themeToggle.addEventListener('click', toggleDarkMode);
            
            // User dropdown
            userMenuButton.addEventListener('click', toggleUserDropdown);
            
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

            document.addEventListener('click', (e) => {
                if (!userMenuButton.contains(e.target) && !userDropdown.contains(e.target)) {
                    userDropdown.classList.add('hidden');
                }
            });
            
            // Client selection (Delegation)
            document.getElementById('clients-list-container').addEventListener('click', (e) => {
                const item = e.target.closest('.client-item');
                if (item) selectClient(item);
            });
            
            // Client search
            clientSearch.addEventListener('input', filterClients);
            
            // Add client buttons
            addClientBtn.addEventListener('click', () => openClientModal('add'));
            quickAddClientBtn.addEventListener('click', () => openClientModal('add'));
            addFirstClientBtn.addEventListener('click', () => openClientModal('add'));
            
            // View all clients
            viewAllClientsBtn.addEventListener('click', () => {
                clientSearch.value = '';
                filterClients();
            });
            
            // Client modal
            closeClientModal.addEventListener('click', () => closeClientModalFunc());
            cancelClientBtn.addEventListener('click', () => closeClientModalFunc());
            clientForm.addEventListener('submit', handleClientFormSubmit);
            
            // Edit and delete client buttons
            editClientBtn.addEventListener('click', () => {
                const client = window.App.clients.find(c => c.id == currentClientId);
                if (client) openClientModal('edit', client.id, client.name);
            });
            deleteClientBtn.addEventListener('click', () => {
                const client = window.App.clients.find(c => c.id == currentClientId);
                if (client) openConfirmationModal('client', client.name, deleteCurrentClient);
            });
            
            // Confirmation modal
            cancelConfirmationBtn.addEventListener('click', () => closeConfirmationModal());
            
            // Main task buttons
            addMainTaskBtn.addEventListener('click', () => openMainTaskForm('add'));
            cancelMainTaskBtn.addEventListener('click', resetMainTaskForm);
            saveMainTaskBtn.addEventListener('click', saveMainTask);
            updateMainTaskBtn.addEventListener('click', updateMainTask);
            
            // Task status buttons logic removed
            
            // Main task list event delegation
            document.getElementById('main-tasks-list').addEventListener('click', (e) => {
                const item = e.target.closest('.main-task-item');
                if (!item) return;

                if (e.target.closest('.edit-main-task-btn')) {
                    e.stopPropagation();
                    const taskId = item.getAttribute('data-task-id');
                    const task = findMainTask(taskId);
                    if (task) openMainTaskForm('edit', task.id, task.title, task.description);
                } else if (e.target.closest('.delete-main-task-btn')) {
                    e.stopPropagation();
                    const taskId = item.getAttribute('data-task-id');
                    const task = findMainTask(taskId);
                    if (task) openConfirmationModal('main task', task.title, () => deleteMainTask(taskId));
                } else {
                    selectMainTask(item);
                }
            });
            
            // Subtask buttons
            addSubtaskBtn.addEventListener('click', () => openSubtaskForm('add'));
            
            // Profile & Security listeners
            if (profileBtn) profileBtn.addEventListener('click', openProfileModal);
            if (closeProfileModal) closeProfileModal.addEventListener('click', closeProfileModalFunc);
            if (cancelProfileBtn) cancelProfileBtn.addEventListener('click', closeProfileModalFunc);
            if (profileForm) profileForm.addEventListener('submit', handleProfileUpdate);
            if (passwordForm) passwordForm.addEventListener('submit', handlePasswordUpdate);
            cancelSubtaskBtn.addEventListener('click', resetSubtaskForm);
            saveSubtaskBtn.addEventListener('click', saveSubtask);
            updateSubtaskBtn.addEventListener('click', updateSubtask);
            changeMainTaskBtn.addEventListener('click', () => resetMainTaskSelection());
            
            // Subtasks list event delegation
            document.getElementById('subtasks-container').addEventListener('click', (e) => {
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
            
            // Comment buttons
            addCommentBtn.addEventListener('click', () => openCommentForm('add'));
            cancelCommentBtn.addEventListener('click', resetCommentForm);
            saveCommentBtn.addEventListener('click', saveComment);
            
            // Comments list event delegation
            document.getElementById('comments-list').addEventListener('click', (e) => {
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

            // Back to subtasks button
            document.getElementById('back-to-subtasks-btn').addEventListener('click', () => {
                subtaskDetailView.classList.add('hidden');
                subtasksList.classList.remove('hidden');
                currentSubtaskId = null;
            });

            // Time Log Events
            addTimeLogBtn.addEventListener('click', () => {
                timeLogForm.classList.remove('hidden');
                timeLogValue.focus();
            });
            cancelTimeLogBtn.addEventListener('click', () => {
                timeLogForm.classList.add('hidden');
                timeLogValue.value = '';
            });
            saveTimeLogBtn.addEventListener('click', saveTimeLog);
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
        
        // Client functionality
        async function selectClient(clientItem) {
            const clientId = clientItem.getAttribute('data-client-id');
            if (clientId == currentClientId) return;

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
                    selectedClientStatus.innerHTML = `<span class="w-2 h-2 bg-blue-500 rounded-full mr-2"></span>Active`;
                    
                    renderMainTasks(client.main_tasks || []);
                    
                    const joinDate = new Date(client.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                    document.getElementById('client-join-date').textContent = joinDate;
                    
                    document.getElementById('breadcrumb-client-name').textContent = client.name;
                    
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
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg flex items-center justify-center">
                                <i class="fas fa-project-diagram"></i>
                            </div>
                            <div>
                                <h5 class="font-medium text-gray-800 dark:text-white">${task.title}</h5>
                                <p class="text-sm text-gray-600 dark:text-gray-400">${task.description || 'No description'}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="hidden md:block text-xs bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 px-2 py-1 rounded">By: ${task.user ? task.user.name : 'Unknown'}</span>
                            <button class="edit-main-task-btn text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 p-1">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="delete-main-task-btn text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 p-1">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        function filterClients() {
            const searchTerm = clientSearch.value.toLowerCase();
            let visibleCount = 0;
            
            const items = document.querySelectorAll('.client-item');
            items.forEach(item => {
                const clientName = item.querySelector('h3').textContent.toLowerCase();
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
        
        function showClientSelectionPrompt() {
            clientSelectionPrompt.classList.remove('hidden');
            clientContent.classList.add('hidden');
            document.getElementById('breadcrumb-nav').classList.add('hidden');
        }
        
        function showClientContent() {
            clientSelectionPrompt.classList.add('hidden');
            clientContent.classList.remove('hidden');
            document.getElementById('breadcrumb-nav').classList.remove('hidden');
        }
        
        function openClientModal(mode, clientId = null, clientName = '') {
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
            }
            clientModal.classList.remove('hidden');
        }
        
        function closeClientModalFunc() {
            clientModal.classList.add('hidden');
        }
        
        async function handleClientFormSubmit(e) {
            e.preventDefault();
            const name = document.getElementById('client-name').value;
            
            try {
                if (!editingClientId) {
                    const result = await apiCall('/dashboard/clients', 'POST', { name });
                    window.App.clients.push(result.client);
                    showSuccessNotification(result.message);
                    renderClientsList();
                } else {
                    const result = await apiCall(`/dashboard/clients/${editingClientId}`, 'PUT', { name });
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
            } catch (error) {}
        }

        async function deleteCurrentClient() {
            if (!currentClientId) return;
            
            try {
                const result = await apiCall(`/dashboard/clients/${currentClientId}`, 'DELETE');
                window.App.clients = window.App.clients.filter(c => c.id != currentClientId);
                
                showSuccessNotification(result.message);
                renderClientsList();
                
                currentClientId = null;
                showClientSelectionPrompt();
                closeConfirmationModal();
            } catch (error) {}
        }
        
        function renderClientsList() {
            const container = document.getElementById('clients-list-container');
            container.innerHTML = window.App.clients.map(client => `
                <div class="client-item p-4 ${currentClientId == client.id ? 'bg-blue-50 dark:bg-blue-900/20 border-blue-200 dark:border-blue-800' : 'bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700'} border rounded-lg cursor-pointer transition-all hover:shadow-md" data-client-id="${client.id}">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                            <h3 class="font-semibold text-gray-800 dark:text-white">${client.name}</h3>
                        </div>
                        <span class="text-xs bg-blue-100 dark:bg-blue-800 text-blue-800 dark:text-blue-200 px-2 py-1 rounded">Active</span>
                    </div>
                </div>
            `).join('');
        }
        
        // Main task functionality
        function openMainTaskForm(mode, taskId = null, title = '', description = '') {
            if (mode === 'add') {
                mainTaskTitle.value = '';
                mainTaskDescription.value = '';
                saveMainTaskBtn.classList.remove('hidden');
                updateMainTaskBtn.classList.add('hidden');
                document.getElementById('main-task-id-display').textContent = 'New Task';
            } else if (mode === 'edit') {
                mainTaskTitle.value = title;
                mainTaskDescription.value = description;
                saveMainTaskBtn.classList.add('hidden');
                updateMainTaskBtn.classList.remove('hidden');
                document.getElementById('main-task-id-display').textContent = `Task ID: ${taskId}`;
                currentMainTaskId = taskId;
            }
            mainTaskForm.classList.remove('hidden');
        }
        
        function resetMainTaskForm() {
            mainTaskForm.classList.add('hidden');
            mainTaskTitle.value = '';
            mainTaskDescription.value = '';
        }
        
        async function saveMainTask() {
            const title = mainTaskTitle.value;
            const description = mainTaskDescription.value;
            if (!title.trim()) return showErrorNotification('Please enter a task title');
            
            try {
                const result = await apiCall('/dashboard/main-tasks', 'POST', {
                    client_id: currentClientId,
                    title,
                    description
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
            } catch (error) {}
        }
        
        async function updateMainTask() {
            const title = mainTaskTitle.value;
            const description = mainTaskDescription.value;
            if (!title.trim()) return showErrorNotification('Please enter a task title');
            
            try {
                const result = await apiCall(`/dashboard/main-tasks/${currentMainTaskId}`, 'PUT', {
                    title,
                    description
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
                renderClientsList();
                showSuccessNotification(result.message);
                resetMainTaskForm();
            } catch (error) {}
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
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg flex items-center justify-center">
                                <i class="fas fa-pencil-alt"></i>
                            </div>
                            <div>
                                <h5 class="font-medium text-gray-800 dark:text-white">${s.title}</h5>
                                <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                    <i class="fas fa-clock mr-1"></i><span>${s.total_time_logged || 0} hours total</span>
                                    <i class="fas fa-calendar-alt mx-2"></i><span>${s.work_date}</span>
                                    <span class="ml-2 hidden lg:inline-block text-xs italic bg-gray-100 dark:bg-gray-700 px-2 py-0.5 rounded">By: ${s.user ? s.user.name : 'Unknown'}</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button class="edit-subtask-btn text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 p-1"><i class="fas fa-edit"></i></button>
                            <button class="delete-subtask-btn text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 p-1"><i class="fas fa-trash-alt"></i></button>
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
                const result = await apiCall(`/dashboard/main-tasks/${taskId}`, 'DELETE');
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
        }
        
        function resetSubtaskForm() {
            subtaskForm.classList.add('hidden');
            subtasksList.classList.remove('hidden');
            currentSubtaskId = null;
        }
        
        async function saveSubtask() {
            const title = subtaskTitle.value;
            const description = subtaskDescription.value;
            const work_date = subtaskWorkDate.value;
            if (!title.trim()) return showErrorNotification('Please enter a subtask title');
            
            try {
                const result = await apiCall('/dashboard/subtasks', 'POST', {
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
            }
        }
        
        async function updateSubtask() {
            const title = subtaskTitle.value;
            const description = subtaskDescription.value;
            const work_date = subtaskWorkDate.value;
            if (!title.trim()) return showErrorNotification('Please enter a subtask title');
            
            try {
                const result = await apiCall(`/dashboard/subtasks/${currentSubtaskId}`, 'PUT', {
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
            }
        }
        
        function selectSubtask(subtaskItem) {
            const subtaskId = subtaskItem.getAttribute('data-subtask-id');
            const subtask = findSubtask(subtaskId);
            if (!subtask) return;

            currentSubtaskId = subtaskId;
            detailSubtaskTitle.textContent = subtask.title;
            
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
                        <span class="text-xs text-gray-500 dark:text-gray-400">${new Date(log.created_at).toLocaleDateString()} by ${log.user ? log.user.name : 'User'}</span>
                    </div>
                    <button onclick="deleteTimeLog(${log.id})" class="text-red-500 hover:text-red-700 p-1">
                        <i class="fas fa-trash-alt text-xs"></i>
                    </button>
                </div>
            `).join('');
        }

        async function saveTimeLog() {
            const val = timeLogValue.value;
            if (!val || val <= 0) return showErrorNotification('Please enter a valid amount of time');
            
            try {
                const result = await apiCall('/dashboard/time-logs', 'POST', {
                    sub_task_id: currentSubtaskId,
                    time: val
                });
                
                const subtask = findSubtask(currentSubtaskId);
                if (!subtask.time_logs) subtask.time_logs = [];
                subtask.time_logs.push(result.time_log);
                
                subtask.total_time_logged = (parseFloat(subtask.total_time_logged) || 0) + parseFloat(val);
                
                renderTimeLogs(subtask.time_logs);
                renderSubtasks(findMainTask(currentMainTaskId).subtasks);
                timeLogValue.value = '';
                timeLogForm.classList.add('hidden');
                showSuccessNotification(result.message);
            } catch (error) {
                console.error('Save time log error:', error);
            }
        }

        function deleteTimeLog(id) {
            const subtask = findSubtask(currentSubtaskId);
            if (!subtask) return;
            const log = subtask.time_logs.find(l => l.id == id);
            if (!log) return;

            openConfirmationModal('time log', `${log.time} hours`, async () => {
                try {
                    const result = await apiCall(`/dashboard/time-logs/${id}`, 'DELETE');
                    
                    subtask.total_time_logged = (parseFloat(subtask.total_time_logged) || 0) - parseFloat(log.time);
                    
                    subtask.time_logs = subtask.time_logs.filter(l => l.id != id);
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
                                <p class="font-medium text-gray-800 dark:text-white">${c.user ? c.user.name : 'Unknown User'}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">${new Date(c.created_at).toLocaleString()}</p>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <button class="edit-comment-btn text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300"><i class="fas fa-edit"></i></button>
                            <button class="delete-comment-btn text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300"><i class="fas fa-trash-alt"></i></button>
                        </div>
                    </div>
                    <p class="mt-3 text-gray-700 dark:text-gray-300">${c.comment}</p>
                </div>
            `).join('');
        }

        async function deleteSubtask(subtaskId) {
            try {
                const result = await apiCall(`/dashboard/subtasks/${subtaskId}`, 'DELETE');
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
        
        async function saveComment() {
            const comment = commentText.value;
            if (!comment.trim()) return showErrorNotification('Please enter a comment');
            
            try {
                if (!currentCommentId) {
                    const result = await apiCall('/dashboard/comments', 'POST', {
                        sub_task_id: currentSubtaskId,
                        comment
                    });
                    const subtask = findSubtask(currentSubtaskId);
                    if (!subtask.comments) subtask.comments = [];
                    subtask.comments.push(result.comment);
                    renderComments(subtask.comments);
                    showSuccessNotification(result.message);
                } else {
                    const result = await apiCall(`/dashboard/comments/${currentCommentId}`, 'PUT', { comment });
                    const subtask = findSubtask(currentSubtaskId);
                    const idx = subtask.comments.findIndex(c => c.id == currentCommentId);
                    if (idx !== -1) subtask.comments[idx] = result.comment;
                    renderComments(subtask.comments);
                    showSuccessNotification(result.message);
                }
                resetCommentForm();
            } catch (error) {}
        }
        
        // Profile & Security
        function openProfileModal() {
            profileModal.classList.remove('hidden');
            userDropdown.classList.add('hidden');
            document.body.classList.add('overflow-hidden');
            passwordForm.reset();
        }

        function closeProfileModalFunc() {
            profileModal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        async function handleProfileUpdate(e) {
            e.preventDefault();
            const name = document.getElementById('profile-name').value;
            const email = document.getElementById('profile-email').value;

            try {
                const result = await apiCall('/profile', 'PATCH', { name, email });
                
                document.querySelectorAll('.font-medium.text-gray-800.dark\\:text-white').forEach(el => {
                    if (el.textContent === window.App.user.name) {
                        el.textContent = name;
                    }
                });
                
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
                const result = await apiCall('/password', 'PUT', { 
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
                const result = await apiCall(`/dashboard/comments/${commentId}`, 'DELETE');
                const subtask = findSubtask(currentSubtaskId);
                subtask.comments = subtask.comments.filter(c => c.id != commentId);
                renderComments(subtask.comments);
                showSuccessNotification(result.message);
                closeConfirmationModal();
            } catch (error) {}
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
            confirmationTitle.textContent = `Delete ${type.charAt(0).toUpperCase() + type.slice(1)}`;
            confirmationMessage.textContent = `Are you sure you want to delete "${name}"? This action cannot be undone.`;
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
        
        confirmDeleteBtn.addEventListener('click', () => {
            if (deleteCallback) deleteCallback();
        });
    </script>
