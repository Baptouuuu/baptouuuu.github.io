---
authors: [baptouuuu]
date: 2026-08-04
categories: [Mental tips]
---

# Espace positif/négatif

C'est un concept que j'ai découvert via le monde de l'infographie où l'espace positif est la donnée qui est créée et le reste l'espace négatif.

L'exemple le plus connu en France qui illustre ce concept est le logo de Carrefour.

<!-- more -->

![](/assets/logo/carrefour.png)

Les éléments rouge et bleu sont l'espace positif et le blanc l'espace négatif. Et c'est dans cet espace négatif qu'on trouve le `C` de Carrefour. 

Il m'a fallu très longtemps avant de m'en rendre compte 🙈.

Maintenant j'utilise cette approche pour identifier les données qu'une fonction, ou une API, peut manipuler. L'espace positif est l'ensemble des données autorisées et l'espace négatif celles qui ne le sont pas.

Bien souvent l'espace positif est évident, mais parfois il demande plusieurs itérations avant de le définir correctement.

C'est là où prendre une approche par l'espace négatif est intéressant. Autrement dit : qu'est ce qu'on ne veut pas supporter pour cette fonction ?

En éliminant des espaces entiers de données cela permet d'avoir une idée plus claire, et potentiellement plus rapidement, de l'espace positif recherché.

Ce que j'aime bien dans ce concept c'est que pour atteindre un même objectif, en fonction du contexte, on peut prendre une approche diamétralement opposée. Plutôt que de s'entêter dans une voie, des fois la solution se trouve dans l'opposition.
