
# Porque Laravel renderiza varias excepciones HTTP de forma diferente

Laravel maneja las HttpException de una forma especial, ya que tiene varias blades creadas que las devolverá aunque tenga el debug=true:
* 401
* 402
* 404
* 419
* 429
* 500
* 503

Estas vistas nunca mostrarán el mensaje de la excepción porque no está en la blade.

El método abort() también lanza una excepción HTTP por lo que se comportara igual.

Para que el método abort() renderice la vista de errores debe tener un código diferente a los de arriba

En pro los código que no están arriba muestran la vista "Oops! An Error Occurred" pero sin mostrar el error