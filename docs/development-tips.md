
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

## Gestión de ramas de GIT

### Inicio cuando solo hay una rama "master"

```
git checkout -b develop master // crear rama develop de master
git push -u origin develop // subir la nueva rama develop
```

### Mergear a master un desarrollo de develop:

### Inicio desarrollo

* git checkout develop
* git pull origin develop (git pull)
* // varios commits...
* git push origin develop (git push)

### Fin desarrollo

* git checkout master
* git pull origin master (git pull)
* git merge --no-ff develop (dejar mensaje "Merge brange 'develop'")
* git tag v1.0.1
* git push origin master --tags
* git push origin master
