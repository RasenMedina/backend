<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pràctica 01 · Formulari de contacte</title>
    <link rel="stylesheet" href="estils.css">
</head>
<body>
<main class="contenidor">
    <h1>Formulari de contacte amb PHPMailer</h1>
    <p>Introdueix el teu nom, correu i missatge.</p>
    <!-- PHP_SELF indica el mateix controlador; escapar evita injectar HTML a action. -->
    <form action="<?= escapar($_SERVER['PHP_SELF'] ?? 'index.php') ?>" method="post" novalidate>
        <!-- novalidate permet comprovar els errors del costat del servidor. -->
        <label for="nom">Nom</label>
        <input id="nom" name="nom" type="text" value="<?= escapar($dades['nom']) ?>">
        <?php if (isset($errors['nom'])): ?><p class="error"><?= escapar($errors['nom']) ?></p><?php endif; ?>

        <label for="correu">Correu electrònic</label>
        <input id="correu" name="correu" type="email" value="<?= escapar($dades['correu']) ?>">
        <?php if (isset($errors['correu'])): ?><p class="error"><?= escapar($errors['correu']) ?></p><?php endif; ?>

        <label for="missatge">Missatge</label>
        <textarea id="missatge" name="missatge" rows="6"><?= escapar($dades['missatge']) ?></textarea>
        <?php if (isset($errors['missatge'])): ?><p class="error"><?= escapar($errors['missatge']) ?></p><?php endif; ?>

        <?php if ($enviat): ?>
            <p class="correcte" role="status">Enviat correctament</p>
        <?php elseif ($errorEnviament !== ''): ?>
            <p class="error" role="alert"><?= escapar($errorEnviament) ?></p>
        <?php endif; ?>
        <button type="submit">Enviar correu</button>
    </form>
</main>
</body>
</html>
