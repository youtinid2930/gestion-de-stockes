<nav class="hidden-print">
    <div class="sidebar-button">
        <i class="bx bx-menu sidebarBtn"></i>
        <span class="dashboard">
            @yield('title')
        </span>
    </div>
    <div class="search-box">
        <form id="searchForm" action="" method="GET">
            <input type="text" id="searchInput" name="query" placeholder="Recherche..." required />
            <button type="submit" style="border:none;background:none;">
                <i class="bx bx-search"></i>
            </button>
        </form>
    </div>
    <img class='image' src="{{ asset('image/logo.jpeg') }}">
    <i class="bx bx-chevron-down"></i>
</nav>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var currentPath = window.location.pathname;
        var searchForm = document.getElementById('searchForm');

        if (currentPath.includes('fournisseur')) {
            searchForm.action = "{{ route('fournisseurs.search') }}";
        } else if (currentPath.includes('utilisateur')) {
            searchForm.action = "{{ route('utilisateurs.search') }}";
        } else if (currentPath.includes('categorie')) {
            searchForm.action = "{{ route('categories.search') }}";
        } else if (currentPath.includes('commande')) {
            searchForm.action = "{{ route('commandes.search') }}";
        } else {
            searchForm.action = "#"; // Optionnel: si aucune correspondance, ne rien faire
        }
    });
</script>
