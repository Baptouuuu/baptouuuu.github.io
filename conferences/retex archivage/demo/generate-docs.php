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
use Innmind\IO\Stream\Size;
use Innmind\Url\Path;
use Innmind\Immutable\{
    Sequence,
    Str
};
use Innmind\BlackBox\Set;
use Formal\ORM\{
    Manager,
    Id,
};

final class Document
{
    public function __construct(
        private Id $id,
        private string $name,
    ) {
    }
}

$os = Factory::build();
$orm = Manager::filesystem(
    $os
        ->filesystem()
        ->mount(Path::of(__DIR__.'/var/orm/'))
        ->unwrap(),
);
$documents = $orm->repository(Document::class);
$binaires = $os
    ->filesystem()
    ->mount(Path::of(__DIR__.'/var/bin/'))
    ->unwrap();

$names = Set::strings()
    ->madeOf(Set::strings()->chars()->alphanumerical())
    ->between(1, 10)
    ->take(2_000)
    ->enumerate();

foreach ($names as $name) {
    $id = Id::new(Document::class);
    $orm
        ->transactional(
            static fn() => $documents
                ->put(new Document(
                    $id,
                    $name,
                ))
                ->either(),
        )
        ->memoize();
}

// Pour ne pas remplir votre disque dur un seul fichier est généré
$binaires
    ->add(File::named(
        'file.bin',
        Content::ofChunks(
            Sequence::lazy(
                static fn() => yield from Set::strings()
                    ->chars()
                    ->take(Size\Unit::megabytes->times(1))
                    ->enumerate(),
            )->map(Str::of(...)),
        )
    ))
    ->unwrap();
