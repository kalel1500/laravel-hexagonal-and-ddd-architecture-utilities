
# Tips para el desarrollo del paquete

## Publicar un tag específico:

```git
git push origin <nombre_del_tag>
```

## Eliminar un tag:

```git
git tag -d <nombre_del_tag>
git push origin --delete <nombre_del_tag>
```

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
HEXAGONAL_PACKAGE_IN_DEVELOP=true
HEXAGONAL_KEEP_MIGRATIONS_DATE=true
```
