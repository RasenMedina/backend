
<?php
/*
 * FITXER: JugadorController.php
 * Controlador de la gestió de jugadors de RAS Football.
 * Gestiona les peticions del navegador, valida les dades dels formularis i comunica el model amb la vista.
 */

require_once __DIR__ . '/../models/JugadorModel.php';
require_once __DIR__ . '/../../funcions.php';

// Variables que utilitzarem a la vista.
$jugadors = [];
$equips = [];
$errors = [];
$error = '';
$missatge = '';
$modeEdicio = false; // Indica si estem editant un jugador existent.
$idEdicio = null; // Identificador del jugador que volem modificar.

// Conservem els valors del formulari si hi ha errors.
$dades = [
    'nom' => '',
    'cognoms' => '',
    'dni' => '',
    'dorsal' => '',
    'posicio' => '',
    'equip_id' => ''
];


// Comprovem si l'usuari vol editar un jugador.
// Exemple: index.php?editar=4
if (
    $_SERVER['REQUEST_METHOD'] === 'GET'
    && isset($_GET['editar'])
) {
    // Validem que l'ID sigui un enter positiu.
    $id = filter_var(
        $_GET['editar'],
        FILTER_VALIDATE_INT,
        ['options' => ['min_range' => 1]]
    );

    if ($id === false) {
        $error = 'L\'identificador del jugador no és vàlid.';
    } else {
        try {
            // Demanem al model les dades del jugador.
            $jugadorEditar = obtenirJugadorPerId($id);

            if ($jugadorEditar === false) {
                $error = 'Aquest jugador no existeix.';
            } else {
                // Activem el mode d'edició.
                $modeEdicio = true;
                $idEdicio = $id;

                // Emplenem el formulari amb les dades actuals.
                foreach ($dades as $camp => $valor) {
                    $dades[$camp] = (string) (
                        $jugadorEditar[$camp] ?? ''
                    );
                }
            }
        } catch (PDOException $e) {
            error_log('Error en buscar jugador: ' . $e->getMessage());
            $error = 'No s\'ha pogut carregar el jugador.';
        }
    }
}



// ---------------------------------------------------------
// ELIMINACIÓ D'UN JUGADOR
// ---------------------------------------------------------

// Comprovem si s'ha enviat el formulari d'eliminació.
if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
    && ($_POST['accio'] ?? '') === 'eliminar'
) {
    // Recuperem el token enviat pel formulari.
    $tokenRebut = $_POST['csrf_token'] ?? '';

    // Comprovem que el token sigui vàlid.
    if (
        !is_string($tokenRebut)
        || !hash_equals(
            $_SESSION['csrf_token'] ?? '',
            $tokenRebut
        )
    ) {
        $error = 'La petició no és vàlida. Torna-ho a provar.';

    } else {

        // Recuperem l'ID del jugador.
        $idEliminar = filter_var(
            $_POST['id'] ?? null,
            FILTER_VALIDATE_INT,
            ['options' => ['min_range' => 1]]
        );

        // Comprovem que sigui un identificador vàlid.
        if ($idEliminar === false) {
            $error = 'L\'identificador del jugador no és vàlid.';

        } else {
            try {

                // Demanem al model que elimini el jugador.
                if (eliminarJugador($idEliminar)) {

                    // Redirigim per evitar repetir el POST.
                    header('Location: index.php?eliminat=1');
                    exit;

                } else {
                    $error = 'El jugador no existeix o ja s\'ha eliminat.';
                }

            } catch (PDOException $e) {

                // Guardem el detall tècnic al registre del servidor.
                error_log(
                    'Error en eliminar jugador: ' . $e->getMessage()
                );

                // Mostrem un missatge genèric a l'usuari.
                $error = 'No s\'ha pogut eliminar el jugador.';
            }
        }
    }
}


// Comprovem si el formulari s'ha enviat per POST.
// Fem que cada acció tingui el seu tractament: crear i editar utilitzaran el formulari principal; eliminar utilitzarà el formulari d'eliminació.

