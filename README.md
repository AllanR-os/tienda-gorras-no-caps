# 🛒 Desert Caps - Tienda de Gorras

## 📖 Proyecto Académico - Pruebas de Software

Tienda web de gorras desarrollada en **PHP puro** con **MySQL**, lista para realizar pruebas con **Apache JMeter**.

---

## 🎯 ¿Qué necesitas para trabajar en este proyecto?

Este proyecto usa **Docker** para que todos tengamos el mismo entorno de desarrollo sin necesidad de XAMPP.

### ✅ **Requisitos:**
- Windows 10/11 (64-bit)
- 8 GB de RAM mínimo (recomendado: 16 GB)
- 10 GB de espacio libre en disco
- Conexión a internet (solo para la instalación inicial)

---

# 🚀 GUÍA DE INSTALACIÓN COMPLETA

## 📦 PASO 1: Instalar Docker Desktop

### 1.1 Descargar Docker:
1. Ve a: https://www.docker.com/products/docker-desktop/
2. Haz clic en **"Download for Windows"**
3. Descarga el instalador (aproximadamente 500 MB)

### 1.2 Instalar Docker:
```
1. Ejecuta el instalador "Docker Desktop Installer.exe"
2. Acepta los términos de servicio
3. Deja las opciones por defecto (marca "Use WSL 2")
4. Clic en "Install"
5. Espera 5-10 minutos
6. Cuando termine: REINICIA TU PC ⚠️
```

### 1.3 Configurar WSL2 (si te lo pide):

**Si aparece un mensaje sobre WSL2:**

1. Abre **PowerShell como Administrador**:
   - Busca "PowerShell" en el menú inicio
   - Clic derecho → "Ejecutar como administrador"

2. Ejecuta:
   ```bash
   wsl --install
   ```

3. Espera a que termine (5-10 minutos)

4. **REINICIA TU PC** cuando te lo pida

5. Después del reinicio, te pedirá crear un usuario de Linux:
   ```
   Username: tu_nombre (sin espacios)
   Password: tu_contraseña (no se verá al escribir)
   Retype password: la misma contraseña
   ```

### 1.4 Verificar Docker:

1. Abre **PowerShell** (NO como administrador esta vez)

2. Ejecuta:
   ```bash
   docker --version
   ```

3. Deberías ver algo como:
   ```
   Docker version 29.2.1, build a5c7197
   ```

4. Verifica Docker Compose:
   ```bash
   docker compose version
   ```

5. Deberías ver:
   ```
   Docker Compose version v5.0.2
   ```

✅ **Si ves las versiones, Docker está listo!**

---

## 📥 PASO 2: Instalar Git

### 2.1 Descargar Git:
1. Ve a: https://git-scm.com/download/win
2. La descarga comenzará automáticamente
3. Descarga el instalador (aproximadamente 50 MB)

### 2.2 Instalar Git:
```
1. Ejecuta el instalador
2. En TODAS las pantallas, deja las opciones por defecto
3. Solo da clic en "Next" hasta llegar a "Install"
4. Clic en "Install"
5. Espera 2-3 minutos
6. Clic en "Finish"
```

### 2.3 Configurar Git:

1. Abre **PowerShell**

2. Configura tu nombre:
   ```bash
   git config --global user.name "Tu Nombre"
   ```

3. Configura tu email (usa el de tu cuenta de GitHub):
   ```bash
   git config --global user.email "tuemail@ejemplo.com"
   ```

4. Verifica:
   ```bash
   git --version
   ```

✅ **Si ves la versión de Git, está listo!**

---

## 📂 PASO 3: Clonar el Proyecto

### 3.1 Obtener el código:

1. Abre **PowerShell**

2. Ve a la carpeta donde quieras guardar el proyecto (ejemplo: Documentos):
   ```bash
   cd C:\Users\TU_USUARIO\Documents
   ```

