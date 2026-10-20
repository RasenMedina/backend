<?php
// CONTROLADOR: rep POST, valida, envia i prepara les variables de la vista.
require_once __DIR__ . '/funcions.php';

$dades = ['nom' => '', 'correu' => '', 'missatge' => ''];
$errors = [];
$enviat = false;
$errorEnviament = '';

// Només processem quan l'usuari envia el formulari amb POST.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // is_string evita errors si algú envia arrays en lloc de text.
    foreach ($dades as $camp => $_) {
        $valor = $_POST[$camp] ?? '';
        $dades[$camp] = is_string($valor) ? trim($valor) : '';
    }
    $errors = validarFormulari($dades);

    // Només intentem enviar si no hi ha errors de validació.
    if (!$errors) {
        $rutaConfig = __DIR__ . '/config.php';
        if (!is_file($rutaConfig)) {
            $errorEnviament = 'Falta configurar el correu (config.php).';
        } else {
            $config = require $rutaConfig;
            $enviat = enviarCorreu($dades, $config);
            if ($enviat) {
                // Buidem els camps després d'un enviament realment correcte.
                $dades = ['nom' => '', 'correu' => '', 'missatge' => ''];
            } else {
                $errorEnviament = 'No ha estat possible enviar el correu. Revisa la configuració SMTP.';
            }
        }
    }
}
// La vista només presenta dades i missatges: no envia correus ni valida.
require __DIR__ . '/index.vista.php';
