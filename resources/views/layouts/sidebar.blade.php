<!-- resources/views/layouts/sidebar.blade.php -->
<div class="sidebar hidden-print">
    @csrf
    <ul class="nav-links">
        <li>
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bx bx-grid-alt"></i>
                <span class="links_name">Tableau de bord</span>
            </a>
        </li>
        <li>
            <a href="{{ route('categories.index') }}" class="{{ request()->routeIs('categories.index') ? 'active' : '' }}">
                <i class="bx bx-list-ul"></i>
                <span class="links_name">Catégorie</span>
            </a>
        </li>
        <li>
            <a href="{{ route('article') }}" class="{{ request()->routeIs('article') ? 'active' : '' }}">
                <i class="bx bx-box"></i>
                <span class="links_name">Article</span>
            </a>
        </li>
        @if(auth()->user()->hasRole('admin'))
        <li>
            <a href="{{ route('fournisseur.index') }}" class="{{ request()->routeIs('fournisseur.index') ? 'active' : '' }}">
                <i class="bx bx-user"></i>
                <span class="links_name">Fournisseur</span>
            </a>
        </li>
        
        <li>
            <a href="{{ route('commande.index') }}" class="{{ request()->routeIs('commande.index') ? 'active' : '' }}">
                <i class="bx bx-list-ul"></i>
                <span class="links_name">Commandes</span>
            </a>
        </li>
        @endif
        <li>
            <a href="{{ route('demande') }}" class="{{ request()->routeIs('demande') ? 'active' : '' }}">
                <i class="bx bx-user"></i>
                <span class="links_name">Demande</span>
            </a>
        </li>
        <li>
            <a href="{{ route('bons_de_livraison.index') }}">
                <i class="bx bx-package"></i>
                <span class="links_name">Livraison</span>
            </a>
        </li>
        @if(auth()->user()->hasRole('admin'))
        <li>
            <a href="{{ route('utilisateur.index') }}" class="{{ request()->routeIs('utilisateur.index') ? 'active' : '' }}">
                <i class='bx bx-user'></i>
                <span class="links_name">Utilisateur</span>
            </a>
        </li>
        @endif
        <li>
            <a href="{{ route('report.index') }}">
                <i class="bx bx-cog"></i>
                <span class="links_name">Rapport</span>
            </a>
        </li>
        <li>
            <a href="{{ route('configuration.index') }}">
                <i class="bx bx-cog"></i>
                <span class="links_name">Configuration</span>
            </a>
        </li>
        <li>
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bx bx-log-out"></i>
                <span class="links_name">Déconnexion</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>
</div>
