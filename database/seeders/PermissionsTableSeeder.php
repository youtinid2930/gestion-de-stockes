<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Permission::create(['name' => 'gerer utilisateur']);
        // pour demande
        Permission::create(['name' => 'ajouter demande']);
        Permission::create(['name' => 'voir demande']);
        Permission::create(['name' => 'supprimer demande']);
        Permission::create(['name' => 'modifier demande']);
       // pour commande
        Permission::create(['name' => 'gerer commande']);
       // pour l'article
       Permission::create(['name' => 'gerer articles']);
       Permission::create(['name' => 'voir articles']);
       // pour fournisseur
       Permission::create(['name' => 'gerer fournisseur']);
       // pour categorie
       Permission::create(['name' => 'gerer categorie']);
       //livraison
       Permission::create(['name' => 'ajouter livraison']);
       Permission::create(['name' => 'voir livraison']);
       Permission::create(['name' => 'supprimer livraison']);
       Permission::create(['name' => 'modifier livraison']);
    }
}
