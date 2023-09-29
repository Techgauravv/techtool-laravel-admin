<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-10">
            {{-- <i class="fas fa-university"></i> --}}
            <img class="img-profile rounded-circle"
                src="{{ asset('storage/user_image/GX8VVEARwCMwOK68pfp4vTjr1Eao0jKQvN60Xd5V.jpg') }}" width="60px">
        </div>
        <div class="sidebar-brand-text mx-3" style="min-width: fit-content;"> Baltech Tool
        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Management
    </div>

    @hasrole('Admin')
        <!-- Nav Item - Pages Collapse Menu  User Management-->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#taTpDropDown"
                aria-expanded="true" aria-controls="taTpDropDown">
                <i class="fas fa-user-alt"></i>
                <span>User Management</span>
            </a>
            <div id="taTpDropDown" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">User Management:</h6>
                    <a class="collapse-item" href="{{ route('users.index') }}">List</a>
                    <a class="collapse-item" href="{{ route('users.create') }}">Add New</a>
                    <a class="collapse-item" href="{{ route('users.import') }}">Import Data</a>
                </div>
            </div>
        </li>
    @endhasrole

    <!-- Nav Item - Pages Collapse Menu  Project Management-->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#projectManagementDropdown"
            aria-expanded="false" aria-controls="projectManagementDropdown">
            <i class="fas fa-project-diagram"></i>
            <span>Project Management</span>
        </a>
        <div id="projectManagementDropdown" class="collapse" aria-labelledby="headingProjectManagement"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Project Management:</h6>
                <a class="collapse-item" href="#">List</a>
                <a class="collapse-item" href="{{ route('projects.create') }}">Add New</a>
                {{-- <a class="collapse-item" href="{{ route('projects.import') }}">Import Data</a> --}}
            </div>
        </div>
    </li>

    <!-- Nav Item - Pages Collapse Menu  Client Management-->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#clientManagementDropdown"
            aria-expanded="false" aria-controls="clientManagementDropdown">
            <i class="fas fa-user-tie"></i>
            <span>Client Management</span>
        </a>
        <div id="clientManagementDropdown" class="collapse" aria-labelledby="headingClientManagement"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Client Management:</h6>
                <a class="collapse-item" href="{{ route('clients.index') }}">List</a>
                <a class="collapse-item" href="{{ route('clients.create') }}">Add New</a>
                {{-- <a class="collapse-item" href="{{ route('projects.import') }}">Import Data</a> --}}
            </div>
        </div>
    </li>

    <!-- Nav Item - Pages Collapse Menu  Task Management-->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#taskManagementDropdown"
            aria-expanded="false" aria-controls="taskManagementDropdown">
            <i class="fas fa-tasks"></i>
            <span>Task Management</span>
        </a>
        <div id="taskManagementDropdown" class="collapse" aria-labelledby="headingTaskManagement"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Task Management:</h6>
                <a class="collapse-item" href="#">List</a>
                <a class="collapse-item" href="#">Add New</a>
                {{-- <a class="collapse-item" href="#">Import Data</a> --}}
            </div>
        </div>
    </li>

    <!-- Nav Item - Pages Collapse Menu  Leave Management-->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#leaveManagementDropdown"
            aria-expanded="false" aria-controls="leaveManagementDropdown">
            <i class="fas fa-house-user"></i>
            <span>Leave Management</span>
        </a>
        <div id="leaveManagementDropdown" class="collapse" aria-labelledby="headingLeaveManagement"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Leave Management:</h6>
                <a class="collapse-item" href="#">List</a>
                <a class="collapse-item" href="#">Add New</a>
                {{-- <a class="collapse-item" href="#">Import Data</a> --}}
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    @hasrole('Admin')
        <!-- Heading -->
        <div class="sidebar-heading">
            Admin Section
        </div>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                aria-expanded="true" aria-controls="collapsePages">
                <i class="fas fa-fw fa-folder"></i>
                <span>Masters</span>
            </a>
            <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Role & Permissions</h6>
                    <a class="collapse-item" href="{{ route('roles.index') }}">Roles</a>
                    <a class="collapse-item" href="{{ route('permissions.index') }}">Permissions</a>
                </div>
            </div>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">
    @endhasrole

    <li class="nav-item">
        <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </li>
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>


</ul>
