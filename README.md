# Catalogo Web Demo

Demo generica de catalogo digital para comercios construida con Laravel, Blade, Tailwind CSS y MySQL.

Incluye:

- landing publica profesional y personalizable
- catalogo publico con buscador, filtros y destacados
- pagina de contacto y ubicacion
- panel admin simple para productos, categorias y configuracion del comercio
- autenticacion completa con login, registro, recuperacion de contrasena y perfil
- seeders listos para mostrar la demo apenas se levanta

## Requisitos

- PHP 8.2+
- Composer
- Node.js / npm
- MySQL

## Instalacion

1. Instalar dependencias:

```bash
composer install
npm install
```

2. Configurar entorno:

```bash
cp .env.example .env
php artisan key:generate
```

3. Ajustar credenciales MySQL en `.env`.

4. Crear estructura y datos demo:

```bash
php artisan migrate:fresh --seed
php artisan storage:link
```

5. Compilar assets:

```bash
npm run build
```

6. Levantar en desarrollo:

```bash
composer run dev
```

## Accesos principales

- sitio publico: `/`
- catalogo: `/catalogo`
- contacto: `/contacto`
- login admin: `/login`
- panel admin: `/admin`

## Credenciales demo

- email: `admin@demo.local`
- contrasena: `password`

## Estructura funcional

### Modelos

- `Product`
- `Category`
- `BusinessProfile`

### Tablas

- `products`
- `categories`
- `business_profiles`

### Panel admin

- gestion de productos
- gestion de categorias
- configuracion del comercio demo
- perfil de usuario

## Personalizacion rapida

La demo esta pensada para adaptarse rapido a distintos clientes. Desde el panel podras cambiar:

- nombre del comercio
- descripcion breve
- texto de bienvenida
- direccion
- WhatsApp / telefono
- email
- horarios
- logo
- imagen principal
- colores base
- categorias
- productos

## Storage local vs produccion

El proyecto quedo preparado para usar un disco dedicado para las imagenes del catalogo:

- local: `CATALOG_MEDIA_DISK=public`
- produccion / Laravel Cloud: `CATALOG_MEDIA_DISK=s3`

### Local

Usa el disco `public`, por eso necesitas:

```bash
php artisan storage:link
```

### Laravel Cloud / produccion

Configura Object Storage y define estas variables:

```bash
CATALOG_MEDIA_DISK=s3
AWS_ACCESS_KEY_ID=...
AWS_SECRET_ACCESS_KEY=...
AWS_DEFAULT_REGION=...
AWS_BUCKET=...
AWS_URL=
AWS_ENDPOINT=
AWS_USE_PATH_STYLE_ENDPOINT=false
```

Notas:

- `AWS_URL` sirve si tu proveedor expone una URL publica custom o CDN.
- `AWS_ENDPOINT` se usa si no es AWS puro, por ejemplo Cloudflare R2, MinIO u otro S3-compatible.
- En Laravel Cloud no conviene guardar imagenes del catalogo en disco local persistente.

## Testing

La suite usa MySQL de testing.

```bash
php artisan test
```

## Build validado

Durante la implementacion se validaron estos comandos:

```bash
php artisan migrate:fresh --seed
php artisan storage:link
npm run build
php artisan test
```
