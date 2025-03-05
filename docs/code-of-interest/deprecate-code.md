# Marcar funciones como deprecadas

```php
/**
* @deprecated This function is deprecated and will be removed in a future version. Alternatively you can use "other()".
*/

function deprecated_function() {
   trigger_error('The function "deprecated_function()" is deprecated.', E_USER_DEPRECATED);
}
```
