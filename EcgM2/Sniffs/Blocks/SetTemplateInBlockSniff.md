# Rule: Do not use setTemplate in Block classes
## Background
When creating a Block class, a Block class could set its PHTML template in multiple ways: Through XML layout, through a
call to `$this->setTemplate()` and through a variable `$_template`. The new design of Block classes is to configure them
at constructor time, meaning that configuration options (like the template) are added using constructor arguments. This
allows for the XML layout to change the template. The template in the Block class is then only defined as a default value,
if the XML layout is not overriding the template: This default value is best defined via a protected variable
`$_template`. 

## Reasoning

If `$this->setTemplate()` is used instead, this could lead to potential issues: First of all, setters are deprecated in
Block classes (because constructor arguments should be preferred instead). Second, if `$this->setTemplate()` is added to
the constructor *after* calling upon the parent constructor, it would undo the configuration via XML layout. Simply put:
It is outdated and leads to issues quickly.

## How it works
This rule checks whether a Block class uses `$this->setTemplate()`.

## How to fix

If there is a match, the preferred way of optimizing your code would be as follows:

    class MyBlock extends Template
    {
        protected $_template = 'foobar.phtml';
    }

