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
flowchart BT
    subgraph rabbitmq ["RabbitMQ"]
        queue["Queue messages"]
    end
    c1 -- Pull --> queue
    subgraph p1 ["Process 1"]
        c1["Consumer 1"]
    end
```

---

[.code-highlight: 3-9]
[.code-highlight: 4]
[.code-highlight: 5]
[.code-highlight: 6-8]
[.code-highlight: 1-2, 10-11]

```php
$rabbitmq
    ->with(Consume::of('queue')->handle(
        static function(Message $message) use ($rabbitmq) {
            $url = decodeUrl($message);
            $urls = crawl($url);
            $rabbitmq
                ->with(Publish::many($urls)->to('queue'))
                ->run();
        },
    ))
    ->run();
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

## Simple mais inefficace

^ simple au raisonnement mais inefficace

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

```sh
php consumer.php & php consumer.php &
```

---

## `robots.txt`

---

[.code-highlight: 1-3]
[.code-highlight: 4]

```
User-agent : Googlebot
Allow : /foo
Disallow : /bar
Crawl-delay : 10
```

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

^ noisy neighbour: un consumer peut empêcher les autres de run

---

[.code-highlight: 6]

```php
$rabbitmq
    ->with(Consume::of('queue')->handle(
        static function(Message $message) use ($rabbitmq) {
            $url = decodeUrl($message);

            lock($url); // appel bloquant

            $urls = crawl($url);
            $rabbitmq
                ->with(Publish::many($urls)->to('queue'))
                ->run();
        },
    ))
    ->run();
```

---

## Partitionnement / Sharding

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

---

[.code-highlight: 5-11]

```php
$rabbitmq
    ->with(Consume::of('queue')->handle(
        static function(Message $message) use ($rabbitmq) {
            $url = decodeUrl($message);
            $urls = crawl($url);
            $fr = $urls->filter(isDotFr(...));
            $org = $urls->filter(isDotOrg(...));
            $rabbitmq
                ->with(Publish::many($fr)->to('queue1'))
                ->with(Publish::many($org)->to('queue2'))
                ->run();
        },
    ))
    ->run();
```

^ problème un consumer peut être plus actif qu'un autre

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

^ problème valable pour des imports, webhooks, syncro de systèmes, etc...; problème de logique

---

## Actor Model

^ 1973 par Carl Hewitt, pb concurrence => supprimer concurrence

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

[.code-highlight: 1]
[.code-highlight: 3]
[.code-highlight: 5-6]
[.code-highlight: 7-15]

```php
final class Crawler implements Actor
{
    public function __invoke(Receive $receive): Receive
    {
        return $receive->on(
            Url::class,
            function(
                Url $url,
                Address $sender,
                Continuation $continuation,
            ) {
                $urls = crawl($url);

                return $continuation->continue($urls);
            },
        );
    }
}
```

---

[.code-highlight: 1]
[.code-highlight: 2-5]
[.code-highlight: 6-9]

```php
System::of()
    ->actor(
        Crawler::class,
        static fn() => new Crawler,
    )
    ->run(
        Crawler::class,
        Url::of('https://wikipedia.org'),
    );
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
        a3m["Mailbox"] --> a3["Actor 'wikipedia.org'"]
    end
    subgraph p4 ["Process 4"]
        a4m["Mailbox"] --> a4["Actor 'linuxfoundation.org'"]
    end
    subgraph p5 ["Process 5"]
        a5m["Mailbox"] --> a5["Actor 'wikipedia.fr'"]
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
    m0("First message") -..-> pr
```

^ actors come in systems alias diviser pour mieux régner, addresses as messages

---

[.code-highlight: 6]
[.code-highlight: 15]
[.code-highlight: 16-18]
[.code-highlight: 3-4]
[.code-highlight: 20]

```php
final class Crawler implements Actor
{
    /** @var array<string, Address> */
    private array $tlds;

    public function __construct(private Spawn $spawn)
    {
    }

    public function __invoke(Receive $receive): Receive
    {
        return $receive->on(
            Url::class,
            function(Url $url, Address $sender, Continuation $continuation) {
                $tld = $url->tld();
                $child = $this->tlds[$tld] ??= ($this->spawn)(
                    ChildCrawler::class,
                );

                $child($url);

                return $continuation->continue();
            },
        );
    }
}
```

---

[.code-highlight: 1]
[.code-highlight: 5-6]
[.code-highlight: 8-10]
[.code-highlight: 7]

```php
final class ChildCrawler implements Actor
{
    public function __invoke(Receive $receive): Receive
    {
        return $receive->on(
            Url::class,
            function(Url $url, Address $sender, Continuation $continuation) {
                $urls = crawl($url);
                $urls->foreach(static fn($url) => $sender($url));

                return $continuation->continue();
            },
        );
    }
}
```

---

[.code-highlight: 4]
[.code-highlight: 6-9]

```php
System::of()
    ->actor(
        Crawler::class,
        static fn($_, $__, Spawn $spawn) => new Crawler($spawn),
    )
    ->actor(
        ChildCrawler::class,
        static fn() => new ChildCrawler,
    )
    ->run(
        Crawler::class,
        Url::of('https://wikipedia.org'),
    );
```

---


## En pratique ça donne quoi ?

^ simple et scalable, pause

---

| Actor Model | RabbitMQ |
|:-:|:-:|
| Mailbox | Queue |
| Actor | Consumer |

---

```mermaid
flowchart TB
    subgraph rabbit["RabbitMQ"]
        q1["Queue '.org'"]
        q2["Queue '.fr'"]
        q3["Queue 'wikipedia.org'"]
        q4["etc..."]
    end
    subgraph s["Server"]
        subgraph p4["Process 4"]
            c4["Consumer"]
        end
        subgraph p3["Process 3"]
            c3["Consumer"]
        end
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
        q3["Queue 'wikipedia.org'"]
        q4["etc..."]
    end
    subgraph s["Server"]
        subgraph p2["Process 2"]
            c3["Consumer"]
            c4["Consumer"]
        end
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

```mermaid
flowchart TB
    subgraph rabbit["RabbitMQ"]
        q1["Queue '.org'"]
        q2["Queue '.fr'"]
        q3["Queue 'wikipedia.org'"]
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

## Avantages

---

## Scalabilité infinie

^ single process -> multi process -> cluster, WhatsApp, RabbitMQ

---

## Résilience

^ gestion des erreurs

---

## Déploiement progressif

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

![fit](demo.mp4)

---

## 🚧 <https://github.com/innmind/actors> 🚧

![inline](actors.png)

---

## Questions

![inline](open-feedback.png)![inline](signal.png)

X/Bluesky/Mastodon @Baptouuuu

<https://baptouuuu.github.io/conferences/>
