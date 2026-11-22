
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

// Conservem els valors del formulari si hi ha errors.
$dades = [
    'nom' => '',
    'cognoms' => '',
    'dni' => '',
    'dorsal' => '',
    'posicio' => '',
    'equip_id' => ''
];

// Comprovem si el formulari s'ha enviat per POST.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

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

    // Només intentem inserir si no hi ha errors.
    if (empty($errors)) {
        try {
            // Convertim els camps numèrics a enters.
            $dades['dorsal'] = (int) $dades['dorsal'];
            $dades['equip_id'] = (int) $dades['equip_id'];

            // Cridem la funció del model.
            if (inserirJugador($dades)) {

                // Redirigim per evitar repetir el POST
                // si l'usuari actualitza la pàgina.
                header('Location: index.php?creat=1');
                exit;
            }

            $error = 'No s\'ha pogut afegir el jugador.';

        } catch (PDOException $e) {

            // El DNI té una restricció UNIQUE a MySQL.
            // El codi 23000 indica un error d'integritat.
            if ($e->getCode() === '23000') {
                $error = 'El DNI ja existeix o l\'equip seleccionat no és vàlid.';
            } else {
                $error = 'S\'ha produït un error en desar el jugador.';
            }

            // Guardem el detall tècnic només al servidor.
            error_log('Error en inserir jugador: ' . $e->getMessage());
        }
    }
}

// Missatge després d'una inserció correcta.
if (isset($_GET['creat']) && $_GET['creat'] === '1') {
    $missatge = 'Jugador afegit correctament!';
}

// Recuperem les dades que necessita la vista.
try {
    $jugadors = obtenirJugadors();
    $equips = obtenirEquips();

} catch (PDOException $e) {
    error_log('Error en consultar dades: ' . $e->getMessage());
    $error = 'No s\'han pogut carregar les dades.';
}

// Mostrem la vista.
require __DIR__ . '/../views/jugadors.vista.php';
