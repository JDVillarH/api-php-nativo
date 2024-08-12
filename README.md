# PokeAPI (REST) - PHP Nativo

Este es un proyecto de API REST inspirado en la conocida [PokeAPI](https://pokeapi.co/).
Puedes utilizar este proyecto para APIs de uso personal dado que el proyecto es fácilmente reutilizable.

## Características

- **Enrutamiento simple e intuitivo:** Configuración y manejo de rutas de manera clara, facilitando la escalabilidad del código.

- **Paginación y límites personalizables:** Configura el número de registros por página y el total de registros a mostrar para optimizar el rendimiento y la usabilidad.

- **Control de acceso por dominio:** Permite la definición de una lista de dominios permitidos, asegurando que solo los orígenes autorizados puedan interactuar con la API.

- **Registro de Errores:** Implementa un sistema de logging para capturar y almacenar errores, facilitando la depuración y el monitoreo del estado de la API.

## Requisitos

- Apache
- PHP 7.4 o superior
- Composer para dependencias
- MySQL

## Instalación y configuración

1. **Clona el repositorio:**

   ```bash
   git clone https://github.com/JDVillarH/api-php-nativo.git
   ```

2. **Instala las dependencias:**

   ```bash
   composer install
   ```

3. **Configura el proyecto:**

> [!TIP]  
> Si deseas modificar las rutas puedes encontrar más información sobre las rutas en [Bramus Router](https://github.com/bramus/router)

- En `public/index.php` se encuentran las rutas y controladores ya definidos para el manejo de las solicitudes.

- El archivo `pokemon.sql.gz` contiene la estructura e información de la base de datos de MySQL, importalo en tu base de datos para que el API funcione correctamente.

- En el archivo `.env` encontrarás las variables `DB` en las que podrás ingresar las credenciales para tu base de datos y con `APP_LOCAL` para definir si tu API se encuentra en local o producción.

- En el archivo `app/config/constants.php` encontrarás la variable `ALLOWED_DOMAINS` en la cual podrás agregar los dominios a los cuales quieres darle permisos de interactuar con tu API o si no quieres limitar el acceso a dominios, puedes dejar la variable con el valor "\*".

## Uso

#### Listado de recursos

```http
  GET /api/v1/
```

```json
{
  "pokemon": "https://ejemplo/api/v1/pokemon",
  "types": "https://ejemplo/api/v1/types",
  "moves": "https://ejemplo/api/v1/moves",
  "abilities": "https://ejemplo/api/v1/abilities"
}
```

#### Listado de pokemon

```http
  GET /api/v1/pokemon?page={página}&limit={limite}
```

```json
{
    "name": "bulbasaur",
    "url": "https://ejemplo/api/v1/pokemon/1"
},
...
```

#### Obtener pokemon especifico

```http
  GET /api/v1/pokemon/${id}
```

```json
{
    "name": "bulbasaur",
    "image": "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/dream-world/1.svg",
    "stats": [...],
    "types": [...],
    "moves": [...],
    "abilities": [...]
}
```

#### Listado de tipos de pokemon

```http
  GET /api/v1/types
```

```json
{
    "name": "normal"
},
...
```

#### Listado de movimientos de pokemon

```http
  GET /api/v1/moves
```

```json
{
    "name": "pound"
},
...
```

#### Listado de habilidades de pokemon

```http
  GET /api/v1/abilities
```

```json
{
    "name": "stench"
},
...
```

## Contribución

Si deseas contribuir al proyecto, puedes hacer un fork del repositorio y posteriormente un pull request con tu característica o corrección.
