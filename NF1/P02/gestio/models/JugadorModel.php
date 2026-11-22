
<?php
/*
 * FITXER: JugadorModel.php
 *
 * Model de jugadors del projecte RAS Football.
 * Aquest fitxer conté les funcions que consulten la taula jugadors mitjançant PDO.
 * Seguint el patró MVC, el model s'encarrega d'obtenir les dades, però no de generar HTML.
 */

// Carreguem el fitxer que conté la funció connectarBD().
// __DIR__ és la carpeta actual: gestio/models.
// Amb ../../ arribem a P02 i entrem a database.
require_once __DIR__ . '/../../database/connexio.php';

/**
 * Recupera tots els jugadors i el nom del seu equip.
 * @return array Llista de jugadors com a arrays associatius.
 */
function obtenirJugadors(): array
{
    // Establim la connexió amb MySQL.
    $pdo = connectarBD();

    // Preparem una consulta que relaciona jugadors i equips.
    // LEFT JOIN permet mostrar també jugadors sense equip.
    $sql = "
        SELECT
            jugadors.id,
            jugadors.nom,
            jugadors.cognoms,
            jugadors.dni,
            jugadors.dorsal,
            jugadors.posicio,
            equips.nom AS equip
        FROM jugadors
        LEFT JOIN equips
            ON jugadors.equip_id = equips.id
        ORDER BY jugadors.id ASC
    ";

    // Preparem la consulta SQL amb PDO.
    $consulta = $pdo->prepare($sql);

    // Executem la consulta.
    $consulta->execute();

    // Recuperem totes les files del resultat.
    // La connexió ja està configurada amb PDO::FETCH_ASSOC.
    return $consulta->fetchAll();
}


/**
 * Insereix un jugador nou a la base de dades.
 * Rep les dades validades pel controlador i executa un INSERT mitjançant PDO i Prepared Statements.
 * @param array $dades Dades del jugador que volem crear.
 * @return bool Indica si la inserció s'ha executat.
 */
function inserirJugador(array $dades): bool
{
    // Obtenim la connexió PDO amb MySQL.
    $pdo = connectarBD();

    // Definim la consulta SQL.
    // Els valors :nom, :cognoms, etc. són paràmetres.
    // No concatenem directament dades de l'usuari a l'SQL.
    $sql = "
        INSERT INTO jugadors
            (nom, cognoms, dni, dorsal, posicio, equip_id)
        VALUES
            (:nom, :cognoms, :dni, :dorsal, :posicio, :equip_id)
    ";

    // Preparem la consulta abans d'introduir-hi els valors.
    // prepare() prepara la consulta
    $consulta = $pdo->prepare($sql);

    // Associem cada paràmetre amb la seva dada. 
    // bindValue() associa els valors
    // PDO::PARAM_INT indica que el valor és un enter.
    // PDO::PARAM_STR indica que el valor és una cadena.
    $consulta->bindValue(':nom', $dades['nom'], PDO::PARAM_STR);
    $consulta->bindValue(':cognoms', $dades['cognoms'], PDO::PARAM_STR);
    $consulta->bindValue(':dni', $dades['dni'], PDO::PARAM_STR);
    $consulta->bindValue(':dorsal', $dades['dorsal'], PDO::PARAM_INT);
    $consulta->bindValue(':posicio', $dades['posicio'], PDO::PARAM_STR);
    $consulta->bindValue(':equip_id', $dades['equip_id'], PDO::PARAM_INT);

    // Executem la consulta amb els paràmetres assignats.
    return $consulta->execute();
}


/**
 * Recupera els equips disponibles.
 * @return array Llista d'equips amb el seu ID i nom.
 */
function obtenirEquips(): array
{
    // Connectem amb la base de dades.
    $pdo = connectarBD();

    // Recuperem els equips ordenats alfabèticament.
    $sql = "SELECT id, nom FROM equips ORDER BY nom ASC";

    // Preparem i executem la consulta.
    $consulta = $pdo->prepare($sql);
    $consulta->execute();

    // Retornem els equips al controlador.
    return $consulta->fetchAll(PDO::FETCH_ASSOC);
}

