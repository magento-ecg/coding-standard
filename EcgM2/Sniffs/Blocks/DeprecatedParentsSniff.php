<?php

declare(strict_types=1);

namespace EcgM2\Sniffs\Blocks;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;
use EcgM2\Utils\Reflection;

class DeprecatedParentsSniff implements Sniff
{
    /**
     * @var string
     */
    protected $message = 'A Block class should not extend from deprecated parents';

    /**
     * @inheritdoc
     */
    public function register()
    {
        return [T_CLASS];
    }

    /**
     * {@inheritdoc}
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $className = Reflection::findClassName($phpcsFile);
        if (empty($className)) {
            return false;
        }

        // Make sure to load the file itself, so that autoloading can be skipped
        if (!class_exists($className)) {
            include_once($phpcsFile->getFilename());
        }

        $class = Reflection::getClass($className);
        $parentClass = $class->getParentClass();

        if (!$parentClass) {
            return;
        }

        foreach ($this->getDeprecatedClasses() as $deprecatedClass) {
            if ($parentClass->getName() !== $deprecatedClass['class']) {
                continue;
            }

            $warning = sprintf('Block parent "%s" is deprecated. %s', $deprecatedClass['class'], $deprecatedClass['advice']);
            $phpcsFile->addWarning($warning, null, 'deprecated-parent');
        }
    }

    /**
     * @return array
     */
    private function getDeprecatedClasses(): array
    {
        $url = 'https://github.com/extdn/extdn-phpcs/blob/master/Extdn/Sniffs/Blocks/DeprecatedParentsSniff.md';

        return [
            [
                'class' => 'Magento\Backend\Block\Widget\Form\Generic',
                'advice' => 'See '.$url
            ],
            [
                'class' => 'Magento\Backend\Block\Widget\Grid\Container',
                'advice' => 'See '.$url
            ]
        ];
    }
}
