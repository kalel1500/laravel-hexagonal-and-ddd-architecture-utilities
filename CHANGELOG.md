# Release Notes

## [Unreleased](https://github.com/kalel1500/laravel-hexagonal-and-ddd-architecture-utilities/compare/v1.6.0-beta.1...master)

## [v1.6.0-beta.1](https://github.com/kalel1500/laravel-hexagonal-and-ddd-architecture-utilities/compare/v1.5.0-beta.1...v1.6.0-beta.1) - 2024-09-10

### Added

* Nuevos métodos `toNoSpaces()` y `toCleanString()` en `ContractValueObject`.
* Nuevos métodos `formatToSpainDatetime()` y `carbon()` en `ContractDateVo`
* Nuevos métodos `toNull()` y `toNotNull()` en `ContractValueObject` (y nuevas constantes para guardar las clases y hacer el cálculo).
* Nuevo método `toCamelCase()` en `ContractValueObject`.
* Nuevo método `toArrayCalculatedProps` en `ContractEntity` para poder sobreescribirlo y definir las propiedades calculadas.
* Nuevo método `clearString` en la clase `ContractStringVo` para hacer que si se recibe un string vacío, se asigne el valor `null`.
* Registrar en el `ServiceProvider` la relación entre la interfaz del StateRepository y su implementación (en el array de `$singletons`) para no tener que hacerlo en la aplicación.
* Nuevo método `from()` en la clase `ContractModelId` + utilizarlo en lugar del `new ModelIdNull` en las entidades.

### Changed

* Sobreescribir método `new()` en el ArrayTabulatorFiltersVo para poder pasarle todos los parámetros que tiene el constructor.
* Permitir que al definir las relaciones, si son asociativas, la key pueda tener varias con punto. Ej: `[relOne.SubRel1 => [SubRel2, SubRel3]`.
* Ordenar y documentar las variables de entorno del archivo de configuración del paquete.
* Rediseño completo de la gestión de errores:
    * Ordenar y documentar código del `ExceptionHandler`.
    * Mover renderizado de las excepciones del dominio al `ExceptionHandler`.
    * Añadir información previous al `toArrayForDebug`.
    * Permitir que el $message y el `$code` sean opcionales en el `DomainBaseException`.
    * No hacer que el `previous` sobreescriba la información de la excepción actual.
    * Modificar mensajes de error de las excepciones.
    * Implementar bien la Hexagonal.
    * Excepciones ordenadas y renombradas.
    * Parámetros ordenados y simplificados.
    * Nuevo parámetro `$statusCode` en las excepciones para no usar el `$code` que no es para eso.
    * Los códigos HTTP se definen en las excepciones en lugar de pasarlo cada vez (asi por cada ex se controla su code).
    * Lógica `getExceptionData()` y `getExceptionMessage()` movida al DTO `ExceptionContextDo`.
    * Clase `CustomException` renombrada a `GeneralException`.
    * `ExceptionHandler` mejorado con el `getStatusCode()` del contexto.
    * Nuevo código comentado en el `ExceptionHandler` para en un futuro poder sobreescribir otras excepciones (database).
    * Nuevo código comentado en el `ExceptionHandler` para en un futuro poder sobreescribir el renderizado de la vista de errores (por si se quiere pasar una excepción previa).
    * Ahora el `responseJsonError()` ya no hace falta para las excepciones de dominio (y para las otras casi tampoco).
