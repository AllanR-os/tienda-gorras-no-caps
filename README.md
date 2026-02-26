# Panel de Administrador - Desert Caps

## 🎯 Descripción
Panel de administrador completo para la tienda Desert Caps con gestión de productos, usuarios y estadísticas en tiempo real.

## ✨ Características

### Dashboard
- Estadísticas en tiempo real (productos, usuarios, items en carritos)
- Gráficos de productos por categoría
- Accesos rápidos a funciones principales
- Animaciones y diseño moderno

### Gestión de Productos
- ✅ Crear nuevos productos
- ✅ Editar productos existentes
- ✅ Eliminar productos
- ✅ Vista previa de imágenes
- ✅ Organización por categorías

### Gestión de Usuarios
- ✅ Ver todos los usuarios registrados
- ✅ Cambiar roles (Cliente/Admin)
- ✅ Eliminar usuarios
- ✅ Estadísticas de usuarios

## 📋 Instalación

### Paso 1: Actualizar la Base de Datos

Abre phpMyAdmin y ejecuta el siguiente SQL en tu base de datos `login_db`:

```sql
-- Agregar campo de rol a la tabla users
ALTER TABLE users ADD COLUMN role ENUM('cliente', 'admin') DEFAULT 'cliente' AFTER password;

-- Crear un usuario administrador (puedes cambiar estos datos)
-- Contraseña: admin123
INSERT INTO users (user_name, email, password, role) 
VALUES ('admin', 'admin@desertcaps.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

-- O si ya tienes un usuario y quieres hacerlo admin:
UPDATE users SET role = 'admin' WHERE user_name = 'tu_usuario';
```

### Paso 2: Subir los Archivos

Sube los siguientes archivos a tu carpeta `tienda_pw` en xampp/htdocs:

```
tienda_pw/
├── admin_functions.php      (Funciones administrativas)
├── admin_panel.php          (Dashboard principal)
├── admin_products.php       (Gestión de productos)
├── admin_users.php          (Gestión de usuarios)
├── admin_styles.css         (Estilos del panel)
└── login.php               (Archivo actualizado con redirección)
```

### Paso 3: Reemplazar login.php

⚠️ **IMPORTANTE**: Reemplaza tu archivo `login.php` actual con el nuevo que incluye la redirección automática para administradores.

## 🚀 Uso

### Acceder como Administrador

1. Ve a `http://localhost/tienda_pw/login.php`
2. Ingresa las credenciales de administrador:
   - Usuario: `admin`
   - Contraseña: `admin123`
3. Serás redirigido automáticamente al panel de administrador

### Acceder como Cliente

Los usuarios normales seguirán siendo redirigidos a la tienda principal (`pagina_principal.php`)

## 📱 Características del Panel

### Dashboard (admin_panel.php)
- Vista general de estadísticas
- Tarjetas con información clave
- Productos por categoría
- Accesos rápidos

### Gestión de Productos (admin_products.php)
- Tabla con todos los productos
- Formulario para crear/editar productos
- Campos: Nombre, Precio, Imagen (URL), Categoría
- Categorías disponibles:
  - Cowboy Golf
  - Colaboraciones
  - Edición Especial
  - Destacados

### Gestión de Usuarios (admin_users.php)
- Lista completa de usuarios
- Cambiar roles directamente desde la tabla
- Eliminar usuarios (excepto tu propia cuenta)
- Información de registro de cada usuario

## 🔒 Seguridad

- ✅ Validación de permisos de administrador en cada página
- ✅ Consultas preparadas (prepared statements)
- ✅ Sanitización de inputs
- ✅ Protección contra SQL injection
- ✅ No puedes eliminar tu propia cuenta de admin

## 🎨 Diseño

- Diseño responsive (se adapta a móviles y tablets)
- Sidebar con navegación intuitiva
- Colores corporativos de Desert Caps
- Animaciones suaves
- Iconos de Font Awesome

## 🔧 Personalización

### Cambiar Colores

Edita las variables CSS en `admin_styles.css`:

```css
:root {
    --primary-color: #8b6d51;      /* Color principal */
    --secondary-color: #4a3c31;    /* Color secundario */
    --success-color: #43e97b;      /* Color de éxito */
    --danger-color: #f5576c;       /* Color de peligro */
}
```

### Agregar Más Categorías

En `admin_products.php`, busca el select de categorías y agrega más opciones:

```html
<option value="Nueva Categoría">Nueva Categoría</option>
```

## ⚠️ Notas Importantes

1. **Backup**: Haz una copia de seguridad de tu base de datos antes de ejecutar los SQL
2. **Contraseñas**: Cambia la contraseña del admin por seguridad
3. **Permisos**: Solo usuarios con rol 'admin' pueden acceder al panel
4. **Imágenes**: Las imágenes deben ser URLs públicas (no funcionan rutas locales)

## 🐛 Solución de Problemas

### "Connection failed"
- Verifica que XAMPP esté corriendo
- Confirma los datos de conexión en `connection.php`

### "Access Denied" al entrar al panel
- Asegúrate de que el usuario tenga rol 'admin' en la base de datos
- Verifica que el campo 'role' se haya agregado correctamente

### Los productos no se muestran
- Verifica que tengas productos en la tabla `products`
- Confirma que los campos coincidan con la estructura

### No puedo subir imágenes
- El sistema usa URLs de imágenes, no archivos locales
- Usa servicios como Imgur o coloca las imágenes en una carpeta pública

## 📞 Soporte

Si tienes problemas:
1. Verifica que todos los archivos estén en la ubicación correcta
2. Revisa la consola de PHP para errores
3. Confirma que la base de datos tenga la estructura correcta

## 📝 Licencia

© 2025 Desert Caps - Todos los derechos reservados

---

**¡Listo para usar!** 🎉

Ahora tienes un panel de administrador completamente funcional para tu tienda Desert Caps.
