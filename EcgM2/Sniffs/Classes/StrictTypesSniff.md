# Rule: Add `declare(strict_types=1)` to your PHP files
## Background
With PHP 7, it is possible to add type hinting to your code. However, this doesn't mean that types are actually enforced, unless strict typing is
enabled by adding `declare(strict_types=1)` to the top of each PHP file. 

## Reasoning
PHP code becomes more robust when type hinting (argument types, return types) are added. With the `declare(strict_types=1)` added, there is less
chance for bugs that related to type casting.

## How it works
This rule scans the source code to see whether a line `declare(strict_type=1)` occurs or not.

## How to fix
Simply add a statement `declare(strict_types=1)` to the top of your files:

    <?php
    declare(strict_types=1);

    namespace Foo\Bar;
