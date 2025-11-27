<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
/**
 * ------------------------------------------------------------------
 * LavaLust - an opensource lightweight PHP MVC Framework
 * ------------------------------------------------------------------
 *
 * MIT License
 *
 * Copyright (c) 2020 Ronald M. Marasigan
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package LavaLust
 * @author Ronald M. Marasigan <ronald.marasigan@yahoo.com>
 * @since Version 1
 * @link https://github.com/ronmarasigan/LavaLust
 * @license https://opensource.org/licenses/MIT MIT License
 */

/*
| -------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------
| Here is where you can register web routes for your application.
|
|
*/

$router->get('/', 'AuthController::loginForm');

// 🩺 Appointment CRUD routes
$router->get('/appointments', 'AppointmentController::index');          // Show all appointments
$router->get('/appointments/add', 'AppointmentController::add');        // Show add form
$router->post('/appointments/add', 'AppointmentController::add');       // Submit add form
$router->get('/appointments/edit/{id}', 'AppointmentController::edit'); // Show edit form
$router->post('/appointments/edit/{id}', 'AppointmentController::edit');// Submit edit form
$router->get('/appointments/delete/{id}', 'AppointmentController::delete'); // Delete record
$router->get('/appointments/getBookedSlots', 'AppointmentController::getBookedSlots'); // AJAX endpoint
$router->get('/login', 'AuthController::loginForm');
$router->post('/login/submit', 'AuthController::loginSubmit');
$router->get('/auth/logout', 'AuthController::logout');
$router->post('/client/signup', 'ClientController::signup');
$router->post('/client/login', 'ClientController::login');

// Services CRUD
$router->get('/services', 'ServicesController::index');
$router->get('/services/add', 'ServicesController::add');
$router->post('/services/add', 'ServicesController::add');
$router->get('/services/edit/{id}', 'ServicesController::edit');
$router->post('/services/edit/{id}', 'ServicesController::edit');
$router->get('/services/delete/{id}', 'ServicesController::delete');

// Veterinarians CRUD
$router->get('/veterinarians', 'VeterinariansController::index');
$router->get('/veterinarians/add', 'VeterinariansController::add');
$router->post('/veterinarians/add', 'VeterinariansController::add');
$router->get('/veterinarians/edit/{id}', 'VeterinariansController::edit');
$router->post('/veterinarians/edit/{id}', 'VeterinariansController::edit');
$router->get('/veterinarians/delete/{id}', 'VeterinariansController::delete');
$router->get('/veterinarians/toggleStatus/{id}', 'VeterinariansController::toggleStatus');

// Reports routes
$router->get('/reports', 'ReportController::index');
$router->post('/reports/appointments', 'ReportController::appointments');
$router->post('/reports/services', 'ReportController::services');
$router->post('/reports/veterinarians', 'ReportController::veterinarians');
$router->post('/reports/clients', 'ReportController::clients');
$router->get('/reports/export', 'ReportController::export');

$router->get('/dashboard', 'DashboardController::index');