3. Clona el repositorio:
   ```bash
   git clone https://github.com/USUARIO-DEL-REPO/tienda-gorras-desert-caps.git
   ```
   ⚠️ **Reemplaza la URL con la que te comparta tu compañero**

4. Entra a la carpeta del proyecto:
   ```bash
   cd tienda-gorras-desert-caps
   ```

5. Verifica que tienes todos los archivos:
   ```bash
   dir
   ```

   Deberías ver archivos como:
   - `docker-compose.yml`
   - `Dockerfile`
   - `login_db.sql`
   - `index.php`
   - Y muchos más archivos PHP

✅ **Si ves estos archivos, el proyecto se clonó correctamente!**

---

## 🐳 PASO 4: Levantar el Proyecto con Docker

### 4.1 Asegúrate de estar en la carpeta correcta:

```bash
# Verifica que estás en la carpeta del proyecto
pwd

# Deberías ver algo como:
# C:\Users\TU_USUARIO\Documents\tienda-gorras-desert-caps
```

### 4.2 Iniciar Docker Desktop:

1. Busca "Docker Desktop" en el menú inicio
2. Ábrelo
3. Espera a que se inicie completamente
4. Verás un ícono de ballena en la barra de tareas
5. Cuando la ballena deje de moverse, Docker está listo

### 4.3 Levantar los contenedores:

1. En PowerShell (dentro de la carpeta del proyecto):
   ```bash
   docker compose up -d
   ```

2. Verás algo como esto:
   ```
   [+] Running 4/4
   ✔ Network tienda_pw_tienda_network    Created
   ✔ Container tienda_pw_db              Started
   ✔ Container tienda_pw_phpmyadmin      Started
   ✔ Container tienda_pw_web             Started
   ```

3. **Espera 1-2 minutos** para que todo se inicialice

### 4.4 Verificar que está corriendo:

```bash
docker compose ps
```

Deberías ver algo como:
```
NAME                    STATUS    PORTS
tienda_pw_web           Up        0.0.0.0:80->80/tcp
tienda_pw_db            Up        0.0.0.0:3306->3306/tcp
tienda_pw_phpmyadmin    Up        0.0.0.0:8080->80/tcp
```

✅ **Si los 3 contenedores están "Up", todo funciona!**

---

## 🌐 PASO 5: Acceder a la Aplicación

### Abre tu navegador y ve a estas URLs:

| Servicio | URL | Descripción |
|----------|-----|-------------|
| **🛒 Tienda Web** | http://localhost | La aplicación principal |
| **🗄️ phpMyAdmin** | http://localhost:8080 | Para ver la base de datos |

### Credenciales de phpMyAdmin:
- **Usuario:** `root`
- **Contraseña:** `rootpassword`

### Credenciales de la Tienda:

**Administrador:**
- **Usuario:** `admin`
- **Contraseña:** `admin123`
- Acceso al panel de administración

**Cliente:**
- Puedes registrar un nuevo usuario desde la página de registro

---

## 🧪 PASO 6: Realizar Pruebas con JMeter

### 6.1 Instalar JMeter (si no lo tienes):

1. Descarga JMeter: https://jmeter.apache.org/download_jmeter.cgi
2. Descarga el archivo `.zip` o `.tgz`
3. Extrae en una carpeta (ejemplo: `C:\jmeter`)
4. Ejecuta: `C:\jmeter\bin\jmeter.bat`

### 6.2 Configurar JMeter para probar la tienda:

**URL del servidor para JMeter:**
```
http://localhost
```

**Endpoints principales para probar:**

| Endpoint | Método | Descripción |
|----------|--------|-------------|
| `/login.php` | POST | Inicio de sesión |
| `/signup.php` | POST | Registro de usuarios |
| `/pagina_principal.php` | GET | Página principal con productos |
| `/cart.php` | GET/POST | Carrito de compras |
| `/admin_panel.php` | GET | Dashboard de admin |
| `/admin_products.php` | POST | CRUD de productos |