* Mejorar método `MyCarbon::parse()` para que no devuelva `null`.
* Hacer que el método `createFromObject()` de la clase `ContractEntity` no sea obligatorio.
* Modificar métodos `toUppercase()` y `toLowercase()` de `ContractValueObject`.
* No permitir ni devolver null en el `fromArray()` y `fromObject()`.
* Rediseño completo del funcionamiento de las Entidades y sus relaciones:
  * Una entidad solo tiene que tener sus propiedades en el constructor (ni relaciones ni propiedades calculadas en eloquent).
  * En lugar de recibir los cálculos de eloquent, se definirán en la entidad utilizando las relaciones definidas también en la entidad.
  * Se ha creado el nuevo método `toArrayCalculatedProps()` para separar los campos de las propiedades calculadas y poder decidir si traerlas o no al crear las entidades y relaciones.
  * Nuevos métodos `getRelation()` y `setRelation()` `ContractEntity` para poder definir mejor las relaciones en las entidades y no tener que definir una propiedad para cada relación.
  * Al crear las entidades y colecciones se podrá pasar el parámetro `$isFull` para indicar si se tiene que traer las propiedades calculadas.
  * Al crear las entidades y colecciones, en las relaciones se podrá añadir un flag para indicar si son full o no. Ej.: `OneEntityCollection::fromArray($data, ['relOne:f', 'relTwo:s', 'relThree:f.subRelOne:s'])`.
  * Se ha definido la variable de entorno `HEXAGONAL_ENTITY_CALCULATED_PROPS_MODE` para definir si como se comportan las relaciones por defecto cuando no se indica el flag.
* Mejorar la lógica del método `pluck()` de la clase `ContractCollectionBase`.
* Utilizar las nuevas interfaces en el método `getItemToArray()` y hacer el código más legible.
* Renombrar método `toArrayWithAll` por `toArrayForBuild` en la clase `ContractDataObject` (nueva interfaz `BuildArrayable` para indicar que la clase debe contener el método `toArrayForBuild()`).
* Renombrar interfaces: `MyArrayableContract` a `Arrayable` y `ExportableEntityC` a `ExportableEntity`.
* Modificar firma métodos de `ContractCollectionEntity` y `ContractEntity`, para permitir que se pueda recibir un string en lugar de un array en el parámetro `$with`.
* Dejar que se cree la relación vacía si no hay datos en el método `with()` de la clase `ContractEntity`.
* Cambiar el `new ModelIdNull(...)` de las entidades por el `ModelId::from(...)` para que solo se cree la instancia `ModelIdNull` si el valor recibido es null y de lo contrario se cree la instancia de `ModelId`.

### Removed

* Eliminar método `toArrayForJs()` de la clase `ContractDataObject`.
* Eliminar `FindStateByCodeUseCase` de infraestructura y mover lógica a `StateDataService` en el dominio.
* Eliminar el método `toModelId` de la clase `ModelIdNull`.

### Fixed

* Solucionado error en el método `fromArray()` cuando recibimos una paginación (no se estaba setenado bien el `$data` tras guardar los datos de la paginación).
* Solucionar error de tipo en el método `flatten()` de `ContractCollectionBase`.
* Quitar lógica duplicada:
  * Quitar parámetro `$last` método `setFirstRelation()` de la clase `ContractEntity` y no pasarlo al método `$setRelation()` de cada entidad (ya que de esto se encarga el método `setLastRelation()`).
  * Quitar parámetro `$with` método `fromRelationData()` de la clase `ContractCollectionEntity`, ya que, los métodos `set...()` de las entidades que llaman a este método ya no reciben en `$with`.

## [v1.5.0-beta.1](https://github.com/kalel1500/laravel-hexagonal-and-ddd-architecture-utilities/compare/v1.4.0-beta.3...v1.5.0-beta.1) - 2024-08-16

### Added

* Nuevo archivo `development-tips.md` para guardar los comandos de git recurrentes

### Changed

* Renombrar método `items()` a `all()`
* Mover propiedad `$item` encima de `$allowNull`
* Permitir que sea `null` el parámetro `$relationName` del helper `getSubWith()`
* Método `toBase()` simplificado y hecho privado
* Sacar transformaciones de la función `$getItemValue` y crear una llamada `$clearItemValue` en el método `pluck()` para poder añadir más adelante el `setPreviousClass`
* Mejora método `collapse()`: Unir el `$item->toArray()` en el mismo `if()` mirando la instancia `MyArrayableContract`
* Método `->values()` de la clase `ContractCollectionBase.php` modificado para que sea como el de Laravel, ya que antes no hacía nada util
* Mejoras `@PHPDoc`

