# 🛒 Desert Caps - Tienda de Gorras

Proyecto académico de Pruebas de Software desarrollado en PHP puro con MySQL.

## 📋 Descripción

Tienda web de gorras con sistema de autenticación, carrito de compras y panel de administración completo.

### Características principales:
- 🔐 Sistema de autenticación con roles (admin/cliente)
- 🛍️ Carrito de compras funcional
- 👨‍💼 Panel de administración con CRUD de productos
- 👥 Gestión de usuarios
- 🎨 Diseño responsive

---

## 🚀 Instalación con Docker

### Prerrequisitos

- [Docker Desktop](https://www.docker.com/products/docker-desktop/) instalado
- [Git](https://git-scm.com/downloads) instalado

### Paso 1: Clonar el repositorio

```bash
git clone <URL-DEL-REPOSITORIO>
cd tienda_pw
```

### Paso 2: Levantar los contenedores

```bash
docker compose up -d
```

Este comando:
- ✅ Construye la imagen de PHP con Apache
- ✅ Levanta MySQL con la base de datos
- ✅ Inicializa la base de datos automáticamente
- ✅ Levanta phpMyAdmin para administrar la BD

### Paso 3: Acceder a la aplicación

Una vez que los contenedores estén corriendo:

- **Tienda web**: http://localhost
- **phpMyAdmin**: http://localhost:8080
  - Usuario: `root`
  - Contraseña: `rootpassword`

---

## 👤 Usuarios de Prueba

### Usuario Administrador:
- **Usuario**: `admin`
- **Contraseña**: `admin123`
- **Acceso**: Panel de administración completo

### Usuario Cliente:
Puedes registrar nuevos usuarios desde la página de registro.

---

## 🛠️ Comandos Útiles de Docker

### Ver contenedores corriendo:
```bash
docker compose ps
```

### Ver logs en tiempo real:
```bash
docker compose logs -f
```

### Detener los contenedores:
```bash
docker compose down
```

### Reiniciar los contenedores:
```bash
docker compose restart
```

### Eliminar TODO (contenedores + volúmenes):
```bash
docker compose down -v
```
⚠️ **Cuidado**: Esto borrará la base de datos. Se volverá a crear desde `login_db.sql`

### Reconstruir las imágenes:
```bash
docker compose up -d --build
```

---

## 📁 Estructura del Proyecto

```
tienda_pw/
├── 📄 index.php                    # Página de inicio
├── 📄 login.php                    # Inicio de sesión
├── 📄 signup.php                   # Registro de usuarios
├── 📄 pagina_principal.php         # Página principal de la tienda
├── 📄 cart.php                     # Carrito de compras
├── 📄 golf.php                     # Página de productos
├── 📄 logout.php                   # Cerrar sesión
│
├── 📄 connection.php               # Conexión a base de datos
├── 📄 functions.php                # Funciones generales
│
├── 👨‍💼 admin_panel.php             # Dashboard del admin
├── 👨‍💼 admin_products.php          # CRUD de productos
├── 👨‍💼 admin_users.php             # Gestión de usuarios
├── 👨‍💼 admin_functions.php         # Funciones del admin
├── 👨‍💼 admin_styles.css            # Estilos del panel admin
│
├── 🎨 pag_principal_estilos.css    # Estilos principales
├── 🎨 login_singup.css             # Estilos de login/registro
├── 🎨 gorras_stylos.css            # Estilos adicionales
├── 📜 script.js                    # JavaScript
│
├── 🗄️ login_db.sql                 # Base de datos inicial
├── 🐳 Dockerfile                   # Configuración de la imagen PHP
├── 🐳 docker-compose.yml           # Orquestación de servicios
├── 📝 .gitignore                   # Archivos a ignorar en Git
├── 📝 .env.example                 # Ejemplo de variables de entorno
└── 📖 README.md                    # Este archivo
```

---

## 🗄️ Base de Datos

### Tablas:

#### `users`
- `id` - ID del usuario
- `user_name` - Nombre de usuario
- `email` - Email
- `password` - Contraseña hasheada
- `role` - Rol (admin/cliente)
- `date` - Fecha de registro

#### `products`
- `id` - ID del producto
- `name` - Nombre de la gorra
- `price` - Precio
- `image` - URL de la imagen
- `category` - Categoría

#### `cart`
- `id` - ID del registro
- `user_id` - ID del usuario
- `product_id` - ID del producto
- `quantity` - Cantidad
- `added_at` - Fecha de agregado

---

## 🧪 Pruebas con JMeter

Este proyecto está diseñado para realizar pruebas de software con Apache JMeter.

### Configuración recomendada:

1. **URL base para JMeter**: `http://localhost`
2. **Endpoints a probar**:
   - `/login.php` - POST (autenticación)
   - `/signup.php` - POST (registro)
   - `/pagina_principal.php` - GET (carga de productos)
   - `/cart.php` - GET/POST (carrito)
   - `/admin_products.php` - GET/POST (CRUD admin)

### Ejemplos de pruebas:
- ✅ Pruebas de carga en login
- ✅ Pruebas de estrés en carrito
- ✅ Pruebas de concurrencia en admin
- ✅ Pruebas de rendimiento en catálogo

---

## 🔧 Solución de Problemas

### El puerto 80 está ocupado:
```bash
# Edita docker-compose.yml y cambia:
ports:
  - "8000:80"  # En lugar de "80:80"

# Luego accede a: http://localhost:8000
```

### El puerto 3306 está ocupado (XAMPP corriendo):
```bash
# Detén XAMPP antes de usar Docker
# O cambia el puerto en docker-compose.yml:
ports:
  - "3307:3306"
```

### La base de datos no se inicializa:
```bash
# Borra los volúmenes y vuelve a crear:
docker compose down -v
docker compose up -d
```

### Cambios en el código no se reflejan:
```bash
# El volumen está mapeado, los cambios deberían verse automáticamente
# Si no, reinicia el contenedor:
docker compose restart web
```

---

## 👥 Equipo de Desarrollo

Proyecto desarrollado para la materia de **Pruebas de Software**.

---

## 📝 Notas

- Este proyecto **NO usa frameworks** (PHP puro)
- La base de datos se inicializa automáticamente desde `login_db.sql`
- Los cambios en el código se reflejan inmediatamente (volumen mapeado)
- phpMyAdmin está incluido para facilitar la administración de la BD

---

## 📄 Licencia

Proyecto académico - Desert Caps © 2025

---

## 🆘 ¿Necesitas Ayuda?

Si tienes problemas con Docker:

1. Verifica que Docker Desktop esté corriendo
2. Asegúrate de estar en la carpeta del proyecto
3. Revisa los logs: `docker compose logs`
4. Pregunta al equipo o consulta la documentación de Docker

---

**¡Listo para hacer pruebas! 🚀**
