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

$router->get('/', 'Auth');

$router->group('/auth', function() use ($router){
    $router->match('/register', 'Auth::register', ['POST', 'GET']);
    $router->match('/login', 'Auth::login', ['POST', 'GET']);
    $router->get('/logout', 'Auth::logout');
    $router->match('/password-reset', 'Auth::password_reset', ['POST', 'GET']);
    $router->match('/set-new-password', 'Auth::set_new_password', ['POST', 'GET']);
});

$router->group('/organizer', function() use ($router){
    $router->match('/dashboard', 'Organizer::dashboard', ['POST', 'GET']);
    $router->match('/dashboard', 'User::Access_organizer_panel', ['POST', 'GET']);
    $router->match('/create', 'Organizer::create', ['POST', 'GET']);
    $router->match('/update/{event_id}', 'Organizer::update', ['POST', 'GET']);
    $router->match('/delete/{event_id}', 'Organizer::delete', ['POST', 'GET']);
    $router->get('/details/{event_id}', 'Organizer::view_details', ['POST', 'GET']);
    $router->match('/manage_booking', 'Organizer::manageBooking', ['POST', 'GET']);
    $router->post('/reject_booking/{booking_id}', 'Organizer::reject_booking');
    $router->post('/approve_booking/{booking_id}', 'Organizer::approve_booking');
  
});

$router->group('/user', function() use ($router) {
    $router->get('/home', 'User::home');
    $router->get('/about', 'User::about');
    $router->get('/contact', 'User::contact');
    $router->match('/create_booking/{event_id}', 'User::create_booking', ['POST', 'GET']);
    $router->match('/apply_as_organizer', 'User::Apply', ['POST', 'GET']);
    $router->get('/mybook', 'User::myBook');
    $router->post('/cancel_booking/{booking_id}', 'User::Cancel_booking');
    $router->post('/view_email/{booking_id}', 'User::Get_email_notifications');
  
});

$router->group('/admin', function() use ($router){
    $router->get('/dashboard', 'Admin::dashboard');
    $router->post('/approve/{event_id}', 'Admin::approve');
    $router->post('/reject/{event_id}', 'Admin::reject');
    $router->post('/delete/{event_id}', 'Admin::delete');
    $router->match('/manage_application', 'Admin::manageApplications', ['POST', 'GET']);
    $router->post('/reject_application/{apply_id}', 'Admin::Reject_application');
    $router->post('/approve_application/{apply_id}', 'Admin::Approve_application');
});