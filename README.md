# MON SUPER PROJET

## COMMENT TRAVAILLER SUR LE PROJET ?

Première étape, on récupére le dépot:

```bash
cd htdocs
git clone PROJECT_URL
cd PROJECT
```

On installe les dépendances :

```bash
composer install
```

On configure la base de donnée dans ```.env.local.```

On créé la base de données;

```bash
php bin/console donctrine:database:create
```

On créé le schéma:

```bash
php bin/console doctrine:migrations:migrate
```