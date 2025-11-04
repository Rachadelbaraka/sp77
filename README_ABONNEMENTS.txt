CRUD Abonnements - Sujet 7

Fichiers ajoutés:
- database/migrations/2025_11_04_103206_00_create_abonnements_table.php
- app/Models/Abonnement.php
- app/Http/Controllers/AbonnementController.php
- resources/views/abonnements/ (index, create, edit, show, _form)
- routes/web.php (ajout d'une resource route)

Instructions:
1) cp .env.example .env
2) configurer la base de données dans .env
3) composer install (si nécessaire)
4) php artisan migrate
5) php artisan serve
6) Accéder à: http://127.0.0.1:8000/abonnements

Remarques:
- Aucun package additionnel ajouté.
- La migration crée la table 'abonnements' avec champs: nom (unique), duree_mois, prix, actif.
