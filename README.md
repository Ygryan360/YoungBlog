# Young Blog

Young Blog est un blog personnel minimaliste. Il est construit avec [laravel](https://laravel.com) et [tailwindcss](https://tailwindcss.com).

## Installation

1. Clone le dépôt :
    ```bash
    git clone https://github.com/Ygryan360/youngblog.git
    ```
2. Accède au répertoire du projet :

    ```bash
    cd youngblog
    ```

3. Installe les dépendances avec Composer :

    ```bash
    composer install
    ```

4. Installe les dépendances avec NPM ou bun :

    ```bash
    npm install
     # ou
    bun install
    ```

5. Configure l'environnement :

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

6. Configure la base de données dans le fichier `.env` :

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=youngblog
    DB_USERNAME= #votre nom d'utilisateur
    DB_PASSWORD= #votre mot de passe
    ```

7. Exécute les migrations :

    ```bash
     php artisan migrate
    ```

8. Compile les assets :

    ```bash
    npm run build
    # ou
    bun run build
    ```

9. Lance le serveur de développement :

    ```bash
    php artisan serve
    ```

10. Accède à l'application dans ton navigateur à l'adresse [http://localhost:8000](http://localhost:8000).

### Générer un utilisateur

Pour générer un utilisateur, exécute la commande suivante :

```bash
php artisan make:filament-user
```

## Contribuer

Si tu souhaites contribuer à Young Blog, n'hésite pas à ouvrir une issue ou une pull request sur GitHub. Toute contribution est la bienvenue !
