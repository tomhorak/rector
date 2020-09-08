<?php

declare(strict_types=1);

namespace Rector\DowngradePhp74\Rector\Property;

use PhpParser\Node\Stmt\Property;
use Rector\Core\RectorDefinition\CodeSample;
use Rector\Core\RectorDefinition\RectorDefinition;
use Rector\Core\ValueObject\PhpVersionFeature;

/**
 * @see \Rector\DowngradePhp74\Tests\Rector\Property\DowngradeTypedPropertyRector\DowngradeTypedPropertyRectorTest
 * @see \Rector\DowngradePhp74\Tests\Rector\Property\NoDocBlockDowngradeTypedPropertyRector\DowngradeTypedPropertyRectorTest
 */
final class DowngradeTypedPropertyRector extends AbstractDowngradeTypedPropertyRector
{
    public function getDefinition(): RectorDefinition
    {
        return new RectorDefinition('Changes property type definition from type definitions to `@var` annotations.', [
            new CodeSample(
                <<<'PHP'
class SomeClass
{
    private string $property;
}
PHP
,
                <<<'PHP'
class SomeClass
{
    /**
    * @var string
    */
    private $property;
}
PHP
            ),
        ]);
    }

    /**
     * @return string[]
     */
    public function getNodeTypes(): array
    {
        return [Property::class];
    }

    public function getPhpVersionFeature(): string
    {
        return PhpVersionFeature::TYPED_PROPERTIES;
    }

    public function shouldRemoveProperty(Property $property): bool
    {
        return true;
    }
}