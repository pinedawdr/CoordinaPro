# Instrucciones de Despliegue en cPanel

## Requisitos Previos
- Acceso a cPanel
- Base de datos MySQL creada en cPanel
- PHP 8.1 o superior
- Composer instalado en el servidor

## Pasos para el Despliegue

1. **Preparar el Proyecto**
   ```bash
   composer install --optimize-autoloader --no-dev
   npm install
   npm run build
   ```

2. **Configurar el Archivo .env**
   - Copiar .env.example a .env
   - Actualizar las siguientes variables:
     ```
     APP_ENV=production
     APP_DEBUG=false
     APP_URL=https://tudominio.com
     
     DB_CONNECTION=mysql
     DB_HOST=localhost
     DB_PORT=3306
     DB_DATABASE=tu_base_de_datos
     DB_USERNAME=tu_usuario
     DB_PASSWORD=tu_contraseña
     ```

3. **Subir Archivos a cPanel**
   - Usar el Administrador de Archivos de cPanel o FTP
   - Subir todos los archivos excepto:
     - /vendor
     - /node_modules
     - .git
     - .env

4. **Configurar la Base de Datos**
   - Crear la base de datos en cPanel
   - Ejecutar las migraciones:
     ```bash
     php artisan migrate
     ```

5. **Configurar Permisos**
   ```bash
   chmod -R 755 storage bootstrap/cache
   ```

6. **Configurar el Dominio**
   - En cPanel, ir a "Domains" o "Dominios"
   - Apuntar el dominio al directorio public/
   - Asegurarse de que el DocumentRoot apunte a la carpeta public/

7. **Optimizar Laravel**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

## Solución de Problemas Comunes

1. **Error 500**
   - Revisar los logs en storage/logs
   - Verificar permisos de archivos
   - Asegurar que todas las extensiones de PHP necesarias estén instaladas

2. **Problemas de Base de Datos**
   - Verificar credenciales en .env
   - Asegurar que la base de datos existe
   - Verificar que el usuario tiene los permisos necesarios

3. **Problemas de Assets**
   - Ejecutar `npm run build` nuevamente
   - Verificar que la carpeta public/build existe
   - Limpiar la caché del navegador 