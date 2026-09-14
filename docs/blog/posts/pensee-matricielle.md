---
authors: [baptouuuu]
date: 2026-09-05
categories: [Mental Tips]
---

# La pensée matricielle

C'est une façon d'aborder la complexité que j'ai acquise en travaillant avec la programmation fonctionnelle. C'est une manière que j'aime beaucoup pour appréhender les problèmes.

Dans un usage simple c'est facile à présenter et utiliser mais au plus le problème devient complexe au plus la difficulté augmente. Mais on va voir comment cette faiblesse peut aussi être un avantage.

<!-- more -->

## Une dimension

Comme son nom l'indique, la pensée matricielle se base sur les matrices. Dans sa version la plus simple on a la matrice à une dimension, aussi appelée un vecteur.

Si on prend une fonction `#!php function increment(int<0, max> $x): int<0, max>`, d'un point de vue abstrait l'ensemble des arguments possibles vont de `0` à l'infini (c'est ce qu'on appelle un `Set` en math/programmation fonctionnelle). Mais dans la réalité cet ensemble ne peut pas être infini, sur un système 64 bits on s'arrête à l'entier `2^63-1` (soit `9 223 372 036 854 775 807`).

Le vecteur possible pour notre fonction est :

| `x` |||||||
|-|-|-|-|-|-|-|
|| `0` | `1` | `2` | `3` | ... | `2^63-1` |

Jusque là, se le représenter mentalement reste abordable. 

