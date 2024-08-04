<!-- resources/views/layouts/sidebar.blade.php -->
<div class="sidebar hidden-print">
    @csrf
    <ul class="nav-links">
        <li>
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bx bx-grid-alt"></i>
                <span class="links_name">Dashboard</span>
            </a>
        </li>
        <li>
            <a href="{{ route('utilisateur.index') }}" class="{{ request()->routeIs('utilisateur.index') ? 'active' : '' }}">
                <i class='bx bx-user'></i>
                <span class="links_name">Utilisateur</span>
            </a>
        </li>
        <li>
            <a href="{{ route('demande') }}" class="{{ request()->routeIs('demande') ? 'active' : '' }}">
                <i class="bx bx-user"></i>
                <span class="links_name">Demande</span>
            </a>
        </li>
        <li>
            <a href="{{ route('article') }}" class="{{ request()->routeIs('article') ? 'active' : '' }}">
                <i class="bx bx-box"></i>
                <span class="links_name">Article</span>
            </a>
        </li>
        <li>
            <a href="{{ route('fournisseur.index') }}" class="{{ request()->routeIs('fournisseur.index') ? 'active' : '' }}">
                <i class="bx bx-user"></i>
                <span class="links_name">Fournisseur</span>
            </a>
        </li>
        <li>
            <a href="{{ route('commande') }}" class="{{ request()->routeIs('commande') ? 'active' : '' }}">
                <i class="bx bx-list-ul"></i>
                <span class="links_name">Commandes</span>
            </a>
        </li>
        <li>
            <a href="{{ route('categorie') }}" class="{{ request()->routeIs('categorie') ? 'active' : '' }}">
                <i class="bx bx-list-ul"></i>
                <span class="links_name">Catégorie</span>
            </a>
        </li>
        <li>
            <a href="{{ route('bondelivraison') }}">
                <i class="bx bx-user"></i>
                <span class="links_name">Bon de livraison</span>
            </a>
        </li>
        <li>
            <a href="{{ route('report') }}">
                <i class="bx bx-cog"></i>
                <span class="links_name">Report</span>
            </a>
        </li>
        <li>
            <a href="{{ route('configuration') }}">
                <i class="bx bx-cog"></i>
                <span class="links_name">Configuration</span>
            </a>
        </li>
        <li>
            <a href="{{ route('logout') }}">
                <i class="bx bx-log-out"></i>
                <span class="links_name">Déconnexion</span>
            </a>
        </li>
    </ul>
</div>
