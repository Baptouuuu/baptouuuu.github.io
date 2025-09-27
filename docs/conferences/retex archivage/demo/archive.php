<?php
declare(strict_types = 1);

require __DIR__.'/vendor/autoload.php';

use Innmind\OperatingSystem\Factory;
use Innmind\Filesystem\{
    Directory,
    File,
    File\Content,
    Name,
};
use Innmind\Encoding\Tar;
use Innmind\Url\Path;
use Innmind\Immutable\{
    Sequence,
    Str,
    Predicate\Instance,
};
use Formal\ORM\{
    Manager,
    Id,
};

final class Document
{
    public function __construct(
        public Id $id,
        private string $name,
    ) {
    }

    public function toCsvLine(): string
    {
        return \sprintf(
            "\"%s\",\"%s\"\n",
            $this->id->toString(),
            $this->name,
        );
    }
}

$os = Factory::build();
$orm = Manager::filesystem(
    $os
        ->filesystem()
        ->mount(Path::of(__DIR__.'/var/orm/'))
        ->unwrap(),
);
$tar = Tar::encode($os->clock());

$documents = $orm
    ->repository(Document::class)
    ->all()
    ->sequence();
$var = $os
    ->filesystem()
    ->mount(Path::of(__DIR__.'/var/'))
    ->unwrap();

$csv = File::named(
    'documents.csv',
    Content::ofChunks(
        $documents
            ->map(static fn(Document $document) => $document->toCsvLine())
            ->map(Str::of(...)),
    ),
);
// Par simplicité on réutilise toujours le même fichier
$binaires = Directory::named(
    'binaires',
    $documents->map(
        static fn(Document $document): Directory => $var
            ->get(Name::of('bin'))
            ->keep(Instance::of(Directory::class))
            ->attempt(static fn() => new \Exception('Données perdues'))
            ->unwrap()
            ->rename(Name::of($document->id->toString())),
    ),
);

$archive = Directory::named(
    'archive',
    Sequence::lazy(static fn() => yield from [
        $csv,
        $binaires,
    ]),
);
$archive = $tar($archive);

$os
    ->filesystem()
    ->mount(Path::of(__DIR__.'/var/'))
    ->unwrap()
    ->add(File::named(
        'archive.tar',
        $archive,
    ))
    ->unwrap();
// ou pour afficher directement le contenu
// $archive
//     ->chunks()
//     ->foreach(static function(Str $chunk) {
//         echo $chunk->toString();
//     });
