<?php
/*
 * PROCESSA.PHP
 * ------------
 * Aquest fitxer fa de CONTROLADOR.
 *
 * Flux:
 * 1. Rep les dades enviades pel formulari.
 * 2. Comprova que la petició sigui POST.
 * 3. Recupera les dades.
 * 4. Valida les dades.
 * 5. Si hi ha errors, torna a mostrar index.php conservant les dades.
 * 6. Si tot és correcte, més endavant aquí enviarem el correu amb PHPMailer.
 */

/*
 * Arrays on guardarem tots els errors detectats.
 *
 * És millor tenir un array d'errors que anar mostrant un error
 * i aturar el programa cada vegada que trobem un problema.
 */
$errors = [];

/*
 * Variables que guardaran les dades del formulari.
 * Les inicialitzem buides perquè existeixin encara que no s'hagi
 * enviat cap formulari.
 */
$nom = '';
$email = '';
$text = '';

/*
 * Comprovem que realment hem arribat aquí mitjançant POST.
 *
 * $_SERVER és una superglobal de PHP.
 * REQUEST_METHOD ens diu quin mètode HTTP ha utilitzat el navegador.
 */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    /*
     * Si algú entra directament a processa.php sense enviar el formulari,
     * no té sentit processar res.
     */
    header('Location: index.php');
    exit;
}

/*
 * ==============================================================
 * 1. RECUPERAR LES DADES
 * ==============================================================
 *
 * $_POST és una superglobal que conté les dades enviades amb POST.
 *
 * isset() comprova si existeix aquella clau.
 *
 * trim() elimina espais al principi i al final.
 *
 * IMPORTANT:
 * Aquí no estem dient encara si la dada és vàlida.
 * Només la recuperem.
 */

$nom = isset($_POST['nom']) ? trim($_POST['nom']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$text = isset($_POST['text']) ? trim($_POST['text']) : '';

/*
 * ==============================================================
 * 2. VALIDAR EL NOM
 * ==============================================================
 */

/*
 * Comprovem si està buit.
 *
 * No n'hi ha prou amb required="" de l'HTML perquè un usuari
 * pot enviar una petició manualment sense passar per la validació
 * del navegador.
 */
if ($nom === '') {
    $errors[] = 'El nom és obligatori.';
}

/*
 * Comprovem una longitud mínima i màxima.
 */
elseif (mb_strlen($nom) < 2) {
    $errors[] = 'El nom ha de tenir com a mínim 2 caràcters.';
}

elseif (mb_strlen($nom) > 100) {
    $errors[] = 'El nom no pot superar els 100 caràcters.';
}

/*
 * ==============================================================
 * 3. VALIDAR EL CORREU
 * ==============================================================
 */

if ($email === '') {

    $errors[] = 'El correu electrònic és obligatori.';

} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

    /*
     * FILTER_VALIDATE_EMAIL comprova si el text té un format
     * compatible amb una adreça de correu.
     *
     * IMPORTANT:
     * Això NO garanteix que l'adreça existeixi realment.
     * Només comprova el format.
     */
    $errors[] = 'El correu electrònic no té un format vàlid.';
}

/*
 * ==============================================================
 * 4. VALIDAR EL TEXT
 * ==============================================================
 */

if ($text === '') {
    $errors[] = 'El text és obligatori.';
}

elseif (mb_strlen($text) < 10) {
    $errors[] = 'El text ha de tenir com a mínim 10 caràcters.';
}

elseif (mb_strlen($text) > 2000) {
    $errors[] = 'El text no pot superar els 2000 caràcters.';
}

/*
 * ==============================================================
 * 5. COMPROVAR SI HI HA ERRORS
 * ==============================================================
 */

if (!empty($errors)) {

    /*
     * IMPORTANT:
     * No fem echo de les dades aquí.
     *
     * Carreguem la vista index.php i li passem:
     * - $errors
     * - $nom
     * - $email
     * - $text
     *
     * D'aquesta manera index.php pot mostrar els errors
     * i conservar el que havia escrit l'usuari.
     */
    require 'index.php';
    exit;
}

/*
 * ==============================================================
 * 6. SI ARRIBEM AQUÍ, LES DADES SÓN CORRECTES
 * ==============================================================
 *
 * En aquest punt:
 * - el nom no està buit i té una longitud correcta;
 * - l'email té un format correcte;
 * - el text no està buit i té una longitud correcta.
 *
 * Més endavant AQUEST és el lloc on integrarem PHPMailer
 * per enviar el correu.
 *
 * De moment només indiquem a la vista que ha anat bé.
 */

$enviatCorrectament = true;

/*
 * Tornem a carregar la vista.
 */
require 'index.php';
