# Articles

## [Parse, don't validate](https://lexi-lambda.github.io/blog/2019/11/05/parse-don-t-validate/)

Alexis King explique comment utiliser le système de typage pour enrichir les données qu'on manipule. Au delà du but d'éviter de faire les mêmes validations plusieurs fois, l'intérêt est de déléguer une charge mentale (1) à un outil qui fera systématiquement les vérifications pour nous.
{.annotate}

1. "Est-ce que ma donnée est valide ?"

A force d'appliquer cette pratique on se retrouve à créer un vocabulaire des termes métiers dans nos apps et les _phrases_ que l'on peut faire (ou non).

Les exemples dans l'article sont en Haskell mais sont transposables dans n'importe quel langage.

## [In praise of property-based testing](https://increment.com/testing/in-praise-of-property-based-testing/)

Au delà de cette technique de test, cela m'a rapproché du côté mathématique de la programmation (fonctionnelle entre autre).

Au lieu de penser aux valeurs données en exemple dans la description d'une fonctionnalité quand je regarde le type d'une variable, maintenant je pense à l'ensemble des valeurs que représente ce type. Et quand une fonction a plusieurs arguments il faut imaginer toutes les permutations possibles.

C'est ce que j'aime appeler la pensée en matrice.

Cette approche met en lumière la complexité qu'on introduit dans nos applications lorsqu'on utilise des types trop généralistes (1). A visualiser la complexité sous cet angle pousse à vouloir réduire cette complexité pour s'assurer qu'on gère bien toutes les permutations possibles. Au final ça pousse à essayer de ne gérer que ce qui est vraiment nécessaire.
{.annotate}

1. Par exemple utiliser que des types primitifs.

Et les outils de Property Based Testing sont sans relâche et trouveront toujours la petite bête qui se fera poser la question : est-ce que cette permutation devrait être possible ?

## [Learn You Some Erlang for great good!](https://learnyousomeerlang.com)

Je suis tombé ce site pour arriver à lire le code source de RabbitMQ et découvrir une implémentation de l'Actor Model.

Je ne code pas en Erlang mais ça a été un des pieds à l'étrier pour m'initier à la programmation fonctionnelle. Ce site m'a également permis de découvrir comment il possible de combiner de la programmation fonctionnelle avec du code "réseau" de façon très naturelle grace à la structure même du langage.

Au final ça m'a poussé à voir s'il est possible de combiner plusieurs approches, à priori différentes, pour essayer d'en tirer les avantages respectifs.

## [Alloy](https://alloy.readthedocs.io/en/latest/)

Ce n'est pas un article mais un outil. Il permet de définir des relations entre des concepts et des contraintes que doivent respecter ces relations. L'outil a ensuite pour charge d'essayer de trouver des typologies où ces contraintes ne sont pas respectées.

La partie vraiment intéressante est la visualisation des typologies.

Depuis que j'ai découvert cet outil, même si je ne l'utilise que rarement, j'essaie souvent de représenter graphiquement le code que je dois écrire. Quand je n'arrive pas à me faire cette représentation c'est un indicateur important que je m'égare dans mon approche.
