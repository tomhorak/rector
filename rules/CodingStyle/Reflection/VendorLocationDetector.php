<?php

declare (strict_types=1);
namespace Rector\CodingStyle\Reflection;

use PHPStan\Reflection\FunctionReflection;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\Php\PhpFunctionReflection;
use PHPStan\Reflection\ReflectionWithFilename;
use RectorPrefix20211030\Symplify\SmartFileSystem\Normalizer\PathNormalizer;
final class VendorLocationDetector
{
    /**
     * @var \Symplify\SmartFileSystem\Normalizer\PathNormalizer
     */
    private $pathNormalizer;
    public function __construct(\RectorPrefix20211030\Symplify\SmartFileSystem\Normalizer\PathNormalizer $pathNormalizer)
    {
        $this->pathNormalizer = $pathNormalizer;
    }
    /**
     * @param \PHPStan\Reflection\FunctionReflection|\PHPStan\Reflection\MethodReflection|\PHPStan\Reflection\ReflectionWithFilename $reflection
     */
    public function detectFunctionLikeReflection($reflection) : bool
    {
        $fileName = $this->resolveReflectionFileName($reflection);
        // probably internal
        if ($fileName === null) {
            return \false;
        }
        $normalizedFileName = $this->pathNormalizer->normalizePath($fileName);
        return \strpos($normalizedFileName, '/vendor/') !== \false;
    }
    /**
     * @param \PHPStan\Reflection\FunctionReflection|\PHPStan\Reflection\MethodReflection|\PHPStan\Reflection\ReflectionWithFilename $reflection
     * @return string|null
     */
    private function resolveReflectionFileName($reflection)
    {
        if ($reflection instanceof \PHPStan\Reflection\ReflectionWithFilename) {
            return $reflection->getFileName();
        }
        if ($reflection instanceof \PHPStan\Reflection\Php\PhpFunctionReflection) {
            return $reflection->getFileName();
        }
        if ($reflection instanceof \PHPStan\Reflection\MethodReflection) {
            $declaringClassReflection = $reflection->getDeclaringClass();
            return $declaringClassReflection->getFileName();
        }
        return null;
    }
}
