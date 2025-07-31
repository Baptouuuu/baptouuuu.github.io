autoscale: true
theme: Fira, 6

## Et si le futur de la programmation concurrentielle avait déjà 50 ans ?

---

[.list: alignment(left)]

- Baptiste Langlade
- Architecte chez Efalia
- Lyon
- 10+ ans XP
- ~100 packages Open Source

---

## Crawler

---

```mermaid
flowchart TB
    start["wikipedia.org"]
    start --> en["en.wikipedia.org"]
    start --> fr["fr.wikipedia.org"]
    en --> php["en.wikipedia.org/wiki/PHP"]
    en --> etc["etc..."]
    fr --> php_fr["fr.wikipedia.org/wiki/PHP"]
    fr --> etc_fr["etc..."]
```

---

```mermaid
flowchart LR
    consumer -- Call --> fetcher
    exchange -- Publish --> queue
    subgraph crawl ["Crawl process"]
        fetcher["Fetcher"] --> parser["Parser"] --> exchange["Exchange messages"]
    end
    subgraph consume ["Consume process"]
        consumer["Consumer"] <-- Pull --> queue["Queue messages"]
    end
```

---

```mermaid
flowchart TB
    subgraph queue ["Queue"]
        m1["wikipedia.org"] --> m2["en.wikipedia.org"] --> m3["fr.wikipedia.org"]
        m3 --> m4["en.wikipedia.org/wiki/PHP"] --> etc["etc..."]
    end
```

---

## Simple mais difficile

^ simple au raisonnement mais innefficace

---

### Parallélisation

```mermaid
flowchart BT
    subgraph rabbitmq ["RabbitMQ"]
        queue["Queue messages"]
    end
    c1 -- Pull --> queue
    c2 -- Pull --> queue
    subgraph p1 ["Process 1"]
        c1["Consumer 1"]
    end
    subgraph p2 ["Process 2"]
        c2["Consumer 2"]
    end
```

^ synchronisation problem

---

```mermaid
flowchart BT
    subgraph rabbitmq ["RabbitMQ"]
        queue["Queue messages"]
    end
    c1 -- Pull --> queue
    c2 -- Pull --> queue
    subgraph p1 ["Process 1"]
        c1["Consumer 1"]
    end
    subgraph p2 ["Process 2"]
        c2["Consumer 2"]
    end
    subgraph filesystem ["Filesystem"]
        lock["Lock"]
    end
    c1 -- Acquire --> lock
    c2 -- Acquire --> lock
```

^ noisy neighbour

---

## Sharding

```mermaid
flowchart BT
    subgraph rabbitmq ["RabbitMQ"]
        q1["Queue 1"]
        q2["Queue 2"]
    end
    c1 -- Pull --> q1
    c2 -- Pull --> q2
    subgraph p1 ["Process 1"]
        c1["Consumer 1"]
    end
    subgraph p2 ["Process 2"]
        c2["Consumer 2"]
    end
```

^ noisy neighbour

---

```mermaid
flowchart BT
    subgraph rabbitmq ["RabbitMQ"]
        q1["Queue 1"]
        q2["Queue 2"]
    end
    c1 -- Pull --> q1
    c2 -- Pull --> q1
    c3 -- Pull --> q2
    c4 -- Pull --> q2
    subgraph p1 ["Process 1"]
        c1["Consumer 1"]
    end
    subgraph p2 ["Process 2"]
        c2["Consumer 2"]
    end
    subgraph p3 ["Process 3"]
        c3["Consumer 3"]
    end
    subgraph p4 ["Process 4"]
        c4["Consumer 4"]
    end
    subgraph filesystem ["Filesystem"]
        l1["Lock 1"]
        l2["Lock 2"]
    end
    c1 -- Acquire --> l1
    c2 -- Acquire --> l1
    c3 -- Acquire --> l2
    c4 -- Acquire --> l2
```

---

## Complexité exponentielle

^ au plus on veut optimiser les ressources au plus la complexité croit

---

## Problème insoluble ?

^ problème valable pour des imports, webhooks, syncro de systèmes, etc...

---

## Actor Model

^ 1973 par Carl Hewitt, WhatsApp, RabbitMQ, pb concurrence => supprimer concurrence

---

[.list: alignment(left)]

### Actor

- Traite une file de messages
- Peut créer d'autres acteurs
- Peut envoyer des messages aux autres acteurs

^ ~= 1 process, 1 message à la fois

---

```mermaid
flowchart TB
    subgraph pr["Process"]
        ar["Actor 'Crawler'"]
        ar -. Messages .-> ar
    end
    m0("First message") -..-> pr
```

---

```mermaid
flowchart TB
    subgraph pr["Process"]
        ar["Actor 'Crawler'"] -. Messages .-> mr["Mailbox"]
        mr --> ar
    end
    m0("First message") -..-> pr
```

---

```mermaid
flowchart TB
    subgraph pr ["Process 0"]
        arm["Mailbox"] --> ar["Root actor"]
    end
    subgraph p1 ["Process 1"]
        a1m["Mailbox"] --> a1["Actor '.org'"]
    end
    subgraph p2 ["Process 2"]
        a2m["Mailbox"] --> a2["Actor '.fr'"]
    end
    subgraph p3 ["Process 3"]
        a3m["Mailbox"] --> a3["Actor 'wikipedia'"]
    end
    subgraph p4 ["Process 4"]
        a4m["Mailbox"] --> a4["Actor 'linuxfoundation'"]
    end
    subgraph p5 ["Process 5"]
        a5m["Mailbox"] --> a5["Actor 'wikipedia'"]
    end
    subgraph p6 ["Process 6"]
        a6m["Mailbox"] --> a6["etc..."]
    end
    ar -. Messages .-> p1
    ar -. Messages .-> p2
    p1 -. Messages .-> p3
    p1 -. Messages .-> p4
    p2 -. Messages .-> p5
    p2 -. Messages .-> p6
```

