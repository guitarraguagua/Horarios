<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Asignaturas - UCM</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background-color: #f6f8fc;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      background-image: url('/guitarraguagua-project/Framework/public/Imagenes/Edificios-CES-UCM-2.png'); /* Cambia el nombre por el de tu imagen */
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
    }
    .square-container {
      width: 800px;
      height: 800px;
      background-color: white;
      border-radius: 15px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      display: flex;
    }
    .sidebar {
      width: 220px;
      background-color: #fff;
      padding: 20px;
      border-right: 1px solid #eee;
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    .logo {
      width: 100%;
      max-width: 180px;
      height: auto;
      margin-bottom: 30px;
      display: block;
    }
    .sidebar ul {
      list-style: none;
      padding: 0;
      width: 100%;
    }
    .sidebar li {
      margin-bottom: 15px;
    }
    .sidebar a {
      text-decoration: none;
      color: #222;
      font-weight: 500;
      display: block;
      padding: 8px 12px;
      border-radius: 6px;
      transition: background 0.2s, color 0.2s;
    }
    .sidebar a.active,
    .sidebar a:hover {
      color: #003366;
      background-color: #e0eaff;
    }
    .main {
      flex: 1;
      padding: 40px;
      background-color: #f9fbff;
      overflow-y: auto;
    }
    h1 {
      margin-bottom: 25px;
      color: #003366;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      background-color: #fff;
      border-radius: 8px;
      overflow: hidden;
      margin-bottom: 20px;
    }
    th, td {
      padding: 14px;
      border-bottom: 1px solid #eee;
      text-align: left;
    }
    th {
      background-color: #f0f4ff;
      color: #003366;
    }
    tr:last-child td {
      border-bottom: none;
    }
    .btn {
      margin-top: 20px;
      padding: 12px 20px;
      background-color: #003366;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 16px;
      text-decoration: none;
      display: inline-block;
    }
    .btn:hover {
      background-color: #002244;
    }
  </style>
</head>
<body>
  <div class="square-container">
    <div class="sidebar">
      <img src="/guitarraguagua-project/Framework/public/Imagenes/Escudo_UCM.png" alt="UCM" class="logo">
      <ul>
        <li><a href="#" class="active">Inicio</a></li>
        <li><a href="/guitarraguagua-project/Framework/public/index.php/profesores">Docentes</a></li>
        <li><a href="/guitarraguagua-project/Framework/public/index.php/generar-horario">Generar Horario</a></li>
      </ul>
    </div>
    <div class="main">
      <h1>Bienvenido a la gestión de Asignaturas UCM</h1>
      <p>Selecciona una opción del menú para comenzar.</p>
    </div>
  </div>
</body>
</html>