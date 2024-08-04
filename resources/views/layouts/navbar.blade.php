<nav class="hidden-print">
    <div class="sidebar-button">
        <i class="bx bx-menu sidebarBtn"></i>
        <span class="dashboard">
            {{ ucfirst(str_replace('.php', '', basename($_SERVER['PHP_SELF']))) }}
        </span>
    </div>
    <div class="search-box">
        <input type="text" placeholder="Recherche..." />
        <i class="bx bx-search"></i>
    </div>
    <img class='image' src="{{ asset('image/logo.jpeg') }}">
    <i class="bx bx-chevron-down"></i>
</nav>