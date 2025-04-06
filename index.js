import express from 'express';
import { fileURLToPath } from 'url';
import { dirname, join } from 'path';

// Obtener la ruta del directorio actual
const __filename = fileURLToPath(import.meta.url);
const __dirname = dirname(__filename);

const app = express();
const port = process.env.PORT || 3000;

// Middleware para procesar JSON
app.use(express.json());
app.use(express.urlencoded({ extended: true }));

// Servir archivos estáticos desde la carpeta public
app.use(express.static(join(__dirname, 'public')));

// Rutas API
app.get('/api/status', (req, res) => {
  res.json({ status: 'online', version: '1.0.0' });
});

// Rutas de ejemplo
app.get('/api/proyectos', (req, res) => {
  res.json([
    { id: 1, nombre: 'Desarrollo Web', estado: 'En progreso' },
    { id: 2, nombre: 'Aplicación Móvil', estado: 'Planificación' },
    { id: 3, nombre: 'Migración de Base de Datos', estado: 'Completado' }
  ]);
});

// Cualquier otra ruta carga la aplicación de frontend
app.get('*', (req, res) => {
  res.sendFile(join(__dirname, 'public', 'index.html'));
});

// Iniciar servidor
app.listen(port, () => {
  console.log(`Servidor ejecutándose en http://localhost:${port}`);
});
