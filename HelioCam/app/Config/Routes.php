<?php

use CodeIgniter\Router\RouteCollection;

$routes->get('/', 'Users::index');
$routes->get('login', 'Users::index'); 
$routes->get('register', 'Users::register');
$routes->get('home', 'Users::home');
$routes->get('profile', 'Users::profile');
$routes->get('history', 'Users::history');
$routes->get('addsession', 'Users::addsession');
$routes->get('hostsession', 'Users::hostsession');
$routes->get('surveillance', 'Users::surveillance');
$routes->get('notification', 'Users::notification');
$routes->get('settings', 'Users::settings');
$routes->get('about_us', 'Users::about_us');
$routes->get('contact_us', 'Users::contact_us');
$routes->get('verify', 'Users::verify');
$routes->get('policy', 'Users::policy');
$routes->get('terms', 'Users::terms');
$routes->get('streaming', 'Users::streaming');
$routes->get('eprofile', 'Users::eprofile');
$routes->get('forgot_pass', 'Users::forgot_pass');
