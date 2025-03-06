
# Tips para el desarrollo del paquete

## Excluir carpetas al comparar dos proyectos

```regexp
!vendor/*&!node_modules/*&!.idea/*
```

## Instalar la versión "dev-master" del paquete con un enlace durante el desarrollo

```json
{
  "require": {
    "kalel1500/laravel-hexagonal-and-ddd-architecture-utilities": "dev-master"
  },
  "minimum-stability": "dev",
  "repositories": [
    {
      "type": "path",
      "url": "../laravel-hexagonal-and-ddd-architecture-utilities"
    }
  ]
}
```

## Configurar variables de entorno durante el desarrollo

Durante el desarrollo, en la aplicación se pueden configurar las siguientes variables para que el comando ""

```dotenv
KALION_PACKAGE_IN_DEVELOP=true
KALION_KEEP_MIGRATIONS_DATE=true
```