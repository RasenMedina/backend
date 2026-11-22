
<?php
/*
 * FITXER: index.php
 *
 * Punt d'entrada de la gestió de jugadors de RAS Football.
 * Aquest fitxer prepara la sessió i el token CSRF abans de carregar el controlador.
 * El controlador s'encarregarà de gestionar les peticions, consultar la base de dades i carregar la vista.
 */

// ---------------------------------------------------------
// 1. INICIAR LA SESSIÓ
// ---------------------------------------------------------

// Comprovem si ja existeix una sessió activa.
// Si no existeix, la iniciem amb session_start().
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ---------------------------------------------------------
// 2. CREAR EL TOKEN CSRF
// ---------------------------------------------------------

// El token CSRF serveix per comprovar que les peticions d'eliminació provenen del formulari de la nostra aplicació.
// Només el creem si encara no existeix a la sessió.
if (empty($_SESSION['csrf_token'])) {

    // random_bytes(32) genera 32 bytes aleatoris.
    // bin2hex() els converteix en una cadena hexadecimal.
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// ---------------------------------------------------------
// 3. CARREGAR EL CONTROLADOR
// ---------------------------------------------------------

// Ara que la sessió i el token ja estan preparats, podem carregar el controlador de jugadors.
// El controlador processarà les peticions i carregarà la vista HTML.
require_once __DIR__ . '/controllers/JugadorController.php';

