# Rule: Do not use the object manager in templates or Classes
## Background
The Object Manager is responsible to create concrete objects for a required interface, and to generate code e.g. for adding plugins, factories, proxies.
It is used transparently by requesting a class/interface name as constructor dependency or in layout XML.

You can use it directly with `ObjectManager::getInstance()->get(SomeInterface::class)` and `ObjectManager::getInstance()->create(SomeInterface::class)`, but this is not encouraged.

## Reasoning
Magento offers an extensive system for dependency injection which allows us to access and create objects. It also makes it
very clear, which classes or interfaces are needed by a particular piece of code and forces the developer to re-evaluate
the design if there are too many. 

This dependency injection system uses the object manager, but it is an implementation detail that should stay hidden.
Bypassing this system leads to hidden dependencies and potentially to too many of them.

Besides, for separation of appearance and logic, a template should contain as little and uncomplex PHP code as possible.

## How it works
For all PHTML and PHP files, the sniff looks for string tokens "ObjectManager".

## How to fix
Given, your template contains code like this:

```php
<?php
$choo = \Magento\Framework\App\ObjectManager::getInstance()->get(\Choo\Choo::class);
```

1. if the template is accompanied by a custom block, you can add the dependency to the block:

    ```php
   <?php
   namespace Extdn\Example;

   use Magento\Framework\View\Element\Template;

   class TheBlock extends Template
   {
     /** @var Choo\Choo */
     private $choo;

     public function __construct(Context $context, Choo\Choo $choo)
     {
       $this->choo = $choo;   
     }
  
     public function getChoo(): Choo\Choo
     {
       return $this->choo;   
     }

   }
   ```
   
   and change the template to
   
   ```php
   <?php
   $choo = $block->getChoo();
   ```
2. Starting with Magento 2.2, **view models** are considered a better alternative to blocks. Add a view model, or use an existing one,
and add the dependency there:

    ```php
   <?php
   namespace Extdn\Example;

   use Magento\Framework\View\Element\Block\ArgumentInterface;

   class TheViewModel implements ArgumentInterface
   {
     /** @var Choo\Choo */
     private $choo;

     public function __construct(Choo\Choo $choo)
     {
       $this->choo = $choo;   
     }
  
     public function getChoo(): Choo\Choo
     {
       return $this->choo;   
     }

   }
   ``` 
   
   The view model is added to the block via layout XML:
   
   ```xml 
   <block name="my.block" template="Extdn_Example::template.phtml" >
     <arguments>
       <argument name="the_view_model" xsi:type="object">Extdn\Example\TheViewModel</argument>
     </arguments>
   </block>
   ``` 

   and can be used in the template like this:
   
   ```php
   <?php
   $theViewModel = $block->getData('the_view_model');
   $choo = $theViewModel->getChoo();
   ```
