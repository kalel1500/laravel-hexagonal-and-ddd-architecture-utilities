# Release Notes

## [Unreleased](https://github.com/kalel1500/laravel-hexagonal-and-ddd-architecture-utilities/compare/v1.12.0-beta.0...master)

## [v1.12.0-beta.0](https://github.com/kalel1500/laravel-hexagonal-and-ddd-architecture-utilities/compare/v1.11.0-beta.0...v1.12.0-beta.0) - 2024-11-26

### Added

* docs: Nuevo archivo `todo-list.md` con las siguientes tareas del paquete
* stubs:
  * añadir nuevo `web_php_old.php` adaptado al `PHP < 8` (en el futuro se añadirá una condición en el comando `hexagonal:start`)
  * añadir blade `welcome.blade.php`, ya que tras las instalaciones hay que comprobar la extension del archivo JS al usar la directiva `@vite()`
* cookies:
  * Nuevo Middleware `AddPreferencesCookies.php` que genera las cookies (si no existen) con las preferencias del usuario por defecto 
  * Añadir código para registrar el middleware en el `HexagonalServiceProvider.php`
  * Nuevas variables de configuración para las cookies y las preferencias del usuario
  * Nuevo servicio `CookieService` con la lógica de la creación de la cookie para poder reutilizarla desde la aplicación
  * Nueva ruta `/cookie/update` (controller `AjaxCookiesController`) para actualizar la cookie por ajax
  * Nueva clase `CookiePreferencesDo` para simplificar el código y el flujo de la clase `CookieService`
  * Hacer que por defecto el `sidebarCollapsed` del `Layout/App` se configure globalmente (`config('hexagonal.sidebar_collapsed_default')`) y solo usar los items si `config('hexagonal.sidebar_state_per_page') === true`
  * Nueva variable $darkMode en `Layout/App` (`hexagonal.dark_mode_default`) para configurar por defecto el modo oscuro
  * Añadir nueva lógica en `Layout/App` para establecer las variables `$darkMode` y `$sidebarCollapsed` según las cookies recibidas (si están habilitadas)
  * Leer variables de configuración de las cookies del archivo `.env`
  * (fix) comprobar la config del dark-mode al pintar los iconos `theme-toggle`, ya que por defecto estaban ocultos a la vez
  * Nueva vista de ejemplo `example/modify-cookie` con botones para modificar la cookie desde el front (código TS)

### Changed