## [v1.4.0-beta.3](https://github.com/kalel1500/laravel-hexagonal-and-ddd-architecture-utilities/compare/v1.4.0-beta.2...v1.4.0-beta.3) - 2024-08-16

### Added

* Nuevo método `pluckTo()` en la clase `ContractCollectionBase.php` (para que tras hacer el `pluck`, haga directamente el `toCollection`)
* Nueva versión de la imagen del título del `README.md`
* Indicar con `@phpdoc` que el método `toCollection()` devuelve una instancia de la clase que recibe como argumento

### Changed

* Pasar el `$pluckField` al `toBase()` en lugar del `$with` y calcular el `getWithValue()` dentro
* Método `getWithValue()` simplificado

### Removed

* Eliminados svgs del `README.md` que no se utilizan
* Eliminar método `getWithValue()` y mover lógica al `toBase()`
* Quitar lógica `isInstanceOfRelatable()` y `isClassRelatable()` de `DomainHeplers.php` y hacer que las clases con relaciones implementen la interfaz `Relatable`

## [v1.4.0-beta.2](https://github.com/kalel1500/laravel-hexagonal-and-ddd-architecture-utilities/compare/v1.4.0-beta.1...v1.4.0-beta.2) - 2024-08-12

### Added

* Añadir CHANGELOG.md con todos los cambios de cada version (todos los tags renombrados por nuevos tags beta)
* composer.json: Añadir "minimum-stability" y "prefer-stable"

## [v1.4.0-beta.1](https://github.com/kalel1500/laravel-hexagonal-and-ddd-architecture-utilities/compare/v1.3.0-beta.2...v1.4.0-beta.1) - 2024-07-19

### Changed

!!!Gran refactor de la gestión de errores (mejorada y simplificada):
* `BasicException` -> parámetros null y valores por defecto
* `DomainHelpers` -> parámetros abort
* `DomainHelpers::getExceptionData()` -> trasladar estructuras al objeto `DataExceptionDo` y simplificar método
* `ContractDataObject` -> `toArray()` de los métodos cambiados por el `toArrayVisible()` para que no afecta cuando se cambie uno
* `DomainBaseException` -> simplificar estructura con el getExceptionData()
* `ExceptionHandler` -> cambiar orden del array
* `responseJsonError()` -> simplificar código con el `getExceptionData()`

## [v1.3.0-beta.2](https://github.com/kalel1500/laravel-hexagonal-and-ddd-architecture-utilities/compare/v1.3.0-beta.1...v1.3.0-beta.2) - 2024-07-19

### Fixed

* Mejora método `pluck` de la `CollectionBase` para que funcione con las propiedades readonly en PHP 8.2

## [v1.3.0-beta.1](https://github.com/kalel1500/laravel-hexagonal-and-ddd-architecture-utilities/compare/v1.2.0-beta.1...v1.3.0-beta.1) - 2024-07-17

### Changed

* `HexagonalServiceProvider`: mover `mergeConfigFrom()` del `register()` a su método especifico `configure()`
* `HexagonalServiceProvider`: meter prefijo `__DIR__.'/../../` de las rutas a la variable `HEXAGONAL_PATH`
* `HexagonalServiceProvider`: Eliminar método `addNewConfigLogChannels()` y meter código en `HexagonalService::setLogChannels()` para dejar el provider más limpio
* `HexagonalServiceProvider`: Mover método `HexagonalService::setLogChannels()` del `boot()` al `register()` (configure)
* Clase `HexagonalService` movida de `rc/Domain/Services` a `src/Infrastructure/Services`, ya que ahora utiliza el método `config()` de laravel
* Clase `HexagonalService` renombrada a `Hexagonal`
* `HexagonalServiceProvider`: registrar y publicar vistas
* Reestructurar vistas: Mover vista jobs.blade.php de `/views/queues/` a `/views/`

### Removed