**Ejemplos de pruebas:**
- ✅ Pruebas de carga en login (100 usuarios concurrentes)
- ✅ Pruebas de estrés en carrito (500 peticiones)
- ✅ Pruebas de concurrencia en admin
- ✅ Pruebas de tiempo de respuesta en catálogo

---

## 🔧 Comandos Útiles de Docker

### Ver estado de los contenedores:
```bash
docker compose ps
```

### Ver logs en tiempo real:
```bash
docker compose logs -f

# Solo de un servicio específico:
docker compose logs -f web
```

### Detener los contenedores:
```bash
docker compose down
```

### Reiniciar los contenedores:
```bash
docker compose restart
```

### Eliminar TODO (contenedores + base de datos):
```bash
docker compose down -v
```
⚠️ **CUIDADO:** Esto borrará la base de datos. Se volverá a crear desde `login_db.sql`

### Reconstruir las imágenes:
```bash
docker compose up -d --build
```

---

## 🔄 Actualizar el Proyecto (Obtener Cambios)

Si uno de tus compañeros hace cambios y los sube a GitHub:

```bash
# 1. Detén Docker
docker compose down

# 2. Obtén los últimos cambios
git pull

# 3. Vuelve a levantar Docker
docker compose up -d
```

---

## 📊 Estructura del Proyecto

```
tienda-gorras-desert-caps/
│
├── 📄 index.php                    # Página de inicio
├── 📄 login.php                    # Inicio de sesión
├── 📄 signup.php                   # Registro de usuarios
├── 📄 pagina_principal.php         # Tienda principal
├── 📄 cart.php                     # Carrito de compras
├── 📄 golf.php                     # Catálogo de productos
├── 📄 logout.php                   # Cerrar sesión
│
├── 📄 connection.php               # Conexión a BD
├── 📄 functions.php                # Funciones generales
│
├── 👨‍💼 admin_panel.php             # Dashboard admin
├── 👨‍💼 admin_products.php          # CRUD productos
├── 👨‍💼 admin_users.php             # Gestión usuarios
├── 👨‍💼 admin_functions.php         # Funciones admin
├── 👨‍💼 admin_styles.css            # Estilos admin
│
├── 🎨 *.css                        # Archivos de estilos
├── 📜 *.js                         # Archivos JavaScript
│
├── 🗄️ login_db.sql                 # Base de datos inicial
├── 🐳 Dockerfile                   # Configuración PHP
├── 🐳 docker-compose.yml           # Orquestación servicios
├── 📝 .gitignore                   # Archivos ignorados
└── 📖 README.md                    # Este archivo
```

---

## 🗄️ Base de Datos

### Tablas:

**`users`** - Usuarios del sistema
- `id` - ID único
- `user_name` - Nombre de usuario
- `email` - Correo electrónico
- `password` - Contraseña encriptada
- `role` - Rol (admin/cliente)
- `date` - Fecha de registro

**`products`** - Productos (gorras)
- `id` - ID único
- `name` - Nombre de la gorra
- `price` - Precio (decimal)
- `image` - URL de la imagen
- `category` - Categoría

**`cart`** - Carritos de compra
- `id` - ID único
- `user_id` - ID del usuario
- `product_id` - ID del producto
- `quantity` - Cantidad
- `added_at` - Fecha de agregado

---

## ❗ Solución de Problemas Comunes

### Problema 1: "Puerto 80 ya está en uso"

**Causa:** XAMPP u otro servidor web está corriendo

**Solución:**
```bash
# Opción A: Detén XAMPP
# Opción B: Cambia el puerto en docker-compose.yml

# En docker-compose.yml, cambia:
ports:
  - "8000:80"  # En lugar de "80:80"

# Luego accede a: http://localhost:8000
```

### Problema 2: "Puerto 3306 ya está en uso"

**Causa:** MySQL de XAMPP está corriendo

