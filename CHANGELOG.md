# Release Notes

## [Unreleased](https://github.com/kalel1500/laravel-hexagonal-and-ddd-architecture-utilities/compare/v1.4.0-beta.1...master)

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