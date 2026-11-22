<?php
/*
 * FITXER: prova_connexio.php
 *
 * Fitxer temporal per comprovar que PHP es pot connectar correctament a la base de dades mitjançant PDO.
 *
 * També executem una consulta SQL senzilla per recuperar els noms de les taules de la base de dades.
 */

// Carreguem el fitxer que conté la funció connectarBD().
require_once __DIR__ . '/connexio.php';

try {
    // Intentem establir la connexió amb MySQL.
    $pdo = connectarBD();

    // Preparem una consulta SQL per obtenir les taules.
    // prepare() prepara la consulta SQL.
    $consulta = $pdo->prepare("SHOW TABLES");

    // Executem la consulta preparada.
    // execute() executa la consulta SQL.
    $consulta->execute();

    // Recuperem totes les files del resultat.
    // PDO::FETCH_COLUMN indica que volem recuperar únicament els valors de la primera columna de cada fila.
    $taules = $consulta->fetchAll(PDO::FETCH_COLUMN);

    // Mostrem un missatge de confirmació.
    echo '<h1>Connexió PDO correcta!</h1>';

    // Mostrem els noms de les taules recuperades.
    echo '<h2>Taules de la base de dades:</h2>';
    echo '<ul>';

    foreach ($taules as $taula) {
        // Escapem el nom abans de mostrar-lo en HTML.
        echo '<li>' . htmlspecialchars($taula, ENT_QUOTES, 'UTF-8') . '</li>';
    }

    echo '</ul>';

} catch (PDOException $e) {

    // Registrem l'error tècnic al servidor.
    error_log('Error de connexió PDO: ' . $e->getMessage());

    // Mostrem un missatge genèric a l'usuari.
    echo 'No s\'ha pogut connectar amb la base de dades.';
}
