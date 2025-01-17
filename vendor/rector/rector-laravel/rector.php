<?php

declare (strict_types=1);
namespace RectorPrefix20211030;

use Rector\Core\Configuration\Option;
use Rector\Nette\NodeAnalyzer\BinaryOpAnalyzer;
use Rector\PHPUnit\NodeAnalyzer\TestsNodeAnalyzer;
use Rector\Set\ValueObject\SetList;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\Rector\Core\Configuration\Option::AUTO_IMPORT_NAMES, \true);
    $parameters->set(\Rector\Core\Configuration\Option::PATHS, [__DIR__ . '/src', __DIR__ . '/tests']);
    $parameters->set(\Rector\Core\Configuration\Option::SKIP, [
        // for tests
        '*/Source/*',
        '*/Fixture/*',
    ]);
    // needed for DEAD_CODE list, just in split package like this
    $containerConfigurator->import(__DIR__ . '/config/config.php');
    // reuqired for PHP 8
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autoconfigure()->autowire();
    // needed for sets bellow, only for this split package
    $services->set(\Rector\Nette\NodeAnalyzer\BinaryOpAnalyzer::class);
    $services->set(\Rector\PHPUnit\NodeAnalyzer\TestsNodeAnalyzer::class);
    $containerConfigurator->import(\Rector\Set\ValueObject\SetList::PHP_80);
    $containerConfigurator->import(\Rector\Set\ValueObject\SetList::PHP_74);
    $containerConfigurator->import(\Rector\Set\ValueObject\SetList::PHP_73);
    $containerConfigurator->import(\Rector\Set\ValueObject\SetList::DEAD_CODE);
};
