<?php
/*
 * FITXER: connexio.php
 *
 * Aquest fitxer s'encarrega d'establir la connexió entre la nostra aplicació PHP i la base de dades MySQL.
 *
 * Utilitzem PDO perquè permet executar consultes SQL i treballar amb Prepared Statements.
 *
 * La funció connectarBD() retorna un objecte PDO que podrem reutilitzar en altres fitxers.
 */

/**
 * Estableix una connexió amb la base de dades.
 * @return PDO Objecte de connexió a MySQL.
 */
function connectarBD(): PDO
{
    // Dades de connexió a la base de dades local.
    $host = '127.0.0.1'; // Indica que MySQL està al nostre ordinador.
    $nomBD = 'pt02_rasen_medina'; // Identifica la base de dades que volem utilitzar.
    $usuari = 'root';
    $contrasenya = ''; // l'usuari root sense contrasenya és habitual en instal·lacions locals de XAMPP, però no és adequat per a un servidor públic. Més endavant podrem separar les credencials de la connexió en un fitxer privat.

    // DSN (Data Source Name): Indica el motor de base de dades, el servidor, el nom de la base de dades i el joc de caràcters, la informació necessària per establir la connexió..
    $dsn = "mysql:host=$host;dbname=$nomBD;charset=utf8mb4";

    // Opcions de configuració de PDO.
    $opcions = [

        // Quan es produeix un error SQL, PDO llança una excepció que podem capturar amb try/catch.
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,

        // Els resultats de les consultes es retornen com a arrays associatius: ['nom' => '...'].
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,

        // Indiquem que volem utilitzar consultes preparades reals del servidor quan el controlador les admeti.
        PDO::ATTR_EMULATE_PREPARES => false
    ];

    // Creem la connexió PDO.
    // Si les dades són incorrectes o MySQL no està disponible, aquesta instrucció llançarà una PDOException.
    return new PDO($dsn, $usuari, $contrasenya, $opcions);
}