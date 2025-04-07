# Instrucciones de Despliegue para CoordinaPro

## Información del Servidor
- **Dominio**: gestionus.redsaludchumbivilcas.gob.pe
- **Ruta Base**: /home/redsalu2/coordinapro.redsaludchumbivilcas.gob.pe
- **Base de Datos**: redsalu2_coordinapro
- **Usuario DB**: redsalu2_admin_gestionus

## Pasos para el Despliegue

1. **Preparar el Proyecto Localmente**
   ```bash
   composer install --optimize-autoloader --no-dev
   npm install
   npm run build
   ```

2. **Subir Archivos**
   - Usar FTP o el Administrador de Archivos de cPanel
   - Subir a la ruta: /home/redsalu2/coordinapro.redsaludchumbivilcas.gob.pe
   - Excluir las carpetas:
     - /vendor
     - /node_modules
     - .git
     - .env

3. **Configurar Permisos**
   ```bash
   chmod -R 755 /home/redsalu2/coordinapro.redsaludchumbivilcas.gob.pe
   chmod -R 777 /home/redsalu2/coordinapro.redsaludchumbivilcas.gob.pe/storage
   chmod -R 777 /home/redsalu2/coordinapro.redsaludchumbivilcas.gob.pe/bootstrap/cache
   ```

4. **Configurar Base de Datos**
   - La base de datos ya está creada: redsalu2_coordinapro
   - Ejecutar migraciones:
     ```bash
     php artisan migrate
     ```

5. **Optimizar Laravel**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

6. **Configurar Dominio en cPanel**
   - Asegurarse que el DocumentRoot apunte a la carpeta public/
   - Verificar que el dominio gestionus.redsaludchumbivilcas.gob.pe esté configurado correctamente

## Verificación Post-Despliegue

1. **Verificar Acceso**
   - https://gestionus.redsaludchumbivilcas.gob.pe
   - Comprobar que redirige a HTTPS
   - Verificar que la página carga correctamente

2. **Verificar Base de Datos**
   - Comprobar conexión a la base de datos
   - Verificar que las tablas se crearon correctamente

3. **Verificar Archivos**
   - Comprobar que los archivos subidos tienen los permisos correctos
   - Verificar que la carpeta storage es escribible

## Solución de Problemas

1. **Error 500**
   - Revisar logs en storage/logs
   - Verificar permisos de archivos
   - Comprobar configuración de PHP en cPanel

2. **Problemas de Base de Datos**
   - Verificar credenciales en .env
   - Comprobar que la base de datos existe
   - Verificar permisos del usuario de la base de datos

3. **Problemas de Assets**
   - Ejecutar `npm run build` nuevamente
   - Verificar que la carpeta public/build existe
   - Limpiar caché del navegador 