* Paquete `laravel-ts-utilities` actualizado a la version `1.3.0-beta.4`
* docs: archivo `development-tips.md` actualizado con el regex para excluir carpetas al comparar dos proyectos
* Layout:
  * (refactor) ordenar head del componente `layout/app`
  * Modificar font-weight de los enlaces del sidebar cuando está colapsado
  * Componente `icon.user` renombrado a `icon.user-profile`
  * icons: 
    * Creados nuevos componentes para los iconos
    * Nueva ruta `example/icons` con la vista de todos los iconos disponibles
    * Modificar los iconos para que reciban los `$attributes`, las propiedades `strokeWidth`, `flowbite` y `outline` y estructurarlos para poder añadir los tres tipos de iconos
    * Cambiar todos los iconos de SVG a los nuevos componentes (nuevo componente `<x-render-icon>` para poder renderizar por el componente, el nombre, o el nombre con la clase separados por `;`
  * Nuevos enlaces añadidos al Sidebar con todas las rutas definidas hasta ahora
  * (fix) Corregir títulos de las páginas
  * stubs: Ponerle nombre a la ruta `welcome` (para poder acceder a ella desde el sidebar)
* stubs: Cambios ruta `/home` 
  * renombrar y mover controller de `Src\Home\Infrastructure\HomeController` a `Src\Shared\Infrastructure\Http\Controllers\DefaultController` 
  * renombrar método de `index` a `home` 
  * renombrar y mover vista de `pages.home.index` a `pages.default.home` 
  * renombrar nombre de ruta de `home.index` a `home` 
  * Añadir texto `Hola mundo` en la vista `home.blade.php`
* Añadir validación en la migración `create_states_table` para comprobar que no exista la tabla `states` antes de crearla
* Nuevos métodos `fromJson()` `toJson()` y `__toString()` en la clase `ContractDataObject.php` + hacer que implemente la interfaz `Jsonable`
* Cambios servicio `Hexagonal.php`:
    * (breaking) Modificar clase `Hexagonal.php` para hacer que sea configurable en cadena
    * (breaking) Establecer valor `$runsMigrations` por defecto a `false` para que por defecto no se ejecuten las migraciones del paquete y haya que activarlas manualmente desde la aplicación
    * Añadir configuración en la clase `Hexagonal` para activar las Cookies de las preferencias que por defecto están desactivadas
* (breaking) Mover la carpeta `Controllers` dentro de `Http`
* Cambios en el `HexagonalServiceProvider`:
  * Añadir nueva publicación en el `registerPublishing()` del `HexagonalServiceProvider.php` para permitir publicar el componente `layout/app` de forma independiente con el tag `hexagonal-view-layout`, ya que es el componente que más se puede querer editar
  * (fix) Cambiar validación `shouldRegistersRoutes()` por `shouldRunMigrations()` al publicar las migraciones
* Comando `hexagonal:start`
  * Modificar el comando `hexagonal:start` para que no elimine la carpeta `app/Models`
  * (fix) Añadir la ruta completa a la clase `Hexagonal` al añadir la línea `Hexagonal::ignoreMigrations()` al `AppServiceProvider` en el comando `hexagonal:start` para no tener que importar la clase
  * Descomentar la línea `Hexagonal::ignoreMigrations()` en el comando `hexagonal:start` para que por defecto se ignoren las migraciones del paquete
  * (fix) Añadir las clases de los componentes al publicar las vistas en el comando `hexagonal:start`
  * adaptar escritura del `AppServiceProvider` a la nueva forma de configuración del paquete (y hacer que por defecto esté comentada)

### Fixed

* (fix) Arreglar directiva blade `@viteAsset`, ya que debe ejecutar el código en la vista y no al declarar la directiva (funcionaba solo porque le pasaba un parámetro estático)
* (fix) Definir manualmente los archivos en los que tailwind tiene que buscar las clases al compilar el css
* stubs: (fix) sol. error en la ruta del import `DefaultController`
* (fix) solucionar error vite poniendo el `publicDir` a `false` (ya que coincide con el `outDir`)
* stubs: (fix) corregir nombre ruta /home (`home.index`) para que sea coherente con el paquete del front

## [v1.11.0-beta.0](https://github.com/kalel1500/laravel-hexagonal-and-ddd-architecture-utilities/compare/v1.10.0-beta.1...v1.11.0-beta.0) - 2024-11-11

### Added

* Añadidas las traducciones en español (del paquete `Laraveles/spanish`)
* Publicadas las traducciones de laravel en el paquete

### Changed

* (breaking) Renombrar propiedad `$allowNull` por `$nullable` y método `checkAllowNull()` por `checkNullable()` (en todas las clases que los usan)
* (breaking) Eliminar helpers innecesarios `HTTP_...()` ya que son constantes que están definidas en la clase `Symfony\Component\HttpFoundation\Response`
* (breaking) Eliminar propiedades `$reasonNullNotAllowed`, `$mustBeNull` y `$reasonMustBeNull` y simplificar lógica `checkAllowNull()` de la clase `ContractValueObject` (se ha movido la lógica a la aplicación que la usa, ya que es un caso concreto de esa aplicación)
* (phpdoc) Añadir el tipo de retorno `null` en el PhpDoc del método `CollectionEntity::fromArray()`
* (breaking) Modificar parámetro `$isFull` de las entidades para que se pueda pasar un `string` con el nombre del método que queramos usar para obtener las propiedades calculadas de la entidad al hacer el `toArray()`
* Añadir la propiedad `$datetime_eloquent_timestamps = 'Y-m-d\TH:i:s.u\Z'` en el helper `MyCarbon`
* Añadir el `->setTimezone()` en el método `carbon()` de la clase `ContractDateVo` (por si es una fecha UTC) y guardar en la propiedad `$valueCarbon` para evitar hacer el cálculo varias veces
* Nuevo método `from()` en la clase `ContractDateVo` para poder crear las fechas con formato `timestamp` (de Eloquent) que se formatean con el timezone UTC en el `toArray()`
* (phpdoc) simplificar return types en los PhpDoc (cambiar varios `@return T` por `@return static` o `@return $this`)
* Añadir `@stack('css-variables')` y `@stack('styles')` en el componente `layout/app.blade.php` para poder añadir CSS adicional en cada página

### Fixed

* (fix) Prevenir error si el método `CollectionEntity::fromArray()` recibe un `null`
* (fix) Sobreescribir método `new()` en la clase `ContractDateVo` para pasar el parámetro `$formats` al constructor

## [v1.10.0-beta.1](https://github.com/kalel1500/laravel-hexagonal-and-ddd-architecture-utilities/compare/v1.10.0-beta.0...v1.10.0-beta.1) - 2024-11-11

### Added

* docs: `code-of-interest` -> código interesante para añadir limitaciones a las peticiones por API (`limit-api-action.md`)
* stubs: Nueva carpeta `stubs` con todos los archivos necesarios en el comando `HexagonalStart`
* Nuevo comando (`HexagonalStart`) creado para crear los archivos iniciales en la aplicación
  <details>
  
    - creados: 
      - crear provider `app/Providers/DependencyServiceProvider.php`
      - crear vista `resources/views/pages/home/index.blade.php`
      - crear controlador `src/Home/Infrastructure/HomeController.php`
      - crear servicio `src/Shared/Domain/Services/RepositoryServices/LayoutService.php`
      - crear envs `.env`, `.env.local` y `APP_KEY` generada
      - publicar configuración `config/hexagonal.php` generada
    - eliminados:
      - eliminar los archivos `.lock` del `.gitignore`
      - eliminar carpeta `app/Http`
      - eliminar carpeta `app/Models`
      - eliminar archivo `CHANGELOG.md`
    - modificados: 
      - añadir `DependencyServiceProvider` en `/bootstrap/providers.php`
      - añadir `ExceptionHandler` en `/bootstrap/app.php`
      - añadir dependencias de NPM en el `package.json`
      - añadir script `ts-build` en el `package.json`
      - instalar `tightenco/ziggy`
      - añadir namespace `Src` en el `composer.json`
      - añadir rutas iniciales en `routes/web.php`
      - añadir configuración inicial en `tailwind.config.js`
      - comentar User factory en `database/seeders/DatabaseSeeder`
      - importar `flowbite` in `resources/js/bootstrap.js`
      - añadir comentario `HexagonalService::ignoreMigrations()` en el `app/Providers/AppServiceProvider.php`
    - otros:
      - añadir comandos `composer dump-autoload`, `npm install` y `npm run build`

  </details>

### Changed

* docs: `development-tips.md` -> añadir comandos para eliminar un tag
* Nuevo método estático `fromId()` en el trait `WithIdsAndToArray` para poder instanciar un `BackedEnum` a partir del `Id`
* Rutas: Añadir la ruta `hexagonal.root` en el componente `navbar.brand`
* Rutas: Añadir las rutas `hexagonal.queues.queuedJobs` y `hexagonal.queues.queuedJobs` en la configuración del `sidebar`
* Rutas: Cambiar `route('default')` de la vista `jobs.blade.php` por `route('hexagonal.root')` para no depender de que la aplicación tenga creada la ruta `default`
* Rutas: Crear nueva ruta `/root` que hace una redirección hacia `/`
* Rutas: Clase `TestController` renombrada a `HexagonalController`
* Añadir middleware `web` en las rutas del paquete

### Fixed

* (fix) añadir el icono al breadcrumb del example2.blade.php (que se perdió en algún momento)
* (fix) Sol. error al obtener los `$links` para comprobar `$this->sidebarCollapsed` -> cambiar `hexagonal.sidebar_links` por `hexagonal.sidebar.items`
* (fix) Prevenir errores cuando en la configuración no hay `navbar.items`, `sidebar.items` o `sidebar.footer`

### Removed

* renderer: eliminar ruta y vista `testVitePackage`, ya que ahora se hace de otra forma y ya está funcionando en el Layout

## [v1.10.0-beta.0](https://github.com/kalel1500/laravel-hexagonal-and-ddd-architecture-utilities/compare/v1.9.0-beta.1...v1.10.0-beta.0) - 2024-11-06

### Changed

* Añadir parámetro $formats en el constructor de la clase `DateVo`
* Adaptar el método `checkFormat()` de la clase `MyCarbon` para validar zeros y Crear nuevo método `checkFormats()` para validar un array de formatos
* !!! Añadir propiedad `$allowZeros` para poder pasarle fechas con zeros.
* !!! (breaking) Modificar propiedad `$formats` de `ContractDateVo` de `String` a `Array` para que acepte varios formatos
* (breaking) Eliminar formateo de fecha en el constructor de la clase `ContractDateVo` para mantener la integridad de los datos
* Añadir nuevo formato `$datetime_startYear_withoutSeconds` en la clase `MyCarbon`
* Poner un valor por defecto a la propiedad `$format`
* !!! (breaking) Modificar segundo parámetro constructor de `ContractDateVo` para recibir el formato

## [v1.9.0-beta.1](https://github.com/kalel1500/laravel-hexagonal-and-ddd-architecture-utilities/compare/v1.9.0-beta.0...v1.9.0-beta.1) - 2024-11-06

### Changed

* Renombrar migraciones y validar que no existan antes de crearlas para evitar conflictos con las migraciones del proyecto
* Mover la directiva @routes encima de los scripts
* !!!Renderer: Insertar CSS y JS compilado en el `layout` en lugar de usar directive `@vitePackage` para no tener que generar una ruta laravel que sirva los archivos

### Fixed

* (fix) Prevenir error al llamar al `favicon.ico` con `Vite::asset` en el `layout` usando la nueva directiva `@viteAsset` que contiene un tryCatch
* (fix) Prevenir error al llamar al JS con `@vite()` en el `layout` comprobando que exista un archivo `.ts` en el proyecto (usar extension `.js` si no existe)

## [v1.9.0-beta.0](https://github.com/kalel1500/laravel-hexagonal-and-ddd-architecture-utilities/compare/v1.8.0-beta.3...v1.9.0-beta.0) - 2024-11-05

### Changed

* <u>**!!! (breaking) !!!**</u> Permitir que los ValueObjects que no son NULL, estén vacíos (`empty()`) para mantener la integridad de los datos
* <u>**!!! (breaking) !!!**</u> Dejar de limpiar el value en la clase `ContractStringVo` para mantener la integridad de los datos
* comentarios añadidos en el método `checkAllowNull()` de la clase `ContractValueObject`
* (phpdoc) añadir tipos dinámicos en PhpDoc con `@template` en las clases de las colecciones
* (refactor) eliminar condición innecesaria en `ContractCollectionEntity::fromData()`
* (refactor) ordenar código validaciones del método `ContractCollectionEntity::fromData()`

### Removed

* eliminar código comentado
* eliminar código duplicado en la clase `ContractModelId`

### Fixed

* (fix) prevenir errores al añadir validaciones en los métodos `fromData()` de las colecciones para validar que las constantes siempre tengan un valor definido
* (fix) Prevenir error cuando se crea un StringVo con el valor `''` (añadida propiedad `protected $allowNull = false` en los ValueObjects que no deban permitir null)

## [v1.8.0-beta.3](https://github.com/kalel1500/laravel-hexagonal-and-ddd-architecture-utilities/compare/v1.8.0-beta.2...v1.8.0-beta.3) - 2024-11-05

### Added

* Nuevas clases `UnsignedInt` (tanto primitivas como de Entidad) para tener un ValueObject que solo acepte números positivos

### Changed

* Actualizar dependencia de npm `laravel-ts-utilities` a la versión `1.3.0-beta.1` + actualizar identación archivos
* Permitir que la clase `ContractIntVo` tenga números negativos (quitar de la validación el `$value < 0`)

### Fixed

* (fix) incluir la validación `checkAllowNull()` en el método `ensureIsValidValue` de la clase `ContractModelId`
* (fix) adaptar método `ensureIsValidValue()` de `ContractModelId` a la clase padre haciendolo `protected` y renombrando la variable `$id` por `$value`

## [v1.8.0-beta.2](https://github.com/kalel1500/laravel-hexagonal-and-ddd-architecture-utilities/compare/v1.8.0-beta.1...v1.8.0-beta.2) - 2024-11-04

### Added

* Nuevos Value Objects `ModelIdZero` y `ModelIdZeroNull` para poder crear ids permitiendo que el valor sea igual a `0`

### Changed

* Actualizar PhpDoc del método `ContractModelId::from()` con un `@return T` (de la template definida en la clase -> `@template T of ContractModelId`)
* Adaptar código de `PHP 8` a `PHP 7.2.5` (cambiar `match` en los componentes y arrow function en trait `WithIdsAndToArray`)
* !!!Rollback versiones mínimas de `PHP` y `Laravel`. Volver a añadir las versiones (`^7.2.5|^8.0|^8.1`) de php y las versiones (`^7.0|^8.0`) de laravel
* Añadir variable `protected $minimumValueForModelId` en la clase `ContractModelId` para poder sobreescribirla desde fuera creando otras clases que extiendan de ella. Por defecto se mantiene el valor de la configuración `config('hexagonal.minimum_value_for_model_id')`
* Usar las variables estáticas para obtener la clase al hacer el new `ModelId...()` en el método `ContractModelId::from()` para poder crear otras clases que extiendan de `ContractModelId`
* Añadir configuración `hexagonal.minimum_value_for_model_id` para establecer el valor mínimo permitido en el value object `ModelId`
* config: Comentario Layout terminado en `config/hexagonal.php`
* docs: Añadido código interesante para formatear los logs como JSON

### Fixed

* (fix) corregir gramática comentario
* (fix) corregir error al pasar el antiguo parámetro HTTP_CODE en el constructor de la clase `UnsetRelationException`

## [v1.8.0-beta.1](https://github.com/kalel1500/laravel-hexagonal-and-ddd-architecture-utilities/compare/v1.7.0-beta.1...v1.8.0-beta.1) - 2024-10-31

### Added

* Nuevo Enum `EnumWIthIdsContract` y Nuevo Trait `WithIdsAndToArray` para los ValueObject de tipo Enum
* public: new build
* Nueva vista con código js para comparar dos bloques HTML
* Nuevas vistas (blades) con ejemplos de Tailwind
* Crear y compilar todo el JS y CSS necesario para las vistas internas del paquete (con nueva directiva `@vitePackage()`)
* Instalar paquete `laravel-ts-utilities` para poder compilar js y css propios del paquete
* Docs: Nuevos archivos con código interesante
* Nueva interfaz `LayoutServiceContract` (para que al crear el servicio en la aplicación, tenga todos los métodos)
* Nuevos componentes para crear una Layout inicial en tailwind:
  * Componente Layout
  * Componente Navbar
  * Componente Sidebar
  * Componente Footer
  * Enlaces Navbar y Sidebar definidos en la configuración `config/hexagonal.php`
* Nuevos componentes blade reutilizables en Tailwind

### Changed

* Establecer la variable de entorno `HEXAGONAL_BROADCASTING_ENABLED` por defecto a `false`
* <u>**!!! (breaking) !!! Subir versiones mínimas de `PHP` y `Laravel` a `^8.2` y `^11.0` respectivamente**</u>
* (refactor) Se utiliza el método `toArrayDynamic()` en los métodos `toArrayDb()` y `toArrayWith()` de la clase `ContractCollectionEntity`
* Se ha añadido el método `toArrayDynamic()` en la clase `ContractCollectionBase` para facilitar la creación de otros métodos `toArray...()` en otras entidades y colecciones
* Se han añadido las propiedades `$primaryKey` e `$incrementing` en la clase `ContractEntity` para controlar el `id` en el método `toArrayDb`
* (breaking) Hacer que `HexagonalException` extienda de `DomainException` en vez de `RuntimeException`
* (refactor) Renombrar `DomainException` a `HexagonalException`
* Añadir método `toArrayVo()` en la clase `ContractDataObject`
  <hr/>
* (refactor) Ordenar Rutas en el `routes/web.php`
* (refactor) importar los controllers en las Rutas en el `routes/web.php`
* (refactor) Mover vistas a la carpeta `pages` (para separarlas de los componentes)
* Cambiar los imports por rutas absolutas en el `web.php`
* Separar los Controllers en las carpetas `Ajax` y `Web`
* Hacer que la clase `AbortException` extienda de la interfaz `HttpExceptionInterface` para que Laravel la trate como una excepción Http
* (breaking) Renombrar el helper `abortC` a `abort_d` ya que es el abort del dominio
* (breaking) Renombrar la clase `GeneralException` a `AbortException` ya que se entiende mejor su propósito
* Añadir la constante `MESSAGE` en la clase `BasicException` para poder definir un mensaje por defecto en cada excepción que herede de esta clase

### Fixed

* (fix) Quitar prefijo `hexagonal` de la ruta de test ya que el paquete ya lo añade automáticamente
* (fix) Prevenir error del helper `getUrlFromRoute()` cuando la ruta no existe
* (fix) Añadir modo estricto en la interfaz `Relatable`

## [v1.7.0-beta.1](https://github.com/kalel1500/laravel-hexagonal-and-ddd-architecture-utilities/compare/v1.6.0-beta.1...v1.7.0-beta.1) - 2024-10-25

### Added

* Nueva ruta `LayoutController@public` para servir los assets del paquete (y asi poder compilarlo internamente)
* Nueva ruta (y vista) `test` para probar como compila el @vite desde el paquete
* Nuevo método `each` en la Colección Base
* nuevos helpers: `getUrlFromRoute()`, `strToSlug()`
* nuevos helpers: `isRouteActive()`, `dropdownIsOpen()`, `currentRouteNamed()`

### Changed

* (breaking) modificar comportamiento del método `Collection::fromArray()` para que si recibe null devuelva null, en lugar de una colección vacía (en todas las colecciones)
* varios helpers marcados como deprecados + PhpDoc helper actualizado
* componentes: nueva variable (config) para el componente <x-layouts.app>
* componentes: nueva traducción para el componente <x-messages>

### Removed

* eliminar helpers antiguos

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
* composer.json: Añadir `minimum-stability` y `prefer-stable`

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

* Quitar el prefijo de las rutas `hexagonal` en la configuración

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