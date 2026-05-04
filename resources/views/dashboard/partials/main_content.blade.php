            <main id="main-content" class="flex-1 overflow-y-auto p-6 bg-gray-50 dark:bg-gray-900 transition-all duration-300">
                <!-- Statistics Dashboard -->
                <div id="statistics-dashboard" class="h-full flex flex-col p-4 md:p-8 animate-fadeIn">
                    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 md:mb-8 gap-4">
                        <div>
                            <h2 class="text-xl md:text-2xl font-bold text-gray-800 dark:text-white flex items-center">
                                <i class="fas fa-chart-line mr-3 text-blue-600"></i>
                                <span id="stat-dashboard-title">{{ auth()->user()->isAdmin() ? 'System Overview' : 'Personal Productivity' }}</span>
                            </h2>
                            <p id="stat-dashboard-subtitle" class="text-xs md:text-base text-gray-500 dark:text-gray-400 mt-1">
                                {{ auth()->user()->isAdmin() ? 'Activity oversight for all members' : 'Activity summary for ' . auth()->user()->name }}
                            </p>
                        </div>
                        @if(auth()->user()->isAdmin())
                        <div class="flex flex-wrap items-center gap-3 self-start md:self-auto">
                            <button onclick="switchView('developer-tasks')" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 md:px-5 md:py-2.5 rounded-lg md:rounded-xl font-bold transition-all shadow-lg hover:shadow-purple-500/20 flex items-center whitespace-nowrap text-sm md:text-base">
                                <i class="fas fa-tasks mr-2 text-sm md:text-lg"></i> View Task Board
                            </button>
                            <button onclick="document.getElementById('add-client-btn').click()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 md:px-5 md:py-2.5 rounded-lg md:rounded-xl font-bold transition-all shadow-lg hover:shadow-blue-500/20 flex items-center whitespace-nowrap text-sm md:text-base">
                                <i class="fas fa-user-plus mr-2 text-sm md:text-lg"></i> New Client
                            </button>
                        </div>
                        @endif
                    </div>
                    
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3 md:gap-6 mb-6 md:mb-8">
                        <!-- Time Logs Section -->
                        <div class="bg-gradient-to-br from-blue-50 to-white dark:from-blue-900/10 dark:to-gray-800 p-3 md:p-6 rounded-xl md:rounded-2xl border border-blue-100 dark:border-blue-800/50 shadow-sm">
                            <div class="flex items-center justify-between mb-2 md:mb-4">
                                <span class="bg-blue-100 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400 text-[10px] md:text-xs font-bold px-2 py-0.5 md:px-3 md:py-1 rounded-full uppercase tracking-wider">Today</span>
                                <div class="flex items-center gap-2">
                                    @if(auth()->user()->isAdmin())
                                    <button onclick="showActivityDetails('today', 'time')" class="text-blue-500 hover:text-blue-700 transition-colors" title="View Breakdown">
                                        <i class="fas fa-circle-arrow-right text-lg"></i>
                                    </button>
                                    @endif
                                    <i class="fas fa-clock text-blue-500 text-sm md:text-base"></i>
                                </div>
                            </div>
                            <h3 id="stat-time-today" class="text-xl md:text-3xl font-bold text-gray-800 dark:text-white">0.0h</h3>
                            <p id="stat-time-today-desc" class="text-gray-500 dark:text-gray-400 text-[10px] md:text-sm mt-1">Logged today</p>
                        </div>

                        <div class="bg-gradient-to-br from-indigo-50 to-white dark:from-indigo-900/10 dark:to-gray-800 p-3 md:p-6 rounded-xl md:rounded-2xl border border-indigo-100 dark:border-indigo-800/50 shadow-sm">
                            <div class="flex items-center justify-between mb-2 md:mb-4">
                                <span class="bg-indigo-100 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-400 text-[10px] md:text-xs font-bold px-2 py-0.5 md:px-3 md:py-1 rounded-full uppercase tracking-wider">This Week</span>
                                <div class="flex items-center gap-2">
                                    @if(auth()->user()->isAdmin())
                                    <button onclick="showActivityDetails('week', 'time')" class="text-indigo-500 hover:text-indigo-700 transition-colors" title="View Breakdown">
                                        <i class="fas fa-circle-arrow-right text-lg"></i>
                                    </button>
                                    @endif
                                    <i class="fas fa-calendar-week text-indigo-500 text-sm md:text-base"></i>
                                </div>
                            </div>
                            <h3 id="stat-time-week" class="text-xl md:text-3xl font-bold text-gray-800 dark:text-white">0.0h</h3>
                            <p id="stat-time-week-desc" class="text-gray-500 dark:text-gray-400 text-[10px] md:text-sm mt-1">Weekly total</p>
                        </div>

                        <div class="bg-gradient-to-br from-purple-50 to-white dark:from-purple-900/10 dark:to-gray-800 p-3 md:p-6 rounded-xl md:rounded-2xl border border-purple-100 dark:border-purple-800/50 shadow-sm col-span-2 md:col-span-1">
                            <div class="flex items-center justify-between mb-2 md:mb-4">
                                <span class="bg-purple-100 dark:bg-purple-900/40 text-purple-600 dark:text-purple-400 text-[10px] md:text-xs font-bold px-2 py-0.5 md:px-3 md:py-1 rounded-full uppercase tracking-wider">This Month</span>
                                <div class="flex items-center gap-2">
                                    @if(auth()->user()->isAdmin())
                                    <button onclick="showActivityDetails('month', 'time')" class="text-purple-500 hover:text-purple-700 transition-colors" title="View Breakdown">
                                        <i class="fas fa-circle-arrow-right text-lg"></i>
                                    </button>
                                    @endif
                                    <i class="fas fa-calendar-alt text-purple-500 text-sm md:text-base"></i>
                                </div>
                            </div>
                            <h3 id="stat-time-month" class="text-xl md:text-3xl font-bold text-gray-800 dark:text-white">0.0h</h3>
                            <p id="stat-time-month-desc" class="text-gray-500 dark:text-gray-400 text-[10px] md:text-sm mt-1">Monthly total</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3 md:gap-6">
                        <!-- Comments Section -->
                        <div class="bg-gradient-to-br from-green-50 to-white dark:from-green-900/10 dark:to-gray-800 p-3 md:p-6 rounded-xl md:rounded-2xl border border-green-100 dark:border-green-800/50 shadow-sm">
                            <div class="flex items-center justify-between mb-2 md:mb-4">
                                <span class="bg-green-100 dark:bg-green-900/40 text-green-600 dark:text-green-400 text-[10px] md:text-xs font-bold px-2 py-0.5 md:px-3 md:py-1 rounded-full uppercase tracking-wider">Today</span>
                                <div class="flex items-center gap-2">
                                    @if(auth()->user()->isAdmin())
                                    <button onclick="showActivityDetails('today', 'comments')" class="text-green-500 hover:text-green-700 transition-colors" title="View Breakdown">
                                        <i class="fas fa-circle-arrow-right text-lg"></i>
                                    </button>
                                    @endif
                                    <i class="fas fa-comment-dots text-green-500 text-sm md:text-base"></i>
                                </div>
                            </div>
                            <h3 id="stat-comments-today" class="text-xl md:text-3xl font-bold text-gray-800 dark:text-white">0</h3>
                            <p id="stat-comments-today-desc" class="text-gray-500 dark:text-gray-400 text-[10px] md:text-sm mt-1">Comments posted</p>
                        </div>

                        <div class="bg-gradient-to-br from-teal-50 to-white dark:from-teal-900/10 dark:to-gray-800 p-3 md:p-6 rounded-xl md:rounded-2xl border border-teal-100 dark:border-teal-800/50 shadow-sm">
                            <div class="flex items-center justify-between mb-2 md:mb-4">
                                <span class="bg-teal-100 dark:bg-teal-900/40 text-teal-600 dark:text-teal-400 text-[10px] md:text-xs font-bold px-2 py-0.5 md:px-3 md:py-1 rounded-full uppercase tracking-wider">This Week</span>
                                <div class="flex items-center gap-2">
                                    @if(auth()->user()->isAdmin())
                                    <button onclick="showActivityDetails('week', 'comments')" class="text-teal-500 hover:text-teal-700 transition-colors" title="View Breakdown">
                                        <i class="fas fa-circle-arrow-right text-lg"></i>
                                    </button>
                                    @endif
                                    <i class="fas fa-comments text-teal-500 text-sm md:text-base"></i>
                                </div>
                            </div>
                            <h3 id="stat-comments-week" class="text-xl md:text-3xl font-bold text-gray-800 dark:text-white">0</h3>
                            <p id="stat-comments-week-desc" class="text-gray-500 dark:text-gray-400 text-[10px] md:text-sm mt-1">Weekly discussion</p>
                        </div>

                        <div class="bg-gradient-to-br from-cyan-50 to-white dark:from-cyan-900/10 dark:to-gray-800 p-3 md:p-6 rounded-xl md:rounded-2xl border border-cyan-100 dark:border-cyan-800/50 shadow-sm col-span-2 md:col-span-1">
                            <div class="flex items-center justify-between mb-2 md:mb-4">
                                <span class="bg-cyan-100 dark:bg-cyan-900/40 text-cyan-600 dark:text-cyan-400 text-[10px] md:text-xs font-bold px-2 py-0.5 md:px-3 md:py-1 rounded-full uppercase tracking-wider">This Month</span>
                                <div class="flex items-center gap-2">
                                    @if(auth()->user()->isAdmin())
                                    <button onclick="showActivityDetails('month', 'comments')" class="text-cyan-500 hover:text-cyan-700 transition-colors" title="View Breakdown">
                                        <i class="fas fa-circle-arrow-right text-lg"></i>
                                    </button>
                                    @endif
                                    <i class="fas fa-comment-medical text-cyan-500 text-sm md:text-base"></i>
                                </div>
                            </div>
                            <h3 id="stat-comments-month" class="text-xl md:text-3xl font-bold text-gray-800 dark:text-white">0</h3>
                            <p id="stat-comments-month-desc" class="text-gray-500 dark:text-gray-400 text-[10px] md:text-sm mt-1">Monthly total</p>
                        </div>
                    </div>
                    
                    <!-- Recent Activity Section (For Developers / Quick View) -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-12">
                        <div id="personal-activity-dashboard">
                            <div class="flex items-center justify-between mb-6">
                                    <h3 class="text-lg font-black text-gray-900 dark:text-white uppercase tracking-tight">
                                        {{ auth()->user()->isAdmin() ? 'Global Activity Feed' : 'Recent Activity' }}
                                    </h3>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 font-bold uppercase tracking-widest mt-1">
                                        {{ auth()->user()->isAdmin() ? 'Latest contributions across the system' : 'Your latest contributions' }}
                                    </p>
                                <button onclick="switchView('reports')" class="text-xs font-black text-blue-600 hover:text-blue-700 uppercase tracking-widest transition-colors">
                                    View Full Report <i class="fas fa-arrow-right ml-1"></i>
                                </button>
                            </div>
                            
                            <div class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden min-h-[300px]">
                                <div class="overflow-x-auto">
                                    <table class="w-full text-left border-collapse">
                                        <thead class="bg-gray-50/50 dark:bg-gray-900/30">
                                            <tr>
                                                <th class="px-6 py-4 text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest">Date</th>
                                                <th class="px-6 py-4 text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest">Project / Task</th>
                                                <th class="px-6 py-4 text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest text-right">Hours</th>
                                            </tr>
                                        </thead>
                                        <tbody id="personal-activity-table-body" class="divide-y divide-gray-50 dark:divide-gray-700">
                                            <tr>
                                                <td colspan="3" class="px-6 py-8 text-center text-gray-400 dark:text-gray-500 text-sm italic">
                                                    Select a timeframe to view your latest records.
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- New: Recent Task Discussions -->
                        <div id="recent-discussions-dashboard">
                            <div class="flex items-center justify-between mb-6">
                                <div>
                                    <h3 class="text-lg font-black text-gray-900 dark:text-white uppercase tracking-tight">
                                        {{ auth()->user()->isAdmin() ? 'Global Task Discussions' : 'Recent Task Discussions' }}
                                    </h3>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 font-bold uppercase tracking-widest mt-1">
                                        {{ auth()->user()->isAdmin() ? 'Latest messages on shared tasks' : 'Latest messages on your tasks' }}
                                    </p>
                                </div>
                                <button onclick="switchView('developer-tasks')" class="text-xs font-black text-indigo-600 hover:text-indigo-700 uppercase tracking-widest transition-colors">
                                    {{ auth()->user()->isAdmin() ? 'Manage Tasks' : 'All Assigned Tasks' }} <i class="fas fa-arrow-right ml-1"></i>
                                </button>
                            </div>

                            <div class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden min-h-[300px]">
                                <div id="recent-discussions-container" class="p-4 space-y-4">
                                    <div class="flex flex-col items-center justify-center py-10 text-center opacity-40">
                                        <i class="fas fa-comments text-3xl mb-3 text-gray-400"></i>
                                        <p class="text-xs font-bold text-gray-500 uppercase tracking-widest">No recent discussions</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Activity Reports Section -->
                <div id="reports-section" class="h-full flex flex-col p-4 md:p-8 animate-fadeIn hidden">
                    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-6">
                        <div>
                            <h2 class="text-2xl font-black text-gray-900 dark:text-white flex items-center">
                                <i class="fas fa-file-invoice mr-3 text-blue-600"></i>
                                Activity Reports
                            </h2>
                             <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Generate and export detailed work logs</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <button onclick="exportReportToCSV()" class="flex items-center gap-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 px-5 py-2.5 rounded-2xl text-sm font-bold text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 transition-all shadow-sm">
                                <i class="fas fa-file-csv text-emerald-500"></i> Export CSV
                            </button>
                        </div>
                    </div>

                    <!-- Report Controls -->
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm mb-8">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                            @if(auth()->user()->isAdmin())
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest pl-1">Report Type</label>
                                <div class="relative">
                                    <select id="report-type-select" onchange="handleReportTypeChange()" class="w-full appearance-none bg-gray-50 dark:bg-gray-700 border-none rounded-2xl pl-4 pr-10 py-3 text-sm font-bold text-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-blue-500/20 transition-all cursor-pointer">
                                        <option value="user">Developer Report</option>
                                        <option value="client">Client Report</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center">
                                        <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                                    </div>
                                </div>
                            </div>
                            <div id="report-target-container" class="space-y-2">
                                <label id="report-target-label" class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest pl-1">Target Developer</label>
                                <div class="relative">
                                    <select id="report-target-select" class="w-full appearance-none bg-gray-50 dark:bg-gray-700 border-none rounded-2xl pl-4 pr-10 py-3 text-sm font-bold text-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-blue-500/20 transition-all cursor-pointer">
                                        <option value="">All Developers</option>
                                        @foreach(\App\Models\User::all() as $u)
                                            <option value="{{ $u->id }}">{{ $u->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center">
                                        <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest pl-1">Time Period</label>
                                <div class="relative">
                                    <select id="report-period-select" onchange="handleReportPeriodChange()" class="w-full appearance-none bg-gray-50 dark:bg-gray-700 border-none rounded-2xl pl-4 pr-10 py-3 text-sm font-bold text-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-blue-500/20 transition-all cursor-pointer">
                                        <option value="today">Today</option>
                                        <option value="week" selected>This Week</option>
                                        <option value="month">This Month</option>
                                        <option value="custom">Custom Range</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center">
                                        <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                                    </div>
                                </div>
                            </div>

                            <div id="report-custom-date-container" class="grid grid-cols-2 gap-3 hidden">
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest pl-1">Start</label>
                                    <input type="date" id="report-start-date" class="w-full bg-gray-50 dark:bg-gray-700 border-none rounded-2xl px-4 py-3 text-sm font-bold text-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-blue-500/20 transition-all">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest pl-1">End</label>
                                    <input type="date" id="report-end-date" class="w-full bg-gray-50 dark:bg-gray-700 border-none rounded-2xl px-4 py-3 text-sm font-bold text-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-blue-500/20 transition-all">
                                </div>
                            </div>

                            <div class="flex items-end">
                                <button onclick="loadReportsData(1)" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold h-[48px] rounded-2xl shadow-lg shadow-blue-500/20 transition-all hover:scale-[1.02] active:scale-[0.98]">
                                    Generate Report
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Summary Section -->
                    <div id="report-summary-container" class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-gradient-to-br from-blue-500 to-indigo-600 p-6 rounded-3xl shadow-xl shadow-blue-500/20 text-white">
                            <p class="text-[10px] font-black uppercase tracking-widest opacity-70 mb-2">Total Time Tracked</p>
                            <h4 id="report-summary-hours" class="text-3xl font-black">0.0h</h4>
                        </div>
                        <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm">
                            <p class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-2">Tasks Completed</p>
                            <h4 id="report-summary-tasks" class="text-3xl font-black text-gray-900 dark:text-white">0</h4>
                        </div>
                        <div id="report-summary-extra-card" class="bg-white dark:bg-gray-800 p-6 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm">
                            <p id="report-summary-extra-label" class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-2">Contributors</p>
                            <h4 id="report-summary-extra-value" class="text-3xl font-black text-gray-900 dark:text-white">0</h4>
                        </div>
                    </div>

                    <!-- Main Report Table -->
                    <div class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden flex-1 flex flex-col min-h-[400px]">
                        <div class="overflow-x-auto flex-1">
                            <table class="w-full text-left border-collapse">
                                <thead class="bg-gray-50 dark:bg-gray-900/50 sticky top-0 z-10">
                                    <tr>
                                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest">Date</th>
                                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest">Client / Task</th>
                                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest">User</th>
                                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest">Description</th>
                                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest text-right">Hours</th>
                                    </tr>
                                </thead>
                                <tbody id="report-table-body" class="divide-y divide-gray-100 dark:divide-gray-700">
                                    <!-- Rows injected by JS -->
                                </tbody>
                            </table>
                        </div>

                        <!-- Empty State -->
                        <div id="report-empty-state" class="hidden flex-1 flex flex-col items-center justify-center p-12 text-center">
                            <div class="w-20 h-20 bg-gray-50 dark:bg-gray-900/50 rounded-full flex items-center justify-center mb-4">
                                <i class="fas fa-search text-3xl text-gray-300 dark:text-gray-600"></i>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-2">No activity found</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Try adjusting your filters or date range.</p>
                        </div>

                        <!-- Table Footer / Pagination -->
                        <div id="report-pagination" class="px-6 py-4 bg-gray-50 dark:bg-gray-900/30 border-t border-gray-100 dark:border-gray-700 flex items-center justify-between">
                            <span id="report-pagination-info" class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Showing 0 of 0 records</span>
                            <div class="flex items-center gap-2">
                                <button id="report-prev-page" class="p-2 rounded-xl border border-gray-200 dark:border-gray-700 text-gray-400 hover:bg-white dark:hover:bg-gray-800 transition-all disabled:opacity-30 disabled:pointer-events-none">
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                                <div id="report-pages" class="flex items-center gap-1">
                                    <!-- Dynamic pagination numbers -->
                                </div>
                                <button id="report-next-page" class="p-2 rounded-xl border border-gray-200 dark:border-gray-700 text-gray-400 hover:bg-white dark:hover:bg-gray-800 transition-all disabled:opacity-30 disabled:pointer-events-none">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            </div>
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
                            <div class="flex items-start justify-between mb-6">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800 dark:text-white">Main Tasks</h3>
                                    <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">Create and manage main tasks for this client</p>
                                </div>
                                <button id="add-main-task-btn" class="flex items-center bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg transition-all shadow-md group" title="Add Task (T)">
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
                                
                                @if(auth()->user()->isAdmin())
                                <div class="mb-6">
                                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Assign Developers</label>
                                    <div id="main-task-assign-users" class="max-h-40 overflow-y-auto p-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg space-y-2 custom-scrollbar">
                                        <!-- Populated via JS -->
                                    </div>
                                    <p class="mt-2 text-[10px] text-gray-500 dark:text-gray-400">Selected developers will see this task in their dashboard.</p>
                                </div>
                                @endif
                                
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
                                        <!-- Icon with animated background -->
                                        <div class="relative mx-auto w-24 h-24 mb-6">
                                            <div class="absolute inset-0 bg-blue-100 dark:bg-blue-900/20 rounded-full animate-pulse"></div>
                                            <div class="relative w-full h-full bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-gray-700 dark:to-gray-600 rounded-full flex items-center justify-center border-4 border-white dark:border-gray-800 shadow-lg">
                                                <i class="fas fa-clipboard-list text-4xl text-blue-500 dark:text-blue-400"></i>
                                            </div>
                                        </div>
                                        
                                        <!-- Helpful guidance text -->
                                        <h5 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-2">No Tasks Yet</h5>
                                        <p class="text-sm text-gray-600 dark:text-gray-300 mb-4 max-w-md mx-auto">Click on a task from the list above to view and manage its subtasks</p>
                                        
                                        <!-- Visual hint with arrow/pointer -->
                                        <div class="flex items-center justify-center gap-2 text-xs text-gray-500 dark:text-gray-400 mt-6">
                                            <i class="fas fa-hand-pointer text-blue-500 dark:text-blue-400 animate-bounce"></i>
                                            <span>Select a task to get started</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Right Panel: Subtask Management -->
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-4 sm:p-6 border border-gray-200 dark:border-gray-700">
                            <div class="flex items-start justify-between mb-6">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800 dark:text-white">Subtasks</h3>
                                    <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">Manage subtasks for the selected main task</p>
                                </div>
                                <button id="add-subtask-btn" class="flex items-center bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-lg transition-all shadow-md disabled:opacity-50 disabled:cursor-not-allowed group" disabled title="Add Subtask (S)">
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
                                    <div class="flex items-center space-x-2 mb-2 text-gray-500 dark:text-gray-300">
                                        <i class="fas fa-align-left text-[10px]"></i>
                                        <span class="text-[9px] font-bold uppercase tracking-widest">Description</span>
                                    </div>
                                    <p id="detail-subtask-description" class="text-gray-700 dark:text-gray-200 text-sm leading-relaxed whitespace-pre-line break-words max-h-32 overflow-y-auto custom-scrollbar pr-1"></p>
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
                                        
                                        <!-- Modernized Comment Input Bar -->
                                        <div id="comment-form" class="mb-6 hidden">
                                            <div class="relative bg-gray-50 dark:bg-gray-800/50 rounded-2xl border border-gray-200 dark:border-gray-700 transition-all focus-within:ring-2 focus-within:ring-blue-500/20 focus-within:border-blue-500 overflow-hidden">
                                                <!-- Image Preview Container (Inside the bar) -->
                                                <div id="comment-image-preview" class="flex flex-wrap gap-2 px-4 pt-3 empty:hidden"></div>
                                                
                                                <div class="flex items-end p-2 gap-2">
                                                    <!-- Attachment Button -->
                                                    <label class="flex items-center justify-center w-10 h-10 rounded-xl bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-500 dark:text-gray-400 cursor-pointer transition-colors shrink-0">
                                                        <i class="fas fa-plus text-sm"></i>
                                                        <input type="file" id="comment-images" multiple accept="image/*" class="hidden" onchange="handleCommentImageSelect(this)">
                                                    </label>

                                                    <!-- Textarea -->
                                                    <textarea id="comment-text" rows="1" 
                                                        class="w-full bg-transparent border-none focus:ring-0 text-sm py-2.5 px-2 max-h-32 resize-none dark:text-white" 
                                                        placeholder="Add Comments"
                                                        oninput="this.style.height = ''; this.style.height = this.scrollHeight + 'px'"
                                                        onkeydown="if(event.key === 'Enter' && !event.shiftKey) { event.preventDefault(); document.getElementById('save-comment-btn').click(); }"></textarea>

                                                    <!-- Submit Button -->
                                                    <button id="save-comment-btn" class="flex items-center justify-center w-10 h-10 rounded-xl bg-blue-600 hover:bg-blue-700 text-white transition-all shrink-0 shadow-lg shadow-blue-500/20 disabled:opacity-50 disabled:shadow-none">
                                                        <i class="fas fa-arrow-up text-sm"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="flex justify-end mt-2">
                                                <button id="cancel-comment-btn" class="text-[10px] font-bold uppercase tracking-widest text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
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

                <!-- User Management Dashboard -->
                <div id="user-management-dashboard" class="h-full flex flex-col p-4 md:p-8 animate-fadeIn hidden">
                    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-6">
                        <div>
                            <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">User Management</h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">View and manage system users, their access status, and fine-grained permissions.</p>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="relative group w-full md:w-72">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400 group-focus-within:text-indigo-500 transition-colors">
                                    <i class="fas fa-search text-xs"></i>
                                </div>
                                <input type="text" id="user-dashboard-search" placeholder="Search users by name or email..." class="w-full pl-10 pr-4 py-2.5 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm shadow-sm transition-all italic">
                            </div>
                            <button id="dashboard-add-user-btn" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl font-bold transition-all shadow-lg shadow-indigo-500/20 flex items-center whitespace-nowrap text-sm">
                                <i class="fas fa-user-plus mr-2"></i> New User
                            </button>
                        </div>
                    </div>

                    <!-- User Filter Tabs -->
                    <div class="flex items-center border-b border-gray-200 dark:border-gray-800 mb-8 gap-8 overflow-x-auto no-scrollbar">
                        <button onclick="switchUserDashboardTab('active')" id="user-tab-active" class="user-dashboard-tab relative pb-4 text-sm font-bold text-indigo-600 dark:text-indigo-400 transition-all">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-user-check text-xs"></i>
                                <span>Active Users</span>
                                <span id="active-user-count" class="ml-1 px-2 py-0.5 bg-indigo-50 dark:bg-indigo-900/40 rounded-full text-[10px]">0</span>
                            </div>
                            <div class="absolute bottom-0 left-0 right-0 h-1 bg-indigo-600 dark:bg-indigo-500 rounded-t-full"></div>
                        </button>
                        <button onclick="switchUserDashboardTab('deactivated')" id="user-tab-deactivated" class="user-dashboard-tab relative pb-4 text-sm font-bold text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 transition-all">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-user-slash text-xs"></i>
                                <span>Deactivated</span>
                                <span id="deactivated-user-count" class="ml-1 px-2 py-0.5 bg-gray-50 dark:bg-gray-700 rounded-full text-[10px]">0</span>
                            </div>
                            <div class="absolute bottom-0 left-0 right-0 h-1 bg-transparent rounded-t-full"></div>
                        </button>
                    </div>

                    <!-- Users Table -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700/50 overflow-hidden flex-1 flex flex-col">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-gray-50/50 dark:bg-gray-900/20 border-b border-gray-100 dark:border-gray-700/50">
                                        <th class="px-6 py-4 text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">User Info</th>
                                        <th class="px-6 py-4 text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Role</th>
                                        <th class="px-6 py-4 text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest text-center">Status</th>
                                        <th class="px-6 py-4 text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Joined At</th>
                                        <th class="px-6 py-4 text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="user-dashboard-table-body" class="divide-y divide-gray-50 dark:divide-gray-700/50">
                                    <!-- Dynamic Rows -->
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Empty State -->
                        <div id="user-dashboard-empty" class="hidden flex-1 flex flex-col items-center justify-center p-12 text-center animate-fadeIn">
                            <div class="w-20 h-20 bg-gray-50 dark:bg-gray-800/50 rounded-full flex items-center justify-center mb-6">
                                <i class="fas fa-users text-3xl text-gray-300 dark:text-gray-600"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-2">No users found</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 max-w-xs mx-auto">Try adjusting your filters or search query to find the users you're looking for.</p>
                        </div>
                    </div>
                </div>
                <!-- Developer Assigned Tasks Dashboard -->
                <div id="assigned-tasks-dashboard" class="h-full flex flex-col p-4 md:p-8 animate-fadeIn hidden">
                    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-6">
                        <div>
                            <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">
                                {{ auth()->user()->isAdmin() ? 'Task Management' : 'My Assigned Tasks' }}
                            </h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                {{ auth()->user()->isAdmin() ? 'Oversee and track shared tasks across all developers.' : 'Focus on your direct responsibilities and track your progress.' }}
                            </p>
                        </div>
                        <div class="flex items-center gap-2 md:gap-4">
                            @if(auth()->user()->isAdmin())
                            <button onclick="openAssignTaskModal()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-1.5 rounded-xl font-bold transition-all shadow-lg shadow-indigo-500/20 flex items-center whitespace-nowrap text-xs">
                                <i class="fas fa-plus-circle mr-2"></i> Assign Task
                            </button>
                            @endif
                            <div class="flex bg-gray-100 dark:bg-gray-800 p-1 rounded-xl border border-gray-200 dark:border-gray-700 relative z-50">
                                <button onclick="filterDevTasks('all')" id="dev-task-filter-all" class="cursor-pointer relative dev-task-filter px-4 py-1.5 rounded-lg text-xs font-bold transition-all bg-white dark:bg-gray-700 text-indigo-600 dark:text-indigo-400 shadow-sm">All</button>
                                <button onclick="filterDevTasks('pending')" id="dev-task-filter-pending" class="cursor-pointer relative dev-task-filter px-4 py-1.5 rounded-lg text-xs font-bold text-gray-500 dark:text-gray-400 transition-all hover:text-gray-700 dark:hover:text-gray-200">Pending</button>
                                <button onclick="filterDevTasks('completed')" id="dev-task-filter-completed" class="cursor-pointer relative dev-task-filter px-4 py-1.5 rounded-lg text-xs font-bold text-gray-500 dark:text-gray-400 transition-all hover:text-gray-700 dark:hover:text-gray-200">Completed</button>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="dev-tasks-container">
                        <!-- Tasks will be rendered here dynamically -->
                    </div>

                    <div id="dev-tasks-empty" class="hidden flex-1 flex flex-col items-center justify-center p-12 text-center animate-fadeIn">
                        <div class="w-20 h-20 bg-gray-50 dark:bg-gray-800/50 rounded-full flex items-center justify-center mb-6">
                            <i class="fas fa-clipboard-check text-3xl text-gray-300 dark:text-gray-600"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-2">No tasks found</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 max-w-xs mx-auto">You don't have any tasks matching this filter right now.</p>
                    </div>
                </div>
            </main>

            <!-- User Management Modal (Create/Edit) -->
            <div id="admin-user-modal" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm hidden animate-fadeIn">
                <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden border border-white/20 dark:border-gray-700/50 transform transition-all duration-300 scale-100">
                    <div class="px-8 py-6 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between bg-gray-50/50 dark:bg-gray-900/20">
                        <div>
                            <h3 id="admin-user-modal-title" class="text-xl font-bold text-gray-900 dark:text-white">Create New User</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Fill in the details to add a new system member.</p>
                        </div>
                        <button onclick="closeAdminUserModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors">
                            <i class="fas fa-times text-lg"></i>
                        </button>
                    </div>

                    <form id="dashboard-user-form" class="p-8">
                        <div class="space-y-6">
                            <!-- Name & Email -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-2">Full Name</label>
                                    <input type="text" id="db-user-name" required class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm transition-all" placeholder="John Doe">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-2">Email Address</label>
                                    <input type="email" id="db-user-email" required class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm transition-all" placeholder="john@example.com">
                                </div>
                            </div>

                            <!-- Role & Status -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-2">System Role</label>
                                    <input type="text" id="db-user-role" required class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm transition-all" placeholder="e.g. Developer, Super Admin">
                                </div>
                                <div id="db-user-status-container" class="hidden">
                                    <label class="block text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-2">Account Status</label>
                                    <select id="db-user-status" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm transition-all">
                                        <option value="active">Active</option>
                                        <option value="inactive">Deactivated</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Generated Password Display (Only on Create) -->
                            <div id="db-password-display" class="hidden animate-slideDown">
                                <div class="p-4 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-2xl">
                                    <div class="flex items-center gap-2 mb-3 text-amber-700 dark:text-amber-400">
                                        <i class="fas fa-key text-xs"></i>
                                        <span class="text-xs font-bold uppercase tracking-wider">Generated Password</span>
                                    </div>
                                    <div class="flex gap-2">
                                        <input type="text" id="db-generated-password" readonly class="flex-1 bg-white dark:bg-gray-800 border-none rounded-lg px-3 py-2 font-mono text-sm text-center tracking-widest">
                                        <button type="button" onclick="copyDBPassword()" class="bg-amber-500 hover:bg-amber-600 text-white px-4 rounded-lg transition-all text-xs font-bold whitespace-nowrap">
                                            Copy
                                        </button>
                                    </div>
                                    <p class="text-[10px] text-amber-600/80 dark:text-amber-400/60 mt-3 text-center italic">Important: Copy this password now. It will not be shown again.</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-4 mt-10">
                            <button type="button" onclick="closeAdminUserModal()" class="flex-1 px-6 py-3.5 border border-gray-200 dark:border-gray-700 rounded-2xl text-gray-600 dark:text-gray-400 font-bold hover:bg-gray-50 dark:hover:bg-gray-900/50 transition-all text-sm">
                                Cancel
                            </button>
                            <button type="submit" id="db-save-user-btn" class="flex-1 px-6 py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-bold shadow-xl shadow-indigo-500/20 transition-all text-sm">
                                Save User
                            </button>
                            <button type="submit" id="db-update-user-btn" class="flex-1 px-6 py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-2xl font-bold shadow-xl shadow-emerald-500/20 transition-all text-sm hidden">
                                Update User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
