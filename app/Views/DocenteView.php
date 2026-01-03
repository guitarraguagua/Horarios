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
        h1 {
            color: var(--primary-color);
            margin-bottom: 20px;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }
        thead tr {
            background: #f0f4ff;
            color: #003366;
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
        }
    </style>
</head>
<body>
    <div class="container">
    <div class="sidebar">
        <img src="/guitarraguagua-project/Framework/public/Imagenes/Escudo_UCM.png" alt="Universidad Católica del Maule" class="logo">
        <ul>
            <li><a href="/guitarraguagua-project/Framework/public/index.php">Inicio</a></li>
            <li><a href="#" class="active">Docentes</a></li>
            <li><a href="/guitarraguagua-project/Framework/public/index.php/generar-horario">Generar Horario</a></li>
        </ul>
    </div>
    <div class="main">
        <h1>Listado de Docentes</h1>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Correo</th>
                </tr>
            </thead>
            <tbody>
                <tr><td>Mary Carmen Zurur Muñoz</td><td>mzurur@ucm.cl</td></tr>
                <tr><td>Hugo Araya Carrasco</td><td>haraya@ucm.cl</td></tr>
                <tr><td>César Castro Bustamante</td><td>ccastro@ucm.cl</td></tr>
                <tr><td>Valeria Soto Fernández</td><td>vsoto@ucm.cl</td></tr>
                <tr><td>Felipe Tapia Gutierrez</td><td>ftapia@ucm.cl</td></tr>
                <tr><td>Sergio Hernandez</td><td>sergio.hernandez@vuw.ac.nz</td></tr>
                <tr><td>Luis Lam Redd</td><td>llamredd@ucm.cl</td></tr>
                <tr><td>Ximena López</td><td>xlopez@ucm.cl</td></tr>
                <tr><td>Ivon Rodríguez</td><td>ivon.rodriguez@urjc.es</td></tr>
                <tr><td>Macarena Contreras</td><td>maca.mce@ucm.cl</td></tr>
                <tr><td>Rodrigo Santisteban</td><td>rsantisteban@ucm.cl</td></tr>
                <tr><td>Paula Tirado</td><td>ptirado@ucm.cl</td></tr>
                <tr><td>Marcela Toscano</td><td>mtoscano@ucm.cl</td></tr>
                <tr><td>Héctor Valdés</td><td>hvaldes@ucm.cl</td></tr>
                <tr><td>Andrea Valdés</td><td>a.valdes@ucm.cl</td></tr>
                <tr><td>Francisco Valencia</td><td>fvalencia@ucm.cl</td></tr>
                <tr><td>Gabriela Andrade</td><td>gabriela.andrade@ucm.cl</td></tr>
                <tr><td>Fernando Vásquez</td><td>fvasquez@ucm.cl</td></tr>
                <tr><td>Roberto Hernández</td><td>rhernandez@ucm.cl</td></tr>
                <tr><td>Alejandra Quijon</td><td>aquijon@ucm.cl</td></tr>
                <tr><td>Ricardo Rubio</td><td>ricardo.rubio@ucm.cl</td></tr>
            </tbody>
        </table>
    </div>
</div>