Mais techniquement ce vecteur est faux car si on accepte en argument l'entier maximum possible par notre système alors la valeur retournée ne peut pas être représentée. On a le choix entre un `int overflow` ou cast l'entier en `float` (mais la signature de la fonction n'est pas bonne). 

L'alternative c'est de réduire le vecteur accepte : 

| `x` |||||||
|-|-|-|-|-|-|-|
|| `0` | `1` | `2` | `3` | ... | `2^63-2` |

??? note
    Ce vecteur diminué peut soit vivre dans votre tête mais alors l'info n'est pas partagée (même si dans cet exemple c'est facile d'y penser). Soit c'est de l'inscrire dans le système de typage via `int<0, max-1>`. 

    Dans ce genre de cas le mieux reste quand même d'encapsuler ce genre de sous ensemble dans son propre type. A savoir en PHP créer une classe dédiée.

## Deux dimensions

Mais si on rajoute un deuxième argument à notre fonction, `#!php function increment(int<0, max> $x, int<0, max> $y): int<0, max>`, on passe à une matrice à 2 dimensions qui ressemble à :

| `x`/`y` | `0` | `1` | `2` | `3` | ... | `2^63-1` |
|-|-|-|-|-|-|-|
| `0` | `(0, 0)` | `(0, 1)` | `(0, 2)` | `(0, 3)` | ... | `(0, 2^63-1)` |
| `1` | `(1, 0)` | `(1, 1)` | `(1, 2)` | `(1, 3)` | ... | `(1, 2^63-1)` |
| `2` | `(2, 0)` | `(2, 1)` | `(2, 2)` | `(2, 3)` | ... | `(2, 2^63-1)` |
| `3` | `(3, 0)` | `(3, 1)` | `(3, 2)` | `(3, 3)` | ... | `(3, 2^63-1)` |
| ... | ... | ... | ... | ... | ... | ... |
| `2^63-1` | `(2^63-1, 0)` | `(2^63-1, 1)` | `(2^63-1, 2)` | `(2^63-1, 3)` | ... | `(2^63-1, 2^63-1)` |

Avec cette représentation on observe rapidement 2 points : 

- la complexité augmente rapidement (alias le nombre de permutations possibles)
- nombre de permutations sont invalides car le résultat ne peut pas être exprimé par un `int`

Quand une matrice devient trop complexe j'aime jouer sur le côté intuition de notre métier. Si elle est trop complexe c'est qu'à un moment je risque me faire dépasser dans ma capacité à l'appréhender. J'utilise ce sentiment d'inconfort comme signal pour chercher à réduire les ensembles de données autorisés.

Le deuxième point est plus factuel : des permutations vont planter à l'exécution. Là encore la solution va être la même : réduire les permutations possibles. 

Si on réduit le type des arguments à `int<0, 100>` alors le type de retour est forcément `int<0, 200>`. Comme ça on est sûr que toutes les permutations sont possibles et la complexité est gérable (et mentalement plus facile à se représenter).

Bien entendu la réduction n'est pas toujours aussi simple, dans ces cas là il faut bien documenter dans l'implémentation les scénarios invalides en levant des exceptions explicites. Même si ce n'est pas représenté dans le typage ça permet au moins à la représentation mentale de ne pas penser à ces cas.

## Trois dimensions

Si maintenant on a 3 arguments sur une fonction `#!php function add(int<0, 100> $x, int<0, 100> $y, int<0, 100> $y): int<0, 300>` alors on passe sur une matrice à 3 dimensions, à savoir : un cube.

Se représenter mentalement un cube c'est facile vu que c'est une forme géométrique qu'on peut manipuler dans le monde réel.

Mais pour le représenter à l'écrit c'est plus compliqué. Au début de ma carrière j'ai eu du mal avec ces représentations jusqu'à ce que je finisse par _tricher_ et arrêter de vouloir avoir une correspondance physique réelle. J'ai fini par visualiser des tableaux associatifs : 

```php
$matrice = [
    ['x' => 0, 'y' => 0, 'z' => 0],
    ['x' => 1, 'y' => 0, 'z' => 0],
    ['x' => 2, 'y' => 0, 'z' => 0],
    // ...
    ['x' => 100, 'y' => 0, 'z' => 0],
    ['x' => 0, 'y' => 1, 'z' => 0],
    ['x' => 0, 'y' => 2, 'z' => 0],
    // ...
    ['x' => 0, 'y' => 100, 'z' => 0],
    ['x' => 0, 'y' => 0, 'z' => 1],
    ['x' => 0, 'y' => 0, 'z' => 2],
    // ...
    ['x' => 0, 'y' => 0, 'z' => 100],
];
```

Mais à force d'utiliser la programmation fonctionnelle j'utilise maintenant une autre représentation.

La matrice à deux dimensions qu'on a vu plus haut peut être simplifiée en un vecteur : 

| `x`/`y` |||||||
|-|-|-|-|-|-|-|
|| `(0, 0)` | ... | `(100, 0)` | `(0, 1)` | ... | `(0, 100)` |

Cela nous permet donc de représenter une matrice de 3 dimensions via seulement 2 :

| `(x, y)`/`z`| `0` | `1` | `2` | `3` | ... | `100` |
|-|-|-|-|-|-|-|
| `(0, 0)` | `((0, 0), 0)` | `((0, 0), 1)` | `((0, 0), 2)` | `((0, 0), 3)` | ... |  `((0, 0), 100)` |
| ... | ... | ... | ... | ... | ... |  ... |
| `(100, 0)` | `((100, 0), 0)` | `((100, 0), 1)` | `((100, 0), 2)` | `((100, 0), 3)` | ... |  `((100, 0), 100)` |
| `(0, 1)` | `((0, 1), 0)` | `((0, 1), 1)` | `((0, 1), 2)` | `((0, 1), 3)` | ... |  `((0, 1), 100)` |
| ... | ... | ... | ... | ... | ... |  ... |
| `(0, 100)` | `((0, 100), 0)` | `((0, 100), 1)` | `((0, 100), 2)` | `((0, 100), 3)` | ... |  `((0, 100), 100)` |

Cette compression dans un espace de plus faible dimension permet également une autre simplification mentale. Le tuple `(x, y)`, on peut lui donner un nom pour abstraire sa complexité interne. Cette pratique est d'autant plus valable s'il y a une interaction forte entre les 2 valeurs, où ça vaut le coup de le matérialiser via une classe dans le code.

Et on peut même encore compresser cette matrice en un vecteur de _triple_ : 

| `(x, y, z)` ||||||
|-|-|-|-|-|-|
|| `(0, 0, 0)` | ... | `(0, 100, 0)` | ... | `(0, 0, 100)` |

## Hautes dimensions

A chaque nouvel argument et donc nouvelle dimension il revient à appliquer récursivement les mêmes techniques pour naviguer dans cette complexité.

Mais même en connaissant et pratiquant ces techniques, à haute dimensions la complexité est difficile à gérer. 

Dès que l'envie de réduire les ensembles de données pointe son nez il ne faut pas hésiter à s'appuyer dessus. Quitte même à trop réduire dans un premier temps pour appréhender (réduire l'effet de vertige) la complexité et ensuite élargir ces ensembles.

## Conclusion

Par cette approche on voit indirectement le lien avec la programmation fonctionnelle et le système de typage.

En programmation fonctionnelle on retrouve partout des fonctions avec un seul argument, même si celui-ci peut être un tuple. C'est la mécanique de compression des dimensions. On peut plus facilement appréhender un vecteur de permutations qu'une matrice à haute dimensions.

Et on retrouve le système de typage comme mécanisme pour compresser un vecteur derrière un nom (alias un type, ou une classe en PHP). En utilisant un nom on masque plus facilement la complexité qui se cache derrière.

Au final on se retrouve à naviguer mentalement entre des matrices et des vecteurs, et à masquer ou révéler la complexité en fonction du niveau de lecture dont on a besoin.

A force de me représenter cette complexité c'est ce qui m'a amené au [Property Based Testing](https://en.wikipedia.org/wiki/Software_testing#Property_testing) et à créer [BlackBox](https://github.com/innmind/blackbox). Et maintenant à explorer le Simulation Testing, mais c'est une histoire pour plus tard.

??? info
    Vu qu'on parle d'IA partout en ce moment, on retrouve cette logique de compression dans la représentation textuelle. Une IA pour représenter la similarité sémantique des mots utilise une matrice à haute dimension de `float`. 

    Une matrice à 1024 dimensions est donc représentable par le type `list<float>` contenant 1024 valeurs. Si vous avez travaillé avec un [RAG](https://en.wikipedia.org/wiki/Retrieval-augmented_generation) vous avez probablement vu de tels tableaux.
