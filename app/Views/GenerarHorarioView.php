<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar Horario - UCM</title>
    <style>
        :root {
            --primary-color: #003366;
            --secondary-color: #007bff;
            --hover-color: #002244;
            --background-color: #f6f8fc;
            --sidebar-bg: #fff;
            --main-bg: #f9fbff;
            --active-bg: #e0eaff;
        }
        
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            background-color: var(--background-color);
            color: #333;
        }
        
        .container {
            display: flex;
            min-height: 100vh;
        }
        
        .sidebar {
            width: 250px;
            background-color: var(--sidebar-bg);
            padding: 25px;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.08);
            position: relative;
            z-index: 10;
        }
        
        .logo {
            width: 100%;
            max-width: 200px;
            height: auto;
            margin-bottom: 40px;
            display: block;
        }
        
        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .sidebar li {
            margin-bottom: 12px;
        }
        
        .sidebar a {
            text-decoration: none;
            color: #444;
            font-weight: 500;
            display: block;
            padding: 10px 15px;
            border-radius: 6px;
            transition: all 0.2s ease;
            font-size: 15px;
        }
        
        .sidebar a:hover {
            color: var(--primary-color);
            background-color: rgba(0, 51, 102, 0.1);
        }
        
        .sidebar a.active {
            color: var(--primary-color);
            background-color: var(--active-bg);
            font-weight: 600;
        }
        
        .main {
            flex: 1;
            padding: 40px;
            background-color: var(--main-bg);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        
        .action-buttons {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }
        
        .btn {
            padding: 12px 25px;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            transition: background-color 0.3s;
            text-align: center;
            min-width: 180px;
        }
        
        .btn-generate {
            background-color: var(--primary-color);
        }
        
        .btn-generate:hover {
            background-color: var(--hover-color);
        }
        
        .btn-pdf {
            background-color: var(--secondary-color);
        }
        
        .btn-pdf:hover {
            background-color: #0069d9;
        }
        
        h1 {
            color: var(--primary-color);
            margin-bottom: 20px;
            text-align: center;
        }
        
        p.description {
            color: #555;
            max-width: 500px;
            text-align: center;
            line-height: 1.6;
            margin-bottom: 30px;
        }
        
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }
            
            .sidebar {
                width: 100%;
                padding: 15px;
            }
            
            .logo {
                max-width: 150px;
                margin-bottom: 20px;
            }
            
            .main {
                padding: 25px;
            }
            
            .action-buttons {
                flex-direction: column;
                width: 100%;
            }
            
            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <img src="/guitarraguagua-project/Framework/public/Imagenes/Escudo_UCM.png" alt="Universidad Católica del Maule" class="logo">
            <ul>
                <li><a href="/guitarraguagua-project/Framework/public/index.php">Inicio</a></li>
                <li><a href="/guitarraguagua-project/Framework/public/index.php/profesores">Docentes</a></li>
                <li><a href="/guitarraguagua-project/Framework/public/index.php/generar-horario" class="active">Generar Horario</a></li>
            </ul>
        </div>
        
        <div class="main">
            <h1>Generador de Horarios Académicos</h1>
            <p class="description">
                Genera automáticamente horarios optimizados para las asignaturas seleccionadas.
                Puedes descargar el resultado en formato PDF para compartirlo o imprimirlo.
            </p>
            
            <form action="/guitarraguagua-project/Framework/public/index.php/generar-horario/generarHorario" method="POST">
                <div class="action-buttons">
                    <a href="/guitarraguagua-project/Framework/public/index.php/generar-horario/generarPDF" class="btn btn-pdf">Descargar PDF</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>