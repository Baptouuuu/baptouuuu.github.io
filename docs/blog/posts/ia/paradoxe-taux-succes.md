---
authors: [baptouuuu]
date: 2026-08-17
categories: [AI]
---

# Le paradoxe du taux de succès

En 2016, mon employeur de l'époque [Kibatic](https://kibatic.com) m'a permis de me former au Machine Learning. On y est arrivé en abordant les technologies de big data (Hadoop et compagnie), comment manipuler ces données et les préparer pour ensuite apprendre d'elles via des algorithmes de Machine Learning.

Ça a été une année très formatrice. J'ai découvert plein d'outils et de concepts. Mais j'ai surtout retenu que c'est vraiment un métier à part entière qui nécessite des compétences pointues pour ne pas introduire (trop) de biais dans les modèles produits.

Même si j'ai compris que je n'avais pas les compétences (1) pour être efficient dans ce champ de l'informatique, j'en ai retenu quelques grandes leçons. Dont une qui est le sujet de cet article.
{.annotate}

1. ou tout du moins l'envie, ou la patience, de les acquérir.

<!-- more -->

Comme je le décrivais dans la [définition de l'IA](definition.md), un modèle est entrainé à partir d'un jeu de données qui contient des pairs d'input/réponse.

Pour valider la qualité du modèle on divise le jeu de donnée, de façon aléatoire, en 2 (avec une répartition de 80/20). La première partie sert à l'entrainement du modèle. La seconde, on va fournir chaque input au modèle et comparer la réponse générée par rapport à celle attendue. Cela permet de définir un taux/pourcentage de succès de prédiction sur des données que le modèle n'a jamais vu.

Un biais qu'on peut avoir, et que j'ai eu, est de se dire que la qualité du modèle est dépendant de la qualité et volume du jeu de données d'entrainement. On pourrait donc vouloir utiliser l'ensemble du jeu de données pour entrainer le modèle pour nous approcher au plus possible d'une prédiction de 100%.

!!! warning ""
    Et c'est là que ce trouve la leçon de cet article : le problème d'_overfitting_.

L'overfitting c'est quand on atteint 100% de succès de prédiction. 

Comme ça on pourrait se dire que c'est plutôt une bonne chose. Mais ce taux indique que le modèle n'a appris que la relation entre l'input et la réponse, il n'est pas capable de traiter un nouvel input. C'est comme une fonction où l'implémentation n'est qu'un immense tableau associatif composé de l'input en clé et la réponse en valeur. Si on passe un nouvel input à cette fonction, elle n'est pas capable de répondre car elle ne trouve pas la relation dans le tableau.

C'est là le paradoxe du taux de succès. On veut un taux suffisament élevé pour être utile dans sa capacité à prédire de nouvelles réponses mais pas trop élevé car il ne sera pas capable de répondre à de nouveaux inputs.

Ça veut dire que quand on entend des gens espérer que les modèles de LLMs[^1] s'amélioreront pour éliminer le problème des hallucinations (alias une mauvaise réponse), c'est une illusion.

Pour faire une analogie, même si je n'aime pas anthropomorphiser cette technologie : un modèle qui ne fait pas d'erreur c'est comme un élève qui apprend les réponses par coeur d'un examen (1), ça ne sert à rien.
{.annotate}

1. ou d'un benchmark pour un modèle

!!! info ""
    Pour conclure : un modèle qui produit des erreurs ce n'est pas un bug, c'est une fonctionnalité !

[^1]: Large Language Model