**Solución:**
```bash
# Detén MySQL de XAMPP antes de usar Docker
```

### Problema 3: "docker: command not found"

**Causa:** Docker no está instalado correctamente

**Solución:**
```bash
# 1. Verifica que Docker Desktop esté abierto
# 2. Reinicia tu PC
# 3. Vuelve a abrir PowerShell
```

### Problema 4: Los cambios en el código no se reflejan

**Solución:**
```bash
# Reinicia el contenedor web:
docker compose restart web

# O reconstruye todo:
docker compose up -d --build
```

### Problema 5: "No puedo acceder a http://localhost"

**Causa:** Los contenedores no terminaron de iniciar

**Solución:**
```bash
# 1. Verifica el estado:
docker compose ps

# 2. Ve los logs para ver errores:
docker compose logs

# 3. Espera 2-3 minutos después de ejecutar "docker compose up"
```

### Problema 6: Error al hacer git pull

**Solución:**
```bash
# Si tienes cambios locales que causan conflicto:
git stash
git pull
git stash pop
```

---

## 💡 Consejos para el Trabajo en Equipo

### ✅ ANTES de empezar a trabajar:
```bash
git pull                    # Obtener últimos cambios
docker compose up -d       # Levantar Docker
```

### ✅ DESPUÉS de hacer cambios (si eres tú quien los sube):
```bash
git add .
git commit -m "Descripción de los cambios"
git push
```

### ✅ Al terminar de trabajar:
```bash
docker compose down        # Apagar Docker
```

---

## 📞 Contacto y Soporte

Si tienes problemas:

1. ✅ Revisa la sección de **Solución de Problemas**
2. ✅ Verifica los logs: `docker compose logs`
3. ✅ Pregunta en el grupo del equipo
4. ✅ Consulta la documentación oficial de Docker

---

## 📚 Recursos Adicionales

- **Documentación de Docker:** https://docs.docker.com/
- **Guía de Git:** https://git-scm.com/doc
- **JMeter Documentation:** https://jmeter.apache.org/usermanual/index.html

---

## ✅ Checklist de Instalación

Marca cuando completes cada paso:

- [ ] Docker Desktop instalado
- [ ] WSL2 configurado (si fue necesario)
- [ ] Git instalado y configurado
- [ ] Proyecto clonado desde GitHub
- [ ] `docker compose up -d` ejecutado correctamente
- [ ] Acceso a http://localhost ✅
- [ ] Acceso a http://localhost:8080 ✅
- [ ] Login con usuario admin funciona
- [ ] JMeter instalado (opcional)

---

## 🎓 Información del Proyecto

**Materia:** Pruebas de Software  
**Tecnologías:** PHP, MySQL, Docker, Apache  
**Objetivo:** Realizar pruebas de carga, estrés y rendimiento con JMeter

---

## 📝 Notas Importantes

⚠️ **Este proyecto NO usa frameworks** - Es PHP puro  
⚠️ **Docker debe estar corriendo** antes de acceder a la aplicación  
⚠️ **Los cambios en el código se reflejan automáticamente** (no necesitas reconstruir)  
⚠️ **La base de datos se inicializa automáticamente** desde `login_db.sql`

---

**¡Listo para trabajar! Si seguiste todos los pasos, tu entorno está configurado correctamente.** 🎉

---

## 🆘 ¿Algo no funciona?

Si después de seguir todos los pasos algo no funciona:

1. Asegúrate de que Docker Desktop esté corriendo
2. Verifica que estás en la carpeta correcta del proyecto
3. Revisa los logs: `docker compose logs -f`
4. Intenta reconstruir: `docker compose up -d --build`
5. Como último recurso, elimina todo y vuelve a empezar:
   ```bash
   docker compose down -v
   docker compose up -d
   ```

---

**Última actualización:** Febrero 2026  
**Versión:** 1.0

Ahora tienes un panel de administrador completamente funcional para tu tienda Desert Caps.
