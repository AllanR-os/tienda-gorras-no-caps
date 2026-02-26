# 📤 GUÍA: Subir Proyecto a GitHub

## Paso 1: Preparar archivos en tu proyecto

1. **Copia estos archivos a tu carpeta** `C:\xampp\htdocs\tienda_pw\`:
   - `Dockerfile`
   - `docker-compose.yml`
   - `connection.php` (reemplaza el actual)
   - `.gitignore`
   - `.env.example`
   - `README_DOCKER.md` (renómbralo a `README.md` o úsalo como complemento)

2. **Verifica que tengas** `login_db.sql` en la carpeta

---

## Paso 2: Crear repositorio en GitHub

1. Ve a: https://github.com
2. Inicia sesión
3. Haz clic en el botón verde **"New"** o **"+"** → **"New repository"**
4. Llena los datos:
   ```
   Repository name: tienda-gorras-desert-caps
   Description: Proyecto académico - Tienda web de gorras con PHP y MySQL
   Visibility: Public (o Private si prefieres)
   ❌ NO marques "Add a README file"
   ❌ NO agregues .gitignore (ya lo tienes)
   ❌ NO agregues licencia
   ```
5. Clic en **"Create repository"**

6. **Copia la URL que aparece**, se verá así:
   ```
   https://github.com/tu-usuario/tienda-gorras-desert-caps.git
   ```

---

## Paso 3: Subir tu proyecto a GitHub

### Abre PowerShell en tu carpeta del proyecto:

```bash
cd C:\xampp\htdocs\tienda_pw
```

### Ejecuta estos comandos uno por uno:

```bash
# 1. Inicializar Git en tu proyecto
git init

# 2. Agregar todos los archivos
git add .

# 3. Hacer el primer commit
git commit -m "Initial commit: Proyecto Desert Caps con Docker"

# 4. Renombrar la rama a 'main'
git branch -M main

# 5. Conectar con GitHub (reemplaza con TU URL)
git remote add origin https://github.com/TU-USUARIO/tienda-gorras-desert-caps.git

# 6. Subir todo a GitHub
git push -u origin main
```

### Si te pide usuario y contraseña:
- **Usuario**: Tu nombre de usuario de GitHub
- **Contraseña**: 
  - ⚠️ Ya NO funciona la contraseña normal
  - Necesitas crear un **Personal Access Token**
  - Ve a: https://github.com/settings/tokens
  - Genera un token y úsalo como contraseña

---

## Paso 4: Verificar que se subió correctamente

1. Ve a tu repositorio en GitHub: `https://github.com/TU-USUARIO/tienda-gorras-desert-caps`
2. Deberías ver todos tus archivos
3. Verifica que estén:
   - ✅ Dockerfile
   - ✅ docker-compose.yml
   - ✅ login_db.sql
   - ✅ Todos tus archivos PHP
   - ✅ README.md

---

## Paso 5: Compartir con tus compañeros

Envíales la URL del repositorio:
```
https://github.com/TU-USUARIO/tienda-gorras-desert-caps
```

---

## 🎯 Tus compañeros harán esto:

```bash
# 1. Clonar el repositorio
git clone https://github.com/TU-USUARIO/tienda-gorras-desert-caps.git

# 2. Entrar a la carpeta
cd tienda-gorras-desert-caps

# 3. Levantar Docker
docker compose up -d

# 4. Abrir en el navegador
http://localhost
```

---

## 🔄 Para actualizar el proyecto después:

Si haces cambios y quieres subirlos:

```bash
# 1. Ver qué cambió
git status

# 2. Agregar cambios
git add .

# 3. Hacer commit
git commit -m "Descripción de los cambios"

# 4. Subir a GitHub
git push
```

---

## 👥 Para que tus compañeros obtengan los cambios:

```bash
# En la carpeta del proyecto:
git pull
docker compose restart
```

---

## ⚠️ IMPORTANTE:

**Antes de subir a GitHub:**
- ✅ Asegúrate de que `.gitignore` esté en la carpeta
- ✅ NO subas contraseñas reales (usa las de ejemplo)
- ✅ Verifica que `login_db.sql` esté incluido

**Después de clonar:**
- ✅ Cada compañero debe tener Docker Desktop instalado
- ✅ Ejecutar `docker compose up -d`
- ✅ Esperar a que todo inicie (1-2 minutos)

---

¡Listo! Tu proyecto estará en GitHub y disponible para todo el equipo. 🎉
