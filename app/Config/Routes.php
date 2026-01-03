<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('generar-horario', 'GenerarHorarioCon::index');
$routes->post('generar-horario', 'GenerarHorarioCon::index');
$routes->get('generar-horario/generarPDF', 'GenerarHorarioCon::generarPDF');
$routes->get('profesores', 'ProfesorCon::index');



