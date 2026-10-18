<?php
/*
 * INDEX.PHP
 * ----------
 * Aquest fitxer és principalment la VISTA:
 * - Mostra el formulari.
 * - Mostra els errors que ens envia processa.php.
 * - Manté les dades introduïdes si hi ha errors.
 *
 * La VALIDACIÓ de les dades es fa a processa.php.
 */

/*
 * Si index.php s'obre directament, aquestes variables poden no existir.
 * Per això utilitzem ?? per donar-los un valor per defecte.
 */
$errors = $errors ?? [];
$nom = $nom ?? '';
$email = $email ?? '';
$text = $text ?? '';
$enviatCorrectament = $enviatCorrectament ?? false;

/*
 * htmlspecialchars() serveix per ESCAPAR dades quan les mostrem
 * dins d'HTML. Això evita que una dada introduïda per l'usuari
 * sigui interpretada com a codi HTML.
 *
 * Exemple:
 * Si l'usuari escriu <script>...</script>, al navegador es mostrarà
 * com a text i no s'executarà.
 */
function e(string $valor): string
{
    return htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Formulari de contacte</title>

    <!-- Carreguem el nostre CSS -->
    <link rel="stylesheet" href="estils.css">
</head>

<body>

<main class="contenidor">

    <h1>Formulari de contacte</h1>

    <?php if ($enviatCorrectament): ?>
        <!-- Aquest missatge només apareix si processa.php ha validat tot correctament. -->
        <p class="missatge-exit">Enviat correctament.</p>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
        <div class="missatge-error" role="alert">
            <p><strong>Hi ha errors al formulari:</strong></p>

            <ul>
                <?php foreach ($errors as $error): ?>
                    <!-- Escapem també els missatges abans de mostrar-los. -->
                    <li><?= e($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!--
        action="processa.php":
        quan l'usuari prem "Enviar", les dades s'envien a processa.php.

        method="POST":
        les dades del formulari viatgen dins del cos de la petició HTTP
        i les podrem recuperar amb $_POST.
    -->
    <form action="processa.php" method="POST">

        <div class="camp">
            <label for="nom">Nom</label>

            <!--
                name="nom":
                és el nom que PHP utilitzarà per recuperar la dada:
                $_POST['nom']

                id="nom":
                identifica l'element dins de l'HTML i permet relacionar-lo
                amb el label mitjançant for="nom".

                required:
                és una validació del navegador, però NO substitueix
                la validació PHP del servidor.
            -->
            <input
                type="text"
                name="nom"
                id="nom"
                value="<?= e($nom) ?>"
                required
            >
        </div>

        <div class="camp">
            <label for="email">Adreça de correu</label>

            <input
                type="email"
                name="email"
                id="email"
                value="<?= e($email) ?>"
                required
            >
        </div>

        <div class="camp">
            <label for="text">Text</label>

            <!--
                En un textarea el contingut va ENTRE les etiquetes,
                no dins de value="" com en un input.
            -->
            <textarea
                name="text"
                id="text"
                rows="6"
                required
            ><?= e($text) ?></textarea>
        </div>

        <button type="submit">Enviar</button>

    </form>

</main>

</body>
</html>
