# Laravel Payment

Application Laravel 12 pour la gestion d'articles de blog avec paiement et abonnement.

## Prerequis

- PHP 8.4+
- Composer
- Node.js + npm
- SQLite (par defaut) ou MySQL/MariaDB si vous adaptez `.env`

## Installation

1. Cloner le projet puis entrer dans le dossier:

```bash
git clone https://github.com/Tresor-Kasenda/laravel-payment.git
cd laravel-payment
```

2. Installer les dependances backend/frontend:

```bash
composer install
npm install
```

3. Initialiser l'environnement:

```bash
cp .env.example .env
php artisan key:generate
```

4. Configurer la base de donnees:

- Configuration par defaut: SQLite (`DB_CONNECTION=sqlite` dans `.env`)
- Si `database/database.sqlite` n'existe pas:

```bash
touch database/database.sqlite
```

5. Executer les migrations et les donnees de test:

```bash
php artisan migrate --seed
```

## Configuration paiement (Shwary)

Completer ces variables dans `.env`:

```env
SHWARY_MERCHANT_ID=
SHWARY_MERCHANT_KEY=
SHWARY_SANDBOX=true
```

- `SHWARY_SANDBOX=true` pour l'environnement de test.
- Sans cles valides, les paiements ne pourront pas aboutir.

## Lancer le projet en local

Commande recommandee (tout en une):

```bash
composer run dev
```

Cette commande lance:

- le serveur Laravel
- l'ecoute de la queue
- les logs (`pail`)
- Vite en mode developpement

Acces:

- Application: `http://127.0.0.1:8000`
- Connexion admin: `http://127.0.0.1:8000/admin/login`

## Comptes de test (seeders)

Apres `php artisan migrate --seed`, vous pouvez utiliser:

- Admin: `admin@example.com` / `password`
- Utilisateur test: `test@example.com` / `password`
- Lecteur abonne: `reader@example.com` / `password`

## Commandes utiles

```bash
# Lancer les tests
php artisan test --compact

# Formater le code PHP
vendor/bin/pint --dirty

# Build front pour production
npm run build
```

## Depannage rapide

- Erreur Vite manifest (`Unable to locate file in Vite manifest`):
  - lancer `npm run dev` (developpement) ou `npm run build` (build)
- Si l'interface ne se met pas a jour:
  - verifier que Vite tourne (`npm run dev`) ou reconstruire les assets (`npm run build`)
- Si les paiements echouent:
  - verifier les variables `SHWARY_*` dans `.env`

