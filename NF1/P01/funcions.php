<?php
// MODEL / SERVEI: funcions reutilitzables de validació i enviament.
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/** Escapa el text quan es mostra dins l'HTML: evita executar etiquetes injectades. */
function escapar(string $text): string {
    return htmlspecialchars($text, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** Valida els camps rebuts del formulari i retorna els errors per camp. */
function validarFormulari(array $dades): array {
    $errors = [];
    if ($dades['nom'] === '') $errors['nom'] = 'Has de posar el nom.';
    elseif (mb_strlen($dades['nom']) > 100) $errors['nom'] = 'El nom és massa llarg.';
    if ($dades['correu'] === '') $errors['correu'] = 'Has de posar el correu.';
    elseif (!filter_var($dades['correu'], FILTER_VALIDATE_EMAIL)) $errors['correu'] = 'El correu no és vàlid.';
    if ($dades['missatge'] === '') $errors['missatge'] = 'Has de posar el missatge.';
    elseif (mb_strlen($dades['missatge']) > 5000) $errors['missatge'] = 'El missatge és massa llarg.';
    return $errors;
}

/** Envia un correu amb PHPMailer. Només retorna true si send() funciona. */
function enviarCorreu(array $dades, array $config): bool {
    // Els fitxers del professor estan a la carpeta PHPMailer/.
    require_once __DIR__ . '/PHPMailer/Exception.php';
    require_once __DIR__ . '/PHPMailer/PHPMailer.php';
    require_once __DIR__ . '/PHPMailer/SMTP.php';
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = $config['host'];
        $mail->SMTPAuth = true;
        $mail->Username = $config['usuari'];
        $mail->Password = $config['contrasenya'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = (int)$config['port'];
        $mail->CharSet = 'UTF-8';
        // El remitent ha de ser el compte autenticat, no el correu del visitant.
        $mail->setFrom($config['usuari'], 'Formulari P01');
        $mail->addAddress($config['destinatari']);
        $mail->addReplyTo($dades['correu'], $dades['nom']);
        $mail->isHTML(false); // Text pla: no interpretem HTML enviat per l'usuari.
        $mail->Subject = 'Nou missatge del formulari P01';
        $mail->Body = "Nom: {$dades['nom']}\nCorreu: {$dades['correu']}\n\n{$dades['missatge']}";
        return $mail->send();
    } catch (Exception $e) {
        // Registrem el detall al servidor, no mostrem credencials al navegador.
        error_log('PHPMailer: ' . $mail->ErrorInfo);
        return false;
    }
}
