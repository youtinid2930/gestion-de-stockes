
<div class="container">
    <h1>Configuration du Système</h1>
    
    <ul class="nav nav-tabs" id="configTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="user-tab" data-toggle="tab" href="#user" role="tab" aria-controls="user" aria-selected="true">Gestion des Utilisateurs</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="inventory-tab" data-toggle="tab" href="#inventory" role="tab" aria-controls="inventory" aria-selected="false">Paramètres d'Inventaire</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="reports-tab" data-toggle="tab" href="#reports" role="tab" aria-controls="reports" aria-selected="false">Rapports</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="api-tab" data-toggle="tab" href="#api" role="tab" aria-controls="api" aria-selected="false">API et Intégrations</a>
        </li>
    </ul>

    <div class="tab-content" id="configTabsContent">
        <!-- Gestion des Utilisateurs -->
        <div class="tab-pane fade show active" id="user" role="tabpanel" aria-labelledby="user-tab">
            <h2>Gestion des Utilisateurs</h2>
            <form method="POST" action="">
                @csrf
                <!-- Exemple de paramètres pour la gestion des utilisateurs -->
                <div class="form-group">
                    <label for="defaultRole">Rôle par Défaut</label>
                    <select id="defaultRole" name="defaultRole" class="form-control">
                        <option value="admin">Admin</option>
                        <option value="magasinier">Magasinier</option>
                        <option value="gestionnaire">Gestionnaire</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </form>
        </div>

        <!-- Paramètres d'Inventaire -->
        <div class="tab-pane fade" id="inventory" role="tabpanel" aria-labelledby="inventory-tab">
            <h2>Paramètres d'Inventaire</h2>
            <form method="POST" action="">
                @csrf
                <!-- Exemple de paramètres pour l'inventaire -->
                <div class="form-group">
                    <label for="minStockLevel">Niveau de Stock Minimum</label>
                    <input type="number" id="minStockLevel" name="minStockLevel" class="form-control" value="">
                </div>
                <div class="form-group">
                    <label for="reorderThreshold">Seuil de Réapprovisionnement</label>
                    <input type="number" id="reorderThreshold" name="reorderThreshold" class="form-control" value="">
                </div>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </form>
        </div>

        <!-- Rapports -->
        <div class="tab-pane fade" id="reports" role="tabpanel" aria-labelledby="reports-tab">
            <h2>Configuration des Rapports</h2>
            <form method="POST" action="">
                @csrf
                <!-- Exemple de paramètres pour les rapports -->
                <div class="form-group">
                    <label for="reportFrequency">Fréquence des Rapports</label>
                    <select id="reportFrequency" name="reportFrequency" class="form-control">
                        <option value="daily">Quotidien</option>
                        <option value="weekly">Hebdomadaire</option>
                        <option value="monthly">Mensuel</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </form>
        </div>

        <!-- API et Intégrations -->
        <div class="tab-pane fade" id="api" role="tabpanel" aria-labelledby="api-tab">
            <h2>API et Intégrations</h2>
            <form method="POST" action="">
                @csrf
                <!-- Exemple de paramètres pour les API -->
                <div class="form-group">
                    <label for="apiKey">Clé API</label>
                    <input type="text" id="apiKey" name="apiKey" class="form-control" value="">
                </div>
                <div class="form-group">
                    <label for="apiSecret">Secret API</label>
                    <input type="text" id="apiSecret" name="apiSecret" class="form-control" value="">
                </div>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </form>
        </div>
    </div>
</div>

