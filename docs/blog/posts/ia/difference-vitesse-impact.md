---
authors: [baptouuuu]
date: 2026-11-01
categories: [AI]
---

# La différence entre vitesse et impact

??? quote "Série IA"
    Cette article fait partie d'une [série sur la place de l'IA chez un éditeur](../vision-ia.md).

En lisant les ouvrages des philosophes stoïciens il y a un principe qui m'a beaucoup marqué et auquel je repense souvent : ne pas confondre l'agitation et l'action.

L'agitation nous donne le sentiment de productivité en faisant plein de choses différentes à un rythme éffréné.

En comparaison l'action va nous paraitre plus lente car elle mobilise moins de sujets et ne produit pas nécessairement de résultat immédiatement. Et pourtant c'est bien elle qui permet de faire avancer les sujets complexes.

!!! warning ""
    C'est pour ça que je considère que vouloir maximiser la vitesse est une **erreur startégique** pour un éditeur.

<!-- more -->

Mais jusqu'à présent cette position était difficile à transmettre et à tenir car l'argumentaire est subjectif. La définition de ce qui est de l'agitation ou de l'action est sujette à interprétation.

Comme à mon habitude j'aime chercher des parallèles entre notre métier et d'autre secteurs. Celui qui m'est venu récemment est lié à la mécanique.

Je l'aime particulièrement car il permet de passer du champ philosophique à celui de l'ingénierie.

## Définitions

En mécanique on a la formule `puissance = (couple * vitesse) / 5252`.

En terme plus techniques on a : 

- `puissance` : nommé `horsepower` ou `cheval-vapeur`
- `couple` : la force angulaire
- `vitesse` : nombre de révolutions en 1 minute défini en `rpm` ou `tr/min`
- `5252` : c'est une constante qui ne nous intéresse pas pour mon parallèle

Présenté comme ça c'est pas forcément clair. Passons donc par une traduction qui parlera à plus de monde : le vélo.

Le `couple` est représentable par le plateau sur lequel est votre chaine. Sur le petit plateau vous avez plus de `couple` que sur le grand. Pourquoi ? Parce que la distance entre la pédale est le plateau est plus grande. La même force appliquée sur la pédale avec un bras de pédalier plus grand produira plus de force angulaire, alias du `couple`. 

La `vitesse` va donc dépendre de la force appliquée sur la pédale. Si on prend le même vélo avec la chaine sur le même plateau, 2 personnes avec des formes physiques différentes arriveront à faire plus ou moins de tours de pédales en 1 minute.

En jouant sur ces 2 paramètres on va soit chercher à maximiser la vitesse linéaire (en `km/h`), via la `vitesse`, soit la masse à déplacer (en `kg`), via le `couple`.

Voyons maintenant comment cette formule s'applique aux 2 principaux composants de notre métier : la communication et le code.

## La communication

Avant même de coder on doit communiquer avec de nombreuses personnes pour savoir qu'est-ce qu'on doit faire et pourquoi, que ce soit l'équipe produit, ses collègues, les clients, etc...

La difficulté de la communication est d'arriver à transmettre la complexité du sujet le plus efficacement possible et éviter les quiproquo.

Si on reprend la formule mécanique et qu'on souhaite maximiser la `vitesse` cela revient à augmenter le nombre de mots produits à la minute.

