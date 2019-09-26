# Tokens in Views Filter Criteria

## ★★★ GITHUB ★★★

**If you like the module please give a STAR on 
GitHub project page https://github.com/validoll/token_views_filter.**

## INTRODUCTION
The Tokens in Views Filter Criteria module allow to use tokens in views
**string, numeric and date** filter criteria values.

 * For a full description of the module, visit the project page:
   https://www.drupal.org/project/token_views_filter

 * To submit bug reports and feature suggestions, or to track changes:
   https://www.drupal.org/project/issues/token_views_filter

## REQUIREMENTS
This module has no specific requirements outside Drupal core.

## INSTALLATION
Install as you would normally install a contributed Drupal module. Visit:
https://www.drupal.org/documentation/install/modules-themes/modules-8
for further information.

## CONFIGURATION
Open any target view and open settings form of any string or numeric filter.Then check
field "Use tokens in value" in settings form and add global tokens to filter
value.

## FOR DEVELOPERS
You can use your own plugins to implement token views filters via Token Views Filter 
Plugin manager.
To create plugin put it to `src/Plugin/views/filter/token` folder and define 
with ID as original views filter plugin, like

```
/**
 * @Plugin(
 *   id = "string",
 * )
 */
```

A plugin should extend class of original views filter plugin, implements 
`Drupal\token_views_filter\TokenViewsFilterPluginInterface` and uses trait 
`Drupal\token_views_filter\TokensFilterTrait`.
Use `replaceTokens()` method to replace tokens in value.

### Example

```
<?php

namespace Drupal\token_views_filter\Plugin\views\filter\token;

use Drupal\token_views_filter\TokensFilterTrait;
use Drupal\token_views_filter\TokenViewsFilterPluginInterface;
use Drupal\views\Plugin\views\filter\StringFilter;

/**
 * Extending basic string filter to use tokens as value.
 *
 * @Plugin(
 *   id = "string",
 * )
 */
class TokensStringFilter extends StringFilter implements TokenViewsFilterPluginInterface {

  use TokensFilterTrait;

  /**
   * {@inheritdoc}
   */
  public function replaceTokens() {
    $this->value = $this->token->replace($this->value, ['view' => $this->view], ['clear' => TRUE]);
  }

}
```

### Schema definition

To use token views filter you should redefine original views filter schema 
in your module in file `config/schema/{module_name}.schema.yml`

For example:

```
views.filter.string:
  type: views_filter
  label: 'String'
  mapping:
    expose:
      type: mapping
      label: 'Exposed'
      mapping:
        required:
          type: boolean
          label: 'Required'
        placeholder:
          type: label
          label: 'Placeholder'
    value:
      type: string
      label: 'Value'
    use_tokens:
      type: boolean
      label: 'Use tokens'
```

You shuld add 

```
    use_tokens:
      type: boolean
      label: 'Use tokens'
```

to mapping of plugin.

## KNOWN ISSUES

If you know how to override definition of original views filter 
to add `use_tokens` property. Pls see
https://www.drupal.org/project/token_views_filter/issues/3083793
for more details.

## MAINTAINERS

 * Vyacheslav Malchik (validoll) - https://www.drupal.org/u/validoll
