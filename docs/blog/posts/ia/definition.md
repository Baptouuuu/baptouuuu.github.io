---
authors: [baptouuuu]
date: 2026-08-15
categories: [AI]
---

# Qu'est-ce que l'IA ?

En 2018 j'ai assisté à une table ronde sur l'IA et une des participantes, en introduction, l'a résumé magnifiquement : 

<div class="annotate" markdown>
> Ce n'est que des statistiques ! C'est tout. (1)
</div>

1. Je paraphrase un peu, c'était il y a longtemps.

Mais la première étape est de définir un peu plus les termes. 

<!-- more -->

L'IA en elle même est un champ de recherche complet. 

Depuis quelques années (2022-2026) quand on parle d'IA c'est un raccourci pour les LLMs. Les Large Language Model (LLM) sont des algorithmes basés sur des Réseaux de Neurones (Neural Networks). Eux mêmes sont un sous ensemble du Machine Learning.

Pour comprendre l'utilité des LLMs il faut donc comprendre le fonctionnement de ces réseaux. 

Un réseau de neurones est une fonction qui pour un input donné va retourner plusieurs réponses probables avec un score de probabilité attribué à chaque. Comme toute fonction, tous les réseaux de neurones ne se ressemblent pas et n'attendent pas forcément la même chose en input et ne retourneront pas les mêmes réponses.

La partie intéressante est comment ces fonctions sont créées, ou plutôt entrainées.

Il existe plusieurs façons de les entrainer (1) mais pour faire simple on utilise un algorithme mathématique à qui on va passer successivement des données en input et la réponse attendue. Et à force de voir des paires input/réponse l'algorithme va être capable de déduire les critères qui permettent de faire correspondre un nouvel input à une réponse.
{.annotate}

1. supervisées ou non-supervisées, sous entendu par des humains

Je ne vais pas détailler la structure interne de ces fonctions (les réseaux de neurones en eux mêmes) car ce n'est pas l'objectif de cet article. Et vous trouverez de meilleures vulgarisations sur les internets que je ne pourrais faire moi même.

C'est pour ça qu'on parle de statistiques, l'algorithme d'entrainement ne produit pas une compréhension fine de ce que doit faire la fonction mais une approximation suffisament souple pour s'adapter à de nouveaux inputs. Et au plus il y a de données d'entrainements au plus la fonction pourra produire une réponse probable à un nouvel input.

!!! abstract "Exemple AlphaFold"
    J'aime bien cet exemple parce qu'il démontre bien ce principe. AlphaFold est un modèle/algorithme qui permet de prédir le repliement des protéines en fonction de leur séquence d'acides aminés. C'est un problème ouvert depuis des décennies en chimie. Car si on peut faire cette prédiction alors on peut créer des traitements médicaux beaucoup plus rapidement.

    AlphaFold a fini par dépasser les 90% de succès de prédiction. C'était le seuil que les spécialistes avaient pour déclarer ce problème comme _résolu_. Cette avancée a d'ailleurs valu le Prix Nodel de chimie à son créateur [Demis Hassabis](https://fr.wikipedia.org/wiki/Demis_Hassabis).

    Pour autant même si on est capable de les prédire, ce n'est pas pour autant que ça nous a permit de comprendre le mécanisme sous jacent qui opère le repliement. Et AlphaFold ne l'a pas _comprit_ non plus, car même sur des séquences simples sa prédiction peut être fausse.

    Le documentaire [The Thinking Game](https://en.wikipedia.org/wiki/The_Thinking_Game) sur cette histoire est d'ailleurs très intéressant.

Pour en revenir aux LLMs, ce sont des algorithmes basés sur des réseaux de neurones qui acceptent du texte en input et produisent en réponse un texte le plus probable. Et ça le fait mot par mot, ou plus exactement token par token. 

!!! info ""
    Pour conclure, ces IAs sont conçues pour trouver des similitudes dans les données utilisées pour leur entrainement. Pour qu'ensuite on puisse avoir les réponses les plus probables en fonction de leur input. Rien de plus, rien de moins.

    Reste à notre charge de les appliquer à des problèmes qui :

    1. consistent à trouver des solutions probables dans un grand espace de données,
    2. et dont une réponse fausse est acceptable (et statistiquement certaine d'arriver).
