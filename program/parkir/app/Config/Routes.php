<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Auth Routes
$routes->get('/auth/register', 'Auth::register');
$routes->post('/auth/register', 'Auth::register');
$routes->get('/auth/login', 'Auth::login');
$routes->post('/auth/login', 'Auth::login');
$routes->get('/auth/logout', 'Auth::logout');
$routes->get('/auth', 'Auth::index');
$routes->get('transaksi/realtime/(:num)', 'TransaksiController::realtime/$1');
// Dashboard Route
$routes->get('/dashboard', 'Dashboard::index');

// Transaksi Routes (Petugas, Admin & Superadmin)
$routes->get('/transaksi', 'TransaksiController::index');
$routes->post('/transaksi/store', 'TransaksiController::storeMasuk');
$routes->get('/transaksi/keluar', 'TransaksiController::keluar');
$routes->post('/transaksi/keluar/(:num)', 'TransaksiController::processKeluar/$1');
$routes->get('/transaksi/struk/(:num)', 'TransaksiController::cetakStruk/$1');
$routes->get('/transaksi/struk-masuk/(:num)', 'TransaksiController::cetakStrukMasuk/$1');
$routes->get('/cetak-struk', 'TransaksiController::cetakStrukList'); // Halaman daftar struk

// Rekap Transaksi Routes (Petugas, Admin & Superadmin)
$routes->get('/rekap-transaksi', 'TestRekapController::index');
$routes->post('/rekap-transaksi', 'RekapTransaksiController::rekapTransaksi');
$routes->get('/transaksi/struk/(:num)', 'TestRekapController::cetakStruk/$1'); // Cetak struk dari rekap

// Laporan Routes (Owner, Admin & Superadmin)
$routes->get('/laporan/pendapatan', 'LaporanController::pendapatan');
$routes->get('/laporan/statistik', 'LaporanController::statistik');

// User Routes (Admin & Superadmin only)
$routes->get('/users', 'UserController::index');
$routes->get('/users/create', 'UserController::create');
$routes->post('/users/store', 'UserController::store');
$routes->get('/users/edit/(:num)', 'UserController::edit/$1');
$routes->post('/users/update/(:num)', 'UserController::update/$1');
$routes->get('/users/delete/(:num)', 'UserController::delete/$1');

// Kendaraan Routes (Admin & Superadmin only)
$routes->get('/kendaraan', 'KendaraanController::index');
$routes->get('/kendaraan/create', 'KendaraanController::create');
$routes->post('/kendaraan/store', 'KendaraanController::store');
$routes->get('/kendaraan/edit/(:num)', 'KendaraanController::edit/$1');
$routes->post('/kendaraan/update/(:num)', 'KendaraanController::update/$1');
$routes->get('/kendaraan/delete/(:num)', 'KendaraanController::delete/$1');
$routes->get('/kendaraan/search', 'KendaraanController::search');

// Tarif Routes (Admin & Superadmin only)
$routes->get('/tarif', 'TarifController::index');
$routes->get('/tarif/create', 'TarifController::create');
$routes->post('/tarif/store', 'TarifController::store');
$routes->get('/tarif/edit/(:num)', 'TarifController::edit/$1');
$routes->post('/tarif/update/(:num)', 'TarifController::update/$1');
$routes->get('/tarif/delete/(:num)', 'TarifController::delete/$1');

// Area Parkir Routes (Admin & Superadmin only)
$routes->get('/area', 'AreaParkirController::index');
$routes->get('/area/create', 'AreaParkirController::create');
$routes->post('/area/store', 'AreaParkirController::store');
$routes->get('/area/edit/(:num)', 'AreaParkirController::edit/$1');
$routes->post('/area/update/(:num)', 'AreaParkirController::update/$1');
$routes->get('/area/delete/(:num)', 'AreaParkirController::delete/$1');
$routes->get('/area/search', 'AreaParkirController::search');
$routes->get('/area/reset-terisi/(:num)', 'AreaParkirController::resetTerisi/$1');

// Log Aktivitas Routes (Admin & Superadmin only)
$routes->get('/log-aktivitas', 'LogAktivitasController::index');
$routes->get('/log-aktivitas/search', 'LogAktivitasController::search');
$routes->post('/log-aktivitas/filter', 'LogAktivitasController::filterByDate');
$routes->get('/log-aktivitas/detail/(:num)', 'LogAktivitasController::detail/$1');
$routes->get('/log-aktivitas/export', 'LogAktivitasController::export');
$routes->post('/log-aktivitas/cleanup', 'LogAktivitasController::cleanup');
$routes->get('/log-aktivitas/statistics', 'LogAktivitasController::statistics');

// Test Log Route
$routes->get('/test-log', 'TestLogController::index');

// Test Area Route
$routes->get('/test-area', 'TestAreaController::index');

// Test Log Fix Route
$routes->get('/test-log-fix', 'TestLogFixController::index');

// Test All Logs Route
$routes->get('/test-all-logs', 'TestAllLogsController::index');

// Test Log Debug Route
$routes->get('/test-log-debug', 'TestLogDebug::index');

// Enable auto routing
$routes->setAutoRoute(true);
