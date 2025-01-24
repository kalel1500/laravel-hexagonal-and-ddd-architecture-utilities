
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
