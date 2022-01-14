# Rule: Do not extend from deprecated block parents
## Background
Some parent classes have been deprecated in Magento 2.2 and should therefore no longer be used in code:
- `Magento\Backend\Block\Widget\Form\Generic`
- `Magento\Backend\Block\Widget\Grid\Container`

## Reasoning
Once a Block class is extending upon one of these deprecated parents, they should be refactored into something else instead. Ideally, this is a uiComponent.
The main reason why a uiComponent is preferred over a regular Block-driven output, is that a uiComponent is much more extensible than Blocks.

## How it works
This rule uses PHP Reflection to determine the class its parent and then checks whether the parent matches a deprecated parent.

## How to fix
The Block class should ideally be removed. Instead, a uiComponent should be created instead, consisting of an XML file in the `ui_component` folder plus PHP sources.
