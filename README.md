# Sistema de Generación de Horarios - UCM

Sistema web desarrollado con **CodeIgniter 4** para la generación automática de horarios académicos en la Universidad Católica del Maule (UCM).

## 📋 Descripción

Este proyecto es una solución integral para gestionar y generar horarios de clases, considerando:

- **Salas disponibles** con capacidad y ubicación
- **Profesores y sus disponibilidades**
- **Ramos (Cursos)** con requisitos de sala y duración
- **Semestres académicos**
- **Conflictos de asignación** (evitar sobreposiciones)

El sistema genera reportes en PDF optimizados para impresión y consulta.

## 🎯 Características

- ✅ Gestión de docentes y su disponibilidad horaria
- ✅ Administración de salas y capacidades
- ✅ Asignación automática de horarios
- ✅ Generación de reportes en PDF
- ✅ Interfaz web amigable
- ✅ Base de datos relacional MySQL

## 🛠️ Tecnologías

- **Backend**: CodeIgniter 4 (PHP 8.1+)
- **Base de Datos**: MySQL 8.0+
- **Frontend**: HTML5, CSS3, JavaScript
- **Reportes**: FPDF
- **Servidor**: Apache con mod_rewrite

## 📦 Instalación

### Requisitos

- PHP 8.1 o superior
- MySQL 8.0 o superior
- Composer
- Extensiones PHP: intl, mbstring

### Pasos

1. **Clonar el repositorio**
```bash
git clone https://github.com/guitarraguagua/Horarios.git
cd Horarios
```

2. **Instalar dependencias**
```bash
composer install
```

3. **Configurar base de datos**
   - Crear base de datos MySQL llamada `Horarios`
   - Importar `app/Database/BaseCompleta.sql`
   - Actualizar credenciales en `app/Config/Database.php`

4. **Configurar archivo `.env`**
```
CI_ENVIRONMENT = development
app.baseURL = 'http://localhost/horarios/'
database.default.hostname = localhost
database.default.database = Horarios
database.default.username = root
database.default.password = 
```

5. **Ejecutar servidor**
```bash
php spark serve
```

Acceder a: `http://localhost:8080`

## 📁 Estructura del Proyecto

```
├── app/
│   ├── Config/          # Configuración de la app
│   ├── Controllers/     # Controladores (GenerarHorarioCon, ProfesorCon, etc.)
│   ├── Models/          # Modelos (MGenerarHorario, MProfesor, MRamo, etc.)
│   ├── Views/           # Vistas (DocenteView, GenerarHorarioView)
│   ├── Database/        # Scripts SQL y migraciones
│   └── ThirdParty/      # FPDF para reportes
├── public/              # Punto de entrada (index.php)
├── system/              # Core de CodeIgniter (no modificar)
└── writable/            # Logs, cache, uploads
```

## 🚀 Uso Principal

### 1. Gestión de Docentes
- Registrar profesores
- Definir disponibilidad horaria
- Asignar ramos

### 2. Generación de Horarios
- Ejecutar algoritmo de generación
- Revisar conflictos
- Generar reporte PDF

### 3. Reportes
- Horarios por docente
- Horarios por sala
- Horarios por semestre

## 🔧 Controladores Principales

- `GenerarHorarioCon` - Generación de horarios
- `ProfesorCon` - Gestión de docentes
- `HomeCon` - Página principal
- `TestConexion` - Prueba de conexión BD

## 📊 Modelos

- `MGenerarHorario` - Lógica de generación
- `MProfesor` - Gestión de docentes
- `MHorarios` - Consultas de horarios
- `MRamo` - Gestión de cursos

## 🗄️ Base de Datos

Principales tablas:
- `Salas` - Aulas disponibles
- `DISPONIBILIDAD_SALAS` - Horarios disponibles por sala
- `Docentes` - Información de profesores
- `Ramos` - Cursos a programar
- `Horarios` - Asignaciones generadas

## 📝 Licencia

Este proyecto está bajo licencia MIT. Ver `LICENSE` para más detalles.

## 👨‍💻 Autor

Martín Ferrada

Javier Catalán