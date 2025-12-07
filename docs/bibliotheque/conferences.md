# Conférences

## Simple Made Easy

<iframe class="video" src="https://www.youtube.com/embed/SxdOUGdseq4" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>

Pendant longtemps comme beaucoup de gens j'ai utilisé simple/complexe de façon interchangeable avec facile/difficile.

Cette conférence m'a enfin permit de comprendre la différence entre les deux. La simplicité est une mesure objective du nombre de composants d'un système et des interactions entre ceux-ci. Alors que la facilité est une mesure subjective de la familiarité qu'on a avec un système.

Cette distinction est très utile lors de discussions techniques ou produits.

Au delà de ce point, cette conférence est une mine d'or. A voir absolument !

## Constraints Liberate, Liberties Constrain

<iframe class="video" src="https://www.youtube.com/embed/GqmsQeSzMdw" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>

Je retiens surtout la première moitié de cette conférence qui définit la relation entre les contraintes et les libertés.

C'est une conférence avec "Eureka moment". Avant on n'y avait jamais pensé, mais après on ne peut plus ne plus y penser.

L'idée est qu'en ajoutant des contraintes sur les données que l'on souhaite manipuler dans nos apps on se donne la liberté de savoir tout ce qu'on peut faire avec ces données (et comment les faire évoluer). Et inversement avoir la liberté d'envoyer n'importe quelle donnée dans nos apps nous contraints dans les évolutions que l'on pourra faire.

Loi de Murphy oblige, tout ce qui peut arriver va arriver. Offrir la liberté d'utiliser n'importe quelle donnée nous empêchera de réduire cette liberté par la suite (sous peine de casser certains usages).

C'est une généralisation du principe de [variance](https://en.wikipedia.org/wiki/Type_variance). Et c'est un sujet assez lié à la pensée du [Property Based Testing](articles.md#in-praise-of-property-based-testing)

(La deuxième moitié de la conférence est très technique et difficile à appréhender.)

## The future of programming

<iframe class="video" title="vimeo-player" src="https://player.vimeo.com/video/71278954" frameborder="0" referrerpolicy="strict-origin-when-cross-origin" allow="autoplay; fullscreen; picture-in-picture; clipboard-write; encrypted-media; web-share" allowfullscreen></iframe>

Cette conférence de 2013 se place 40 ans en arrière pour parler des progrès de l'époque et de prédire le futur de la programmation.

C'est un rappel que malgré les évolutions de notre métier on n'a pas tant appris que ça du passé. Toute ces décennies plus tard on code toujours sensiblement de la même façon.

Cette conférence a été une forte motivation à explorer d'autres façons de coder et étudier d'anciennes idées qui pourraient s'avérer pertinentes de nos jours.

Si vous voyez le nom de Bret Victor associé à une conférence, allez la voir ! C'est une expérience à chaque fois.

## Boundaries

<iframe class="video" src="https://www.youtube.com/embed/yTkzNHF6rMs" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>

J'en retiens le concept de "functional core, imperative shell". L'idée est d'avoir le code métier définit avec du code pure (1) et les couches extérieures de façon impérative (2) car c'est plus pratique à gérer les changements d'états (3).
{.annotate}

1. au sens de la programmation fonctionnelle
2. en général en programmation objet
3. filesystem, base de données, etc... (tout ce qui est IO)

## L'architecture progressive

<iframe class="video" src="https://www.youtube.com/embed/XyxvP5f67Po" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>

J'ai eu la chance de travailler avec Matthieu et de voir concrètement l'architecture qu'il présente dans cette conférence.

Le message est de ne pas avoir peur de sortir des dogmes et d'expérimenter. En fonction du contexte on ne fera pas toujours la même chose. Le fameux : ça dépend.

## Up to Code

<iframe class="video" src="https://www.youtube.com/embed/r_U9YFPWxEE" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>

Cette conférence m'a aidé à réaliser qu'on peut avoir le même outil (le code) mais pas le même métier.

Par "code" on entend le texte composant un programme là où "Code" est un standard. On peut donc écrire du code sans suivre un Code.

En fonction du projet on voudra, ou non, suivre un Code. Par conséquent on n'ira pas voir les mêmes professionnels. Le parallèle fait entre un Handyman et un Electrician est très parlante. Les deux sont utiles, mais pas dans les mêmes contextes.

## How to crash a plane

<iframe class="video" title="vimeo-player" src="https://player.vimeo.com/video/173246615" frameborder="0" referrerpolicy="strict-origin-when-cross-origin" allow="autoplay; fullscreen; picture-in-picture; clipboard-write; encrypted-media; web-share" allowfullscreen></iframe>

Dans l'aviation il y a un dicton : On ne vit pas assez longtemps pour faire toutes les erreurs. L'idée est d'étudier les erreurs des autres pour éviter de les faire soi même, et c'est ce qu'on fait largement avec les conférences.

Cette conférence retrace un crash d'avion en 1989 où contre toute attente une partie de l'équipage a survécu. La raison est attribué au [crew resource management](https://en.wikipedia.org/wiki/Crew_resource_management). La conférence fait le parallèle de cette pratique dans notre métier.

Ca a été une des sources de motivation à aller explorer d'autres domaines, dont l'aviation, qui ont en général plus d'historique que l'informatique pour essayer d'en tirer des enseignements.