* Quitar referencia vista externa `pages.errors.custom-error` en `DomainBaseException` trayendo el html a la vista `hexagonal::custom-error`

## [v1.2.0-beta.1](https://github.com/kalel1500/laravel-hexagonal-and-ddd-architecture-utilities/compare/v1.1.0-beta.4...v1.2.0-beta.1) - 2024-06-28

### Added

* Clase `MyJob`: Añadir parámetro `$logChannel` en los métodos para indicar donde guardar el Log
* Configurar los canales `queues` y `loads` para los Logs
* Clase `MyLog`: nuevos métodos `errorOnLoads` y `errorOn`

### Changed

* Clase `MyLog`: método `onQueuesError` renombrado a `errorOnQueues`

### Removed

* Clase `MyJob`: Quitar `echo` del mensaje de error
* Clase `MyJob`: Quitar fecha del mensaje, ya que el log ya pone la fecha

### Fixed

* Sol. error en la forma de mergear la configuracion de los nuevos canales de Logs

## [v1.1.0-beta.4](https://github.com/kalel1500/laravel-hexagonal-and-ddd-architecture-utilities/compare/v1.1.0-beta.3...v1.1.0-beta.4) - 2024-06-26

### Fixed

* Sol. error: columna `class` renombrada a `code` en la migración de la tabla `states` y eliminar restricción `class_type_unique`

### Removed

* Quitar dependencia del paquete `laravel-ts-utilities` del `composer.json` y el `README.md`

## [v1.1.0-beta.3](https://github.com/kalel1500/laravel-hexagonal-and-ddd-architecture-utilities/compare/v1.1.0-beta.2...v1.1.0-beta.3) - 2024-06-19

### Added

* Añadir las rutas `queues.checkService` y `websockets.checkService` al paquete
* Crear nuevas rutas ajax para obtener los Jobs y los Jobs Fallidos (`getJobs` y `getFailedJobs`)
* Nuevas rutas `queues.queuedJobs` y `queues.failedJobs` que solo devuelven una vista html con un id para tabulator
* Navbar añadido en la vista de Jobs
* `composer.json`: Añadir scripts `post-install` y `post-update` para que se instale el paquete de NPM `laravel-ts-utilities` (ya que es necesario para las vistas de los Jobs)
* `README`: Añadir información paquete laravel-ts-utilities
* `README`: Cambiar enlace del paquete laravel-ts-utilities del de NPM al de Github

### Removed

* Quitar el prefijo de las rutas "hexagonal" en la configuración

## [v1.1.0-beta.2](https://github.com/kalel1500/laravel-hexagonal-and-ddd-architecture-utilities/compare/v1.1.0-beta.1...v1.1.0-beta.2) - 2024-06-13

### Removed

* Quitar condición `runningInConsole()` al registrar los comandos para poder usarlos desde el código con `Artisan:call()`

## [v1.1.0-beta.1](https://github.com/kalel1500/laravel-hexagonal-and-ddd-architecture-utilities/compare/v1.0.0-beta.2...v1.1.0-beta.1) - 2024-06-13

### Changed

* Hacer finales todas las clases que no se van a extender
* Cambio de la Licencia del proyecto por `GNU General Public License v3.0`

### Removed

* Quitar el throws del PhpDoc del método `emitEvent()` ya que tiene un `tryCatch`

## [v1.0.0-beta.2](https://github.com/kalel1500/laravel-hexagonal-and-ddd-architecture-utilities/compare/v1.0.0-beta.1...v1.0.0-beta.2) - 2024-05-23

### Added

* Nuevo `ExceptionHandler.php` con el método `getUsingCallback()` para pasar como callback en el método `withExceptions()` al crear la aplicación en `/bootstrap/app.php -> Application::configure()->withExceptions(callback())`. Es para que todas las excepciones que devuelvan un Json tengan la estructura `['success' => ..., 'message' => '...', 'data' => []]`

### Removed

* Eliminar puntos y coma innecesarios

## v1.0.0-beta.1 - 2024-05-23

Primera versión funcional del paquete