if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
    && in_array(
        $_POST['accio'] ?? '',
        ['crear', 'editar'],
        true
    )
) {


    // El formulari indica si volem crear o modificar.
    $accio = $_POST['accio'] ?? 'crear';

    // Només acceptem les accions previstes.
    if (!is_string($accio) ||
        !in_array($accio, ['crear', 'editar'], true)) {
        $accio = 'invalida';
    }

    if ($accio === 'editar') {

        // Recuperem i validem l'ID enviat pel formulari.
        $idEdicio = filter_var(
            $_POST['id'] ?? null,
            FILTER_VALIDATE_INT,
            ['options' => ['min_range' => 1]]
        );

        if ($idEdicio === false) {
            $error = 'L\'identificador no és vàlid.';
        } else {
            $modeEdicio = true;
        }
    }


    // Recuperem només els camps que esperem.
    // Comprovem que siguin cadenes per evitar errors.
    foreach ($dades as $camp => $valor) {
        $dades[$camp] = isset($_POST[$camp])
            && is_string($_POST[$camp])
            ? trim($_POST[$camp])
            : '';
    }

    // Validem els camps obligatoris.
    if ($dades['nom'] === '') {
        $errors['nom'] = 'Has d\'introduir el nom.';
    } elseif (mb_strlen($dades['nom']) > 100) {
        $errors['nom'] = 'El nom és massa llarg.';
    }

    if ($dades['cognoms'] === '') {
        $errors['cognoms'] = 'Has d\'introduir els cognoms.';
    } elseif (mb_strlen($dades['cognoms']) > 150) {
        $errors['cognoms'] = 'Els cognoms són massa llargs.';
    }

    if ($dades['dni'] === '') {
        $errors['dni'] = 'Has d\'introduir el DNI.';
    } elseif (mb_strlen($dades['dni']) > 20) {
        $errors['dni'] = 'El DNI és massa llarg.';
    }

    // Comprovem que el dorsal sigui un enter positiu.
    if (
        filter_var(
            $dades['dorsal'],
            FILTER_VALIDATE_INT,
            ['options' => ['min_range' => 1]]
        ) === false
    ) {
        $errors['dorsal'] = 'El dorsal ha de ser un enter positiu.';
    }

    if ($dades['posicio'] === '') {
        $errors['posicio'] = 'Has d\'introduir la posició.';
    } elseif (mb_strlen($dades['posicio']) > 50) {
        $errors['posicio'] = 'La posició és massa llarga.';
    }

    if (
        filter_var(
            $dades['equip_id'],
            FILTER_VALIDATE_INT,
            ['options' => ['min_range' => 1]]
        ) === false
    ) {
        $errors['equip_id'] = 'Has de seleccionar un equip.';
    }

    // Només desem si les dades són vàlides i l'acció i l'identificador són correctes.
    if (
        empty($errors)
        && $error === ''
        && in_array($accio, ['crear', 'editar'], true)
    ) {
        try {
            // Convertim els camps numèrics a enters.
            $dades['dorsal'] = (int) $dades['dorsal'];
            $dades['equip_id'] = (int) $dades['equip_id'];

            if ($accio === 'editar') {

                // Comprovem que el jugador encara existeixi.
                $jugadorActual = obtenirJugadorPerId($idEdicio);

                if ($jugadorActual === false) {
                    $error = 'Aquest jugador ja no existeix.';
                } elseif (actualitzarJugador($idEdicio, $dades)) {

                    // Redirigim després de modificar.
                    header('Location: index.php?modificat=1');
                    exit;
                } else {
                    $error = 'No s\'ha pogut modificar el jugador.';
                }

            } else {

                // Conservem el comportament de l'INSERT.
                if (inserirJugador($dades)) {
                    header('Location: index.php?creat=1');
                    exit;
                }

                $error = 'No s\'ha pogut afegir el jugador.';
            }

        } catch (PDOException $e) {

            // 23000 és un error de restricció d'integritat.
            if ($e->getCode() === '23000') {
                $error = 'El DNI ja existeix o l\'equip no és vàlid.';
            } else {
                $error = 'S\'ha produït un error en desar el jugador.';
            }

            // El detall tècnic queda al registre del servidor.
            error_log('Error en desar jugador: ' . $e->getMessage());
        }
    }
}

// Missatge després d'una inserció correcta.
if (isset($_GET['creat']) && $_GET['creat'] === '1') {
    $missatge = 'Jugador afegit correctament!';
}

// Missatge després de modificar correctament un jugador.
if (isset($_GET['modificat']) && $_GET['modificat'] === '1') {
    $missatge = 'Jugador modificat correctament!';
}

// Mostrem la confirmació després d'eliminar un jugador.
if (isset($_GET['eliminat']) && $_GET['eliminat'] === '1') {
    $missatge = 'Jugador eliminat correctament!';
}

// Recuperem les dades que necessita la vista.
try {
    // Obtenim tots els jugadors i els equips disponibles.
    $jugadors = obtenirJugadors();
    $equips = obtenirEquips();

} catch (PDOException $e) {

    // Registrem l'error tècnic sense mostrar-lo al navegador.
    error_log('Error en consultar dades: ' . $e->getMessage());

    // Mostrem un missatge comprensible per a l'usuari.
    $error = 'No s\'han pogut carregar les dades.';
}

// Mostrem la vista.
require __DIR__ . '/../views/jugadors.vista.php';



