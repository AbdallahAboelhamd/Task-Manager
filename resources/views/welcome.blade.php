<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-gray-200 shadow-sm">
            <div class="p-6">
                <h1 class="text-2xl font-bold text-gray-900">TaskFlow</h1>
                <p class="text-sm text-gray-600 mt-1">Task Management</p>
            </div>
            <nav class="px-4 py-6 space-y-2">
                <div class="mb-6">
                    <h2 class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Navigation</h2>
                    <button onclick="switchView('tasks')" class="w-full text-left block px-4 py-2 text-gray-900 font-medium hover:bg-blue-50 rounded-lg transition view-btn" data-view="tasks">
                        <svg class="inline-block w-5 h-5 mr-3 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 1 1 0 000 2H3a1 1 0 00-1 1v10a1 1 0 001 1h14a1 1 0 001-1V6a1 1 0 00-1-1h3a1 1 0 000-2h-2.09A2 2 0 0013 3h-2a2 2 0 00-2-2H9a2 2 0 00-2 2H4.09A2 2 0 002 5v10a2 2 0 002 2h12a2 2 0 002-2V5z" clip-rule="evenodd"></path></svg>
                        Tasks
                    </button>
                    <button onclick="switchView('projects')" class="w-full text-left block px-4 py-2 text-gray-700 font-medium hover:bg-gray-100 rounded-lg transition view-btn" data-view="projects">
                        <svg class="inline-block w-5 h-5 mr-3 text-gray-600" fill="currentColor" viewBox="0 0 20 20"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        Projects
                    </button>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar -->
            <header class="bg-white border-b border-gray-200 shadow-sm px-8 py-4">
                <div class="flex items-center justify-between gap-4">
                    <!-- Search -->
                    <div class="flex-1 max-w-md" id="searchContainer">
                        <input 
                            type="text" 
                            id="searchInput"
                            placeholder="Search..." 
                            class="w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                    </div>

                    <!-- Filters - Tasks View -->
                    <div class="flex items-center gap-3" id="filtersContainer">
                        <div>
                            <label class="text-sm text-gray-600 mr-2">Status:</label>
                            <select 
                                id="statusFilter"
                                class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white"
                            >
                                <option value="">All Statuses</option>
                                <option value="todo">To Do</option>
                                <option value="in_progress">In Progress</option>
                                <option value="done">Done</option>
                            </select>
                        </div>

                        <div>
                            <label class="text-sm text-gray-600 mr-2">Priority:</label>
                            <select 
                                id="priorityFilter"
                                class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white"
                            >
                                <option value="">All Priorities</option>
                                <option value="low">Low</option>
                                <option value="medium">Medium</option>
                                <option value="high">High</option>
                            </select>
                        </div>

                        <!-- Create Task Button -->
                        <button 
                            id="createTaskBtn"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition"
                        >
                            + Create Task
                        </button>
                    </div>

                    <!-- Create Project Button - Projects View -->
                    <button 
                        id="createProjectBtn"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition hidden"
                    >
                        + Create Project
                    </button>
                </div>
            </header>

            <!-- Tasks View -->
            <div class="flex-1 overflow-auto px-8 py-6 view-content" id="tasksView">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Title</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Description</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Project</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Due Date</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Priority</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="tasksTableBody" class="divide-y divide-gray-200"></tbody>
                    </table>
                    <div id="emptyStateTasks" class="text-center py-12 hidden">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No tasks found</h3>
                        <p class="mt-1 text-sm text-gray-500">Get started by creating a new task</p>
                    </div>
                </div>
            </div>

            <!-- Projects View -->
            <div class="flex-1 overflow-auto px-8 py-6 view-content hidden" id="projectsView">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Description</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tasks Count</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="projectsTableBody" class="divide-y divide-gray-200"></tbody>
                    </table>
                    <div id="emptyStateProjects" class="text-center py-12 hidden">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No projects found</h3>
                        <p class="mt-1 text-sm text-gray-500">Get started by creating a new project</p>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Task Modal -->
    <div 
        id="taskModal" 
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50"
    >
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6 mx-4">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-900">Create New Task</h2>
                <button 
                    type="button"
                    onclick="document.getElementById('taskModal').classList.add('hidden')"
                    class="text-gray-400 hover:text-gray-600 transition"
                >
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form id="taskForm" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Task Title</label>
                    <input 
                        type="text" 
                        id="taskTitle"
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Enter task title"
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea 
                        id="taskDescription"
                        rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Enter task description"
                    ></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Project</label>
                    <select 
                        id="taskProject"
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white"
                    >
                        <option value="">Select a project</option>
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Due Date</label>
                        <input 
                            type="date" 
                            id="taskDueDate"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select 
                            id="taskStatus"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white"
                        >
                            <option value="todo">To Do</option>
                            <option value="in_progress">In Progress</option>
                            <option value="done">Done</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Priority</label>
                    <select 
                        id="taskPriority"
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white"
                    >
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                    </select>
                </div>

                <div class="flex gap-3 pt-4">
                    <button 
                        type="button"
                        onclick="document.getElementById('taskModal').classList.add('hidden')"
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition"
                    >
                        Cancel
                    </button>
                    <button 
                        type="submit"
                        class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded-lg text-sm font-medium text-white transition"
                    >
                        Create Task
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Project Modal -->
    <div 
        id="projectModal" 
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50"
    >
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6 mx-4">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-900">Create New Project</h2>
                <button 
                    type="button"
                    onclick="document.getElementById('projectModal').classList.add('hidden')"
                    class="text-gray-400 hover:text-gray-600 transition"
                >
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form id="projectForm" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Project Name</label>
                    <input 
                        type="text" 
                        id="projectName"
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Enter project name"
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea 
                        id="projectDescription"
                        rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Enter project description"
                    ></textarea>
                </div>

                <div class="flex gap-3 pt-4">
                    <button 
                        type="button"
                        onclick="document.getElementById('projectModal').classList.add('hidden')"
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition"
                    >
                        Cancel
                    </button>
                    <button 
                        type="submit"
                        class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded-lg text-sm font-medium text-white transition"
                    >
                        Create Project
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let currentView = 'tasks';
        let allTasks = [];
        let allProjects = [];

        const taskModal = document.getElementById('taskModal');
        const projectModal = document.getElementById('projectModal');
        const createTaskBtn = document.getElementById('createTaskBtn');
        const createProjectBtn = document.getElementById('createProjectBtn');
        const taskForm = document.getElementById('taskForm');
        const projectForm = document.getElementById('projectForm');
        const tasksTableBody = document.getElementById('tasksTableBody');
        const projectsTableBody = document.getElementById('projectsTableBody');
        const searchInput = document.getElementById('searchInput');
        const statusFilter = document.getElementById('statusFilter');
        const priorityFilter = document.getElementById('priorityFilter');
        const emptyStateTasks = document.getElementById('emptyStateTasks');
        const emptyStateProjects = document.getElementById('emptyStateProjects');
        const filtersContainer = document.getElementById('filtersContainer');
        const searchContainer = document.getElementById('searchContainer');

        // Switch view
        function switchView(view) {
            currentView = view;
            document.querySelectorAll('.view-btn').forEach(btn => btn.classList.remove('text-blue-600', 'bg-blue-50'));
            document.querySelector(`[data-view="${view}"]`).classList.add('text-blue-600', 'bg-blue-50');
            
            document.querySelectorAll('.view-content').forEach(el => el.classList.add('hidden'));
            document.getElementById(`${view}View`).classList.remove('hidden');
            
            createTaskBtn.classList.toggle('hidden', view !== 'tasks');
            createProjectBtn.classList.toggle('hidden', view !== 'projects');
            filtersContainer.classList.toggle('hidden', view !== 'tasks');

            if (view === 'tasks') loadTasks();
            else loadProjects();
        }

        // Load tasks from API
        async function loadTasks() {
            try {
                const response = await fetch('/api/tasks', {
                    headers: { 'Accept': 'application/json' }
                });
                if (!response.ok) throw new Error('Failed to load tasks');
                const responseData = await response.json();
                allTasks = responseData.Data?.data || responseData.Data || [];
                renderTasks();
            } catch (error) {
                console.error('Error loading tasks:', error);
                allTasks = [];
                renderTasks();
            }
        }

        // Load projects from API
        async function loadProjects() {
            try {
                const response = await fetch('/api/projects', {
                    headers: { 'Accept': 'application/json' }
                });
                if (!response.ok) throw new Error('Failed to load projects');
                const responseData = await response.json();
                allProjects = responseData.Data?.data || responseData.Data || [];
                renderProjects();
            } catch (error) {
                console.error('Error loading projects:', error);
                allProjects = [];
                renderProjects();
            }
        }

        // Format date
        function formatDate(dateStr) {
            if (!dateStr) return 'No date';
            const date = new Date(dateStr);
            return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
        }

        // Get status badge color
        function getStatusColor(status) {
            switch(status) {
                case 'todo': return 'bg-gray-100 text-gray-800';
                case 'in_progress': return 'bg-blue-100 text-blue-800';
                case 'done': return 'bg-green-100 text-green-800';
                default: return 'bg-gray-100 text-gray-800';
            }
        }

        // Get priority badge color
        function getPriorityColor(priority) {
            switch(priority) {
                case 'low': return 'bg-blue-100 text-blue-800';
                case 'medium': return 'bg-yellow-100 text-yellow-800';
                case 'high': return 'bg-red-100 text-red-800';
                default: return 'bg-gray-100 text-gray-800';
            }
        }

        // Capitalize text
        function capitalize(str) {
            return str.charAt(0).toUpperCase() + str.slice(1).replace('_', ' ');
        }

        // Render tasks
        function renderTasks() {
            const searchTerm = searchInput.value.toLowerCase();
            const statusFilterValue = statusFilter.value;
            const priorityFilterValue = priorityFilter.value;

            const filteredTasks = allTasks.filter(task => {
                const matchesSearch = task.title.toLowerCase().includes(searchTerm) ||
                                    (task.description && task.description.toLowerCase().includes(searchTerm));
                const matchesStatus = !statusFilterValue || task.status === statusFilterValue;
                const matchesPriority = !priorityFilterValue || task.priority === priorityFilterValue;
                return matchesSearch && matchesStatus && matchesPriority;
            });

            if (filteredTasks.length === 0) {
                tasksTableBody.innerHTML = '';
                emptyStateTasks.classList.remove('hidden');
                return;
            }

            emptyStateTasks.classList.add('hidden');
            tasksTableBody.innerHTML = filteredTasks.map(task => `
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">${task.title}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">${task.description || '-'}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">${task.project?.name || '-'}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">${formatDate(task.due_date)}</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full ${getStatusColor(task.status)}">
                            ${capitalize(task.status)}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full ${getPriorityColor(task.priority)}">
                            ${capitalize(task.priority)}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm">
                        <button onclick="deleteTask(${task.id})" class="text-red-600 hover:text-red-800 font-medium transition">
                            Delete
                        </button>
                    </td>
                </tr>
            `).join('');
        }

        // Render projects
        function renderProjects() {
            if (allProjects.length === 0) {
                projectsTableBody.innerHTML = '';
                emptyStateProjects.classList.remove('hidden');
                return;
            }

            emptyStateProjects.classList.add('hidden');
            projectsTableBody.innerHTML = allProjects.map(project => `
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">${project.name}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">${project.description || '-'}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">${project.tasks_count || 0}</td>
                    <td class="px-6 py-4 text-sm">
                        <button onclick="deleteProject(${project.id})" class="text-red-600 hover:text-red-800 font-medium transition">
                            Delete
                        </button>
                    </td>
                </tr>
            `).join('');
        }

        // Load projects for dropdown in task form
        async function loadProjectsForForm() {
            try {
                const response = await fetch('/api/projects', {
                    headers: { 'Accept': 'application/json' }
                });
                if (!response.ok) throw new Error('Failed to load projects');
                const responseData = await response.json();
                const projects = responseData.Data?.data || responseData.Data || [];
                const select = document.getElementById('taskProject');
                select.innerHTML = '<option value="">Select a project</option>';
                projects.forEach(project => {
                    const option = document.createElement('option');
                    option.value = project.id;
                    option.textContent = project.name;
                    select.appendChild(option);
                });
            } catch (error) {
                console.error('Error loading projects:', error);
            }
        }

        // Create task
        taskForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = {
                title: document.getElementById('taskTitle').value,
                description: document.getElementById('taskDescription').value,
                project_id: document.getElementById('taskProject').value,
                due_date: document.getElementById('taskDueDate').value || null,
                status: document.getElementById('taskStatus').value,
                priority: document.getElementById('taskPriority').value
            };

            try {
                const response = await fetch('/api/tasks', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(formData)
                });

                if (!response.ok) throw new Error('Failed to create task');
                taskModal.classList.add('hidden');
                taskForm.reset();
                await loadTasks();
            } catch (error) {
                alert('Error creating task: ' + error.message);
            }
        });

        // Create project
        projectForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = {
                name: document.getElementById('projectName').value,
                description: document.getElementById('projectDescription').value
            };

            try {
                const response = await fetch('/api/projects', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(formData)
                });

                if (!response.ok) throw new Error('Failed to create project');
                projectModal.classList.add('hidden');
                projectForm.reset();
                await loadProjects();
                await loadProjectsForForm();
            } catch (error) {
                alert('Error creating project: ' + error.message);
            }
        });

        // Delete task
        async function deleteTask(id) {
            if (!confirm('Are you sure you want to delete this task?')) return;
            try {
                const response = await fetch(`/api/tasks/${id}`, { method: 'DELETE' });
                if (!response.ok) throw new Error('Failed to delete task');
                await loadTasks();
            } catch (error) {
                alert('Error deleting task: ' + error.message);
            }
        }

        // Delete project
        async function deleteProject(id) {
            if (!confirm('Are you sure you want to delete this project?')) return;
            try {
                const response = await fetch(`/api/projects/${id}`, { method: 'DELETE' });
                if (!response.ok) throw new Error('Failed to delete project');
                await loadProjects();
            } catch (error) {
                alert('Error deleting project: ' + error.message);
            }
        }

        // Event listeners
        createTaskBtn.addEventListener('click', async () => {
            await loadProjectsForForm();
            taskModal.classList.remove('hidden');
            taskForm.reset();
        });

        createProjectBtn.addEventListener('click', () => {
            projectModal.classList.remove('hidden');
            projectForm.reset();
        });

        searchInput.addEventListener('input', () => {
            if (currentView === 'tasks') renderTasks();
        });

        statusFilter.addEventListener('change', renderTasks);
        priorityFilter.addEventListener('change', renderTasks);

        // Initial load
        document.querySelector('[data-view="tasks"]').classList.add('text-blue-600', 'bg-blue-50');
        loadTasks();
    </script>
</body>
</html>
