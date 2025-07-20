autoscale: true
theme: Fira, 6

## Archiver efficacement de grands volumes de données grâce aux monades

---

[.list: alignment(left)]

- Baptiste Langlade
- Lyon
- 10+ ans XP
- ~100 packages Open Source

---

![inline 200%](efalia.png)

---

## GED

^ on premise => interventions difficiles

---

[.list: alignment(left)]

- Documents
    - Métadonnées
    - 1..N binaires

^ utiliser la carte d'identité pour expliquer les N versions

---

## Archivage

^ archivage définies par métadonnées, sur plusieurs années/décennies

---

[.list: alignment(left)]

- Archive
    - CSV des documents
    - Dossiers contenant les binaires

^ en 1 seul fichier

---

## Contraintes

^ taille archive, intervention impossible

---

## Comment on fait ?

---

## Streaming de données

---

```php
/** @var \Generator<int> */
$stream = function(): \Generator {
    $i = 0;

    while (true) {
        yield $i++;
    }
};
```

---

```php
foreach ($stream() as $i) {
    echo $i."\n";
}
```

```txt
Output :
1
2
3
etc...
```

^ important avoir une seule variable en mémoire


---

```php
/**
 * @param callable(): \Generator<int> $stream
 * @var \Generator<int>
 */
$double = function(callable $stream): \Generator {
    foreach ($stream() as $i) {
        yield $i * 2;
    }
};
```

---

```php
foreach ($double($stream) as $i) {
    echo $i."\n";
}
```

---

## Monades

---

```sh
composer require innmind/immutable
```

---

```php
use Innmind\Immutable\Sequence;

/** @var Sequence<int> */
$stream = Sequence::lazy(function() {
    $i = 0;

    while (true) {
        yield $i++;
    }
});
```

---

```php
$stream->foreach(function(int $i) {
    echo $i."\n";
});
```

---

[.code-highlight: 1-2]

```php
/** @var Sequence<int> */
$double = $stream->map(fn(int $i) => $i * 2);
$double->foreach(function(int $i) {
    echo $i."\n";
});
```

^ pause

---

## Style monadique

^ le jeu est de tout représenter via des Sequence

---

### SQL

```php
/** @var Sequence<array> */
$rows = function(string $query): Sequence {};
```

---

### ORM

```php
/** @var Sequence<Entity> */
$entities = function(): Sequence {};
```

---

```sh
composer require formal/orm
```

---

```php
/** @var Sequence<Document> */
$documents = $orm
    ->repository(Document::class)
    ->all()
    ->sequence();
```

---

![](conf-orm.png)

---

### Fichier

```php
final class File
{
    public function __construct(
        private string $name,
        /** @var Sequence<string> */
        private Sequence $content,
    ) {}
}
```

---

### Dossier

```php
final class Directory
{
    public function __construct(
        private string $name,
        /** @var Sequence<File|Directory> */
        private Sequence $content,
    ) {}
}
```

---

```sh
composer require innmind/filesystem
```

---

```php
use Innmind\Filesystem\File;
use Innmind\Filesystem\File\Content;
use Innmind\Immutable\Sequence;
use Innmind\Immutable\Str;

$file = File::named(
    'data.csv',
    Content::ofChunks(
        Sequence::of("line, 1\n", "line, 2\n", "etc...")
            ->map(Str::of(...)),
    ),
);
```

---

```php
use Innmind\Filesystem\Directory;

$directory = Directory::named(
    'files',
    Sequence::of(
        File::named('something', $content),
        Directory::named(...$args),
        // etc...
    ),
);
```

^ pause

---

[.list: alignment(left)]

## Cas d'usage

- Archive
    - CSV des documents
    - Dossiers contenant les binaires

---

[.code-highlight: 1]
[.code-highlight: 2]
[.code-highlight: 3-10]
[.code-highlight: 8]
[.code-highlight: 1-11]

```php
$csv = File::named(
    'documents.csv',
    Content::ofChunks(
        $orm
            ->repository(Document::class)
            ->all()
            ->sequence()
            ->map(fn(Document $document): string => $document->toCsvLine())
            ->map(Str::of(...)),
    ),
);
```

---

[.code-highlight: 6-12]
[.code-highlight: 7]
[.code-highlight: 8]
[.code-highlight: 9]
[.code-highlight: 10]
[.code-highlight: 11]
[.code-highlight: 6]

```php
use Innmind\Filesystem\Adapter\Filesystem;
use Innmind\Filesystem\Name;
use Innmind\Url\Path;
use Innmind\Immutable\Predicate\Instance;

$fetch = function(Document $document): Directory {
    return Filesystem::mount(Path::of('var/data/'))
        ->get(Name::of($document->id()->toString()))
        ->keep(Instance::of(Directory::class))
        ->attempt(fn() => new \Exception('Données perdues'))
        ->unwrap();
};
```

---

```php
$binaires = Directory::named(
    'binaires',
    $orm
        ->repository(Document::class)
        ->all()
        ->sequence()
        ->map($fetch),
);
```

---

```php
$archive = Directory::named(
    'archive',
    Sequence::lazy(fn() => yield from [
        $csv,
        $binaires,
    ]),
);
```

---

```sh
composer require innmind/encoding
```

---

[.code-highlight: 1-4]
[.code-highlight: 6-7]

```php
use Innmind\Encoding\Tar;
use Innmind\TimeContinuum\Clock;

$tar = Tar::encode(Clock::live());

/** @var \Innmind\Filesystem\File\Content */
$archive = $tar($archive);
```

---

[.code-highlight: 1-3]
[.code-highlight: 5-6]

```php
use Innmind\Encoding\Gzip;

$compress = Gzip::compress();

/** @var \Innmind\Filesystem\File\Content */
$archive = $tar($archive);
```

---

```php
$documents = fetchDocuments($orm);
$archive = Directory::named(
    'archive',
    Sequence::lazy(fn() => yield from [
        toCsv($documents),
        binaires($documents),
    ]),
);
$archive = $tar($archive);
$archive = $compress($archive);
```

^ aucun traitement effectué pour l'instant

---

```php
use Symfony\Component\HttpFoundation\StreamedResponse;

new StreamedResponse(
    fn() => $archive
        ->chunks()
        ->foreach(function(Str $chunk) {
            echo $chunk->toString();
            \flush();
        });
);
```

---

[.list: alignment(left)]

## Statistiques

- 100k documents
- ~80Go
- ~45 minutes
- ~45Mo/s (~18Mo/s avec compression)
- ~8Mo de RAM

---

## Stateless

---

![](doc.png)

### Documentation

![inline](qr.png)

---

![](actor-model.png)

---

## Questions

![inline](open-feedback.png)![inline](signal.png)

X/Bluesky/Mastodon @Baptouuuu

<https://baptouuuu.github.io/conferences/>
