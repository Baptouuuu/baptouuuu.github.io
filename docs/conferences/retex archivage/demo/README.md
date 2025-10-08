Installez les vendors avec :

```sh
composer install
```

Pour générer les documents :

```sh
php generate-docs.php
```

Pour générer l'archive :

```sh
php archive.php
```

Vous pouvez suivre l'avancement de la génération de l'archive via :

```sh
ls -goh var/ | grep tar
```
