
# Comandos de Git

## Publicar un tag específico:

```git
git push origin <nombre_del_tag>
```

## Eliminar un tag:

```git
git tag -d <nombre_del_tag>
git push origin --delete <nombre_del_tag>
```

## Configurar variables de entorno durante el desarrollo

Durante el desarrollo, en la aplicación se pueden configurar las siguientes variables para que el comando ""

```dotenv
KALION_PACKAGE_IN_DEVELOP=true
KALION_KEEP_MIGRATIONS_DATE=true
```

## Gestión de ramas de GIT

### Inicio cuando solo hay una rama "master"

```
git checkout -b develop master // crear rama develop de master
git push -u origin develop // subir la nueva rama develop
```