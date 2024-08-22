<nav class="hidden-print">
    <div class="sidebar-button">
        <i class="bx bx-menu sidebarBtn"></i>
        <span class="dashboard">
            @yield('title')
        </span>
    </div>
    <div class="search-box" id="searchBox">
        <div class="search-container">
            <form id="searchForm" action="" method="GET">
                <input type="text" id="searchInput" name="query" placeholder="Recherche..." required />
                <button type="submit" style="border:none;background:none;">
                    <i class="bx bx-search"></i>
                </button>
            </form>
        </div>
    </div>
    <img class='image' src="{{ asset('image/logo.jpeg') }}" alt="Logo">
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var currentPath = window.location.pathname;
        var searchForm = document.getElementById('searchForm');
        var searchBox = document.getElementById('searchBox');

        // Exclure les factures de la logique de recherche et masquer l'input de recherche
        if (currentPath.includes('facture')) {
            searchForm.action = "#"; // Ne pas définir d'action pour les factures
            searchBox.style.display = 'none'; // Masquer l'input de recherche
        } else if (currentPath.includes('fournisseur')) {
            searchForm.action = "{{ route('fournisseurs.search') }}";
        } else if (currentPath.includes('utilisateur')) {
            searchForm.action = "{{ route('utilisateurs.search') }}";
        } else if (currentPath.includes('categorie')) {
            searchForm.action = "{{ route('categories.search') }}";
        } else if (currentPath.includes('commande')) {
            searchForm.action = "{{ route('commandes.search') }}";
        } else if (currentPath.includes('article')) {
            searchForm.action = "{{ route('articles.search') }}";
        } else {
            searchForm.action = "#"; // Optionnel: si aucune correspondance, ne rien faire
        }
    });
</script>

</nav>
<style>
    /* General styles for nav */
    .hide-search {
        display: none;
    }
    .search-box {
        display: flex;
        align-items: center; /* Align items vertically */
        justify-content: center; /* Center content horizontally */
        padding-right: 70px; /* Space for the fixed image */
        background-color: #fff; /* Adjust based on your design */
        position: fixed;
    }

    /* Style for the fixed image */
    .image {
        margin-left:1000px;
        position: fixed;
    }

    nav #searchForm {
        
        display: flex;
        align-items: center; /* Align items vertically */
        
    }

    nav #searchInput {
        padding: 10px; /* Adjust padding as needed */
        border: 1px solid #ccc; /* Optional: Add border */
        border-radius: 4px; /* Optional: Add border-radius */
        margin-right: 5px; /* Space between input and button */
        width: 350px;
    }
    nav button {
        margin-right:300px;
    }
    .bx-search{
        margin-right:290px;
    }

</style>