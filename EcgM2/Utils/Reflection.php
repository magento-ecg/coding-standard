<?php
declare(strict_types=1);

namespace EcgM2\Utils;

use PHP_CodeSniffer\Files\File;
use ReflectionClass;
use ReflectionException;

class Reflection
{
    /**
     * @param string $className
     *
     * @return ReflectionClass
     * @throws ReflectionException
     */
    static public function getClass(string $className): ReflectionClass
    {
        return new ReflectionClass($className);
    }

    /**
     * @param File $phpcsFile
     *
     * @return string
     */
    static public function findClassName(File $phpcsFile): string
    {
        $tokens = $phpcsFile->getTokens();

        $namespaceParts = [];
        $namespaceFound = false;
        $className = '';
        $classFound = false;

        foreach ($tokens as $token) {
            if (!is_array($token)) {
                continue;
            }

            if ($token['type'] == 'T_NAMESPACE') {
                $namespaceFound = true;
                continue;
            } else if ($namespaceFound && $token['type'] == 'T_STRING') {
                $namespaceParts[] = $token['content'];
                continue;
            } else if ($namespaceFound && $token['type'] == 'T_SEMICOLON') {
                $namespaceFound = false;
                continue;
            }

            if ($token['type'] == 'T_CLASS') {
                $classFound = true;
                continue;
            } else if ($classFound && $token['type'] == 'T_STRING') {
                $className = $token['content'];
                $classFound = false;
                continue;
            }
        }

        if (!$className) {
            return '';
        }

        $className = implode('\\', $namespaceParts) . "\\$className";

        return $className;
    }
}