^ actors come in systems alias diviser pour mieux régner

---

```mermaid
flowchart TB
    subgraph s1["Server"]
        direction TB
        subgraph pr ["Process 0"]
            arm["Mailbox"] --> ar["Root actor"]
        end
        subgraph p1 ["Process 1"]
            a1m["Mailbox"] --> a1["Actor '.org'"]
        end
        subgraph p2 ["Process 2"]
            a2m["Mailbox"] --> a2["Actor '.fr'"]
        end
        subgraph p3 ["Process 3"]
            a3m["Mailbox"] --> a3["Actor 'wikipedia'"]
        end
        subgraph p4 ["Process 4"]
            a4m["Mailbox"] --> a4["Actor 'linuxfoundation'"]
        end
        subgraph p5 ["Process 5"]
            a5m["Mailbox"] --> a5["Actor 'wikipedia'"]
        end
        subgraph p6 ["Process 6"]
            a6m["Mailbox"] --> a6["etc..."]
        end
    end
    ar -. Messages .-> p1
    ar -. Messages .-> p2
    p1 -. Messages .-> p3
    p1 -. Messages .-> p4
    p2 -. Messages .-> p5
    p2 -. Messages .-> p6
```

---

```mermaid
flowchart TB
    subgraph s1["Server 1"]
        direction TB
        subgraph pr ["Process 0"]
            arm["Mailbox"] --> ar["Root actor"]
        end
        subgraph p1 ["Process 1"]
            a1m["Mailbox"] --> a1["Actor '.org'"]
        end
        subgraph p2 ["Process 2"]
            a2m["Mailbox"] --> a2["Actor '.fr'"]
        end
    end
    subgraph s2["Server 2"]
        direction TB
        subgraph p3 ["Process 3"]
            a3m["Mailbox"] --> a3["Actor 'wikipedia'"]
        end
        subgraph p4 ["Process 4"]
            a4m["Mailbox"] --> a4["Actor 'linuxfoundation'"]
        end
        subgraph p5 ["Process 5"]
            a5m["Mailbox"] --> a5["Actor 'wikipedia'"]
        end
        subgraph p6 ["Process 6"]
            a6m["Mailbox"] --> a6["etc..."]
        end
    end
    ar -. Messages .-> p1
    ar -. Messages .-> p2
    p1 -. Messages .-> p3
    p1 -. Messages .-> p4
    p2 -. Messages .-> p5
    p2 -. Messages .-> p6
```

^ simple et scalable, pause

---

## En pratique ça donne quoi ?

---

| Actor Model | Standard Model |
|:-:|:-:|
| Mailbox | Queue |
| Actor | Consumer |

---

```mermaid
flowchart TB
    subgraph rabbit["RabbitMQ"]
        q1["Queue '.org'"]
        q2["Queue '.fr'"]
        q3["Queue 'wikipedia'"]
        q4["etc..."]
    end
    subgraph s2["Server 2"]
        subgraph p4["Process 4"]
            c4["Consumer"]
        end
        subgraph p3["Process 3"]
            c3["Consumer"]
        end
    end
    subgraph s1["Server 1"]
        subgraph p2["Process 2"]
            c2["Consumer"]
        end
        subgraph p1["Process 1"]
            c1["Consumer"]
        end
    end
    q1 -. Messages .-> p1
    q2 -. Messages .-> p2
    q3 -. Messages .-> p3
    q4 -. Messages .-> p4
```

---

## Problème de ressources ?

^ process !== process système

---

## Parallélisation + Asynchrone

---

![inline](parallelism.png)

^ cpu bound 👍

---

![inline](async.png)

^ IO bound 👍

---

![inline](both.png)

---

```mermaid
flowchart TB
    subgraph rabbit["RabbitMQ"]
        q1["Queue '.org'"]
        q2["Queue '.fr'"]
        q3["Queue 'wikipedia'"]
        q4["etc..."]
    end
    subgraph s2["Server 2"]
        subgraph p2["Process 2"]
            c3["Consumer"]
            c4["Consumer"]
        end
    end
    subgraph s1["Server 1"]
        subgraph p1["Process 1"]
            c1["Consumer"]
            c2["Consumer"]
        end
    end
    q1 -. Messages .-> c1
    q2 -. Messages .-> c2
    q3 -. Messages .-> c3
    q4 -. Messages .-> c4
```

---

## Scalabilité ultime

^ single process -> multi process -> cluster

---

## Unifier des paradigmes différents

^ un actor ne devrait pas savoir s'il est exécuté en async ou pas, utile pour les tests

---

![](doc.png)

## <https://innmind.org>

![inline](qr.png)

---

## Monades

---

![](retex-archivage.png)

---

## Tests

^ PBT async, blackbox

---

![inline](retex-blackbox.png)

---

## Demo

---

## 🚧 <https://github.com/innmind/witness> 🚧

![inline](witness.png)

---

## Questions

![inline](open-feedback.png)![inline](signal.png)

X/Bluesky/Mastodon @Baptouuuu

<https://baptouuuu.github.io/conferences/>
