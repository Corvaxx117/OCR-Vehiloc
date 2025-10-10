Projet initialisé avec la commande :

composer create-project symfony/skeleton:"^7.2" .

Librairies ajoutées manuellement :

-   symfony/maker-bundle
-   symfony/orm-pack
-   symfony/twig-bundle
-   symfony/asset
-   doctrine/doctrine-fixtures-bundle
-   symfony/validator

1. Creer la bdd
2. Identifier les features ex: creer une liste de users, donc Controller -> service repo ? service filtre données ?
   Le controller indique ce dont on aura besoin (entités; repo, service, templates etc ...)
3.

## Architecture des contrôleurs

Pattern adopté : Single-Action Controllers (un fichier = une action = une route).

Avantages :

-   Responsabilités très limitées, dépendances minimales par action
-   Lisibilité accrue et suppression des "controllers fourre-tout"
-   Tests unitaires plus simples (chaque classe représente un point d'entrée)
-   Évolution et suppression d'une action sans effet collatéral

Organisation :

```
src/Controller/Cars/
   CarCreateAction.php       # GET /cars/add (formulaire ajout)
      CarShowAction.php         # GET /cars/{slug} (fiche véhicule dynamique)
```

Exemple type :

```php
#[Route('/cars/add', name: 'car_add', methods: ['GET'])]
final class CarCreateAction extends AbstractController
{
      public function __invoke(): Response
      {
            return $this->render('car/add.html.twig');
      }
}
```

Règles :

-   Nom de classe : <Contexte><Action>Action (ex: CarCreateAction)
-   Toujours `final`
-   Méthode unique `__invoke()`
-   Attribut `#[Route(...)]` sur la classe, pas de méthode publique supplémentaire
-   Injection de dépendances par constructeur uniquement quand nécessaire

Étapes suivantes possibles :

-   Créer entité Car + migration
-   Ajouter un CarRepository + persistance dans CarCreateAction (POST)
-   Séparer la vue base en layout + composants (partials Twig)
-   Mettre en place tests fonctionnels pour chaque action

---
