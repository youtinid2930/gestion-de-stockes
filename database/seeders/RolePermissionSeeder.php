<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::where('name', 'admin')->first();
        $gestionnaire = Role::where('name', 'gestionnaire')->first();
        $magasinier = Role::where('name', 'magasinier')->first();


        $admin->givePermissionTo([
            'gerer utilisateur',
            'voir demande',
            'gerer commande',
            'gerer articles',
            'voir articles',
            'gerer fournisseur',
            'gerer categorie',
            'ajouter livraison',
            'voir livraison',
            'supprimer livraison',
            'modifier livraison'
        ]);

        $magasinier->givePermissionTo([
            'voir demande',
            'ajouter demande', 
            'supprimer demande',
            'modifier demande',
            'voir articles',
            'ajouter livraison',
            'voir livraison',
            'supprimer livraison',
            'modifier livraison'
        ]);

        $gestionnaire->givePermissionTo([
            'voir demande',
            'ajouter demande', 
            'supprimer demande',
            'modifier demande',
            'voir articles',
            'voir livraison'
        ]);

    }
}