Si c'était une solution soutenable, la nature nous aurait fait évoluer pour parler de plus en plus vite. Ou on aurait vu naitre des formations pour parler avec le débit d'[Eminem](https://www.youtube.com/watch?v=XbGs_qK2PQA) ou pour [taper sur nos claviers](https://www.typingtest.com) de plus en plus vite.

A l'inverse ce que nous montre notre histoire c'est qu'on privilégie le `couple` via la compression des concepts. C'est à dire qu'on préfère inventer de nouveaux mots pour englober des concepts complexes. L'effet c'est qu'avec un même nombre de mots on est capable d'exprimer plus d'informations et avec plus de précision.

Et la démonstration est simple. Le mot `chat` est bien plus précis, demande moins d'énergie et est plus rapide à exprimer que `un ensemble d'atomes constituant un organisme vivant à 4 pates, une queue, des moustaches...` (et on ne sait toujours pas si on parle d'un chat ou d'un tigre).

## Le code

En tant qu'éditeur notre difficulté est de gérer la complexité de nos applications. 

On a la complexité de chaque fonctionnalité. Mais on a aussi la tendance naturelle à rajouter des fonctionnalités et les interactions entre celles-ci créent aussi une complexité qui a tendance à être [exponentielle](../pensee-matricielle.md).

En 2023 je présentais ce [problème d'exponentialité dans les tests](https://www.youtube.com/watch?v=ZIM1OIjvk5s) au ForumPHP.

Là encore si on reprend la formule mécanique et qu'on souhaite maximiser la `vitesse` cela veut dire écrire des tests de plus en plus rapidement. Mais avec cette logique d'exponentialité, l'accélération de production des tests doit être exponentielle. Le problème c'est qu'il y a une limite fondamentale à cette approche : la vitesse de la lumière.

On pourrait se dire qu'il suffit de paralléliser pour augmenter la production. Et les promoteurs de LLMs semblent choisir cette option avec les agents. Mais c'est rajouter de la complexité au problème, car ça demande une coordination entre ces agents. Et on retombe au final sur une nouvelle complexité exponentielle.

Au final on retrouve d'une certaine manière la [Loi de Brooks](https://fr.wikipedia.org/wiki/Loi_de_Brooks) : 

> Ajouter des personnes à un projet en retard accroît son retard.

Le `couple` appliqué au code est similaire à la communication. L'objectif est de gérer plus de complexité avec la même quantité de code.

Ça se traduit par de nouvelles abstractions. Une abstraction correspond à un nouveau mot, et son implémentation est la définition de ce mot.

## L'exemple du fret

Ce parallèle avec la mécanique me parait encore plus parlant via un exemple plus haut niveau : le transport de fret.

On a différentes stratégies pour le transport de marchandises : camions, avions, trains, etc...

Mais pour cet article les 2 extrêmes m'intéressent particulièrement.

D'un côté on a les trottinettes pour le transport de petit colis en ville. Ici on cherche la `vitesse` pour livrer un maximum de colis. Pour y arriver chaque colis est léger et on va avoir pleins d'aller-retour avec le dépot.

A l'opposé on a le porte conteneur. Ici on cherche le `couple`. L'objectif est de transporter de plus en plus de conteneurs sur un même voyage. C'est pour ça qu'on voit ces bateaux croitre en taille génération après génération.

Et en terme économique, pour les transports de fret longue distance, le porte conteneur reste la meilleure solution que son alternative l'avion (qui pourtant va bien plus vite).

Maintenant si on considère le fret comme notre complexité, mon argument est qu'un éditeur devrait s'inspirer des portes conteneurs et non des trottinettes.

## Conclusion

Choisir la vitesse peut paraitre être un pari gagnant tant que la complexité est faible. Mais cette vitesse fait croitre cette complexité, et viendra un moment où les courbes vont se croiser. A partir de ce moment la vitesse devient une fuite en avant.

Ce parallèle avec le transport mécanisé montre également un paradoxe de l'usage des LLMs. Une vitesse linéaire importante demande une expertise poussée, là où les promoteurs de LLMs promettent la démocratisation. Un pilote de F1 ou d'avion opère à plusieurs centaines de km/h. Maintenir une telle vitesse linéaire en toute sécurité demande une expertise importante et un niveau de concentration poussé. Aux USA ou en Europe un pilote d'avion ne peut pas faire plus de 100h de vol par mois ou 1000h par an. Et on voit déjà ce problème de fatigue chez les utilisateurs d'agents IA.

Cela montre également un autre danger : le bus factor. Ces transports à grande vitesse sont opérable par un nombre limité de personnes, mais au moindre problème ([perte de roue](https://www.youtube.com/watch?v=ZMZJ3ZaEcIQ) ou [collision aviaire](https://en.wikipedia.org/wiki/US_Airways_Flight_1549)) les conséquences se décident en peu de temps. Là où le porte conteneur demande plus de personnes pour l'opérer mais les responsabilités sont distribuées et plus soutenables dans le temps.

Je comprends que ça fasse plaisir de se voir piloter un avion, et c'est pas mon amour de l'ingénierie qui va dire le contraire, mais le rapport économique est là : un éditeur a tout d'un porte conteneur.

!!! success ""
    Maximisez le `couple` pour la production de code, maximisez la `vitesse` pour son exécution au runtime !

---

Dans les analogies marrantes on a en 2019 la [première image d'un trou noir](https://science.nasa.gov/resource/first-image-of-a-black-hole/) qui a nécessité 7 Petabytes de données. Pour les transporter entre l'observatoire et les laboratoires ça a été plus rapide de transporter les disques durs par avion que par internet.
