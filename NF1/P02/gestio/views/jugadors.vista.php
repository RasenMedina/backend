
<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestió de jugadors | RAS Football</title>

    <!-- El navegador obrirà aquesta pàgina des de gestio/index.php. Per això pugem un nivell fins a P02 per carregar estils.css. -->
    <link rel="stylesheet" href="../css/estils.css">
</head>

<body>

    <main class="contenidor">

        <h1>Jugadors de RAS Football</h1>

        <p>Llistat de jugadors registrats a la base de dades.</p>

        <?php if (empty($jugadors)): ?>

            <!-- La consulta funciona, però no hi ha registres. -->
            <p>Encara no hi ha jugadors registrats.</p>

        <?php else: ?>

            <!-- Mostrem les dades que ha recuperat el model. -->
            <table class="taula-jugadors">

                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>DNI</th>
                        <th>Dorsal</th>
                        <th>Posició</th>
                        <th>Equip</th>
                        <th>Accions</th>
                    </tr>
                </thead>

                <tbody>

                    <?php foreach ($jugadors as $jugador): ?>

                        <tr>
                            <!-- Nom complet del jugador -->
                            <td>
                                <?= escapar($jugador['nom'] . ' ' . $jugador['cognoms']) ?>
                            </td>

                            <!-- DNI -->
                            <td>
                                <?= escapar($jugador['dni']) ?>
                            </td>

                            <!-- Dorsal -->
                            <td>
                                <?= escapar((string) ($jugador['dorsal'] ?? '-')) ?>
                            </td>

                            <!-- Posició -->
                            <td>
                                <?= escapar($jugador['posicio']) ?>
                            </td>

                            <!-- Equip -->
                            <td>
                                <?= escapar($jugador['equip'] ?? 'Sense equip') ?>
                            </td>

                            <td>
                                <!-- Enllaç per modificar les dades del jugador. -->
                                <a href="index.php?editar=<?= (int) $jugador['id'] ?>">
                                    Editar
                                </a>

                                <!-- Formulari independent per eliminar el jugador. -->
                                <form
                                    action="index.php"
                                    method="POST"
                                    class="formulari-eliminar"
                                    onsubmit="return confirm('Segur que vols eliminar aquest jugador?');"
                                >
                                    <!-- Indiquem l'acció que ha d'executar el controlador. -->
                                    <input
                                        type="hidden"
                                        name="accio"
                                        value="eliminar"
                                    >

                                    <!-- Identificador del jugador seleccionat. -->
                                    <input
                                        type="hidden"
                                        name="id"
                                        value="<?= (int) $jugador['id'] ?>"
                                    >

                                    <!-- Token de seguretat per validar la petició. -->
                                    <input
                                        type="hidden"
                                        name="csrf_token"
                                        value="<?= escapar($_SESSION['csrf_token']) ?>"
                                    >

                                    <button type="submit" class="boto-eliminar">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        <?php endif; ?>


        <section class="formulari-jugador">

            <h2>
                <?= $modeEdicio ? 'Modificar jugador' : 'Afegir un jugador' ?>
            </h2>

            <p>
                <?= $modeEdicio
                    ? 'Modifica les dades del jugador seleccionat.'
                    : 'Introdueix les dades del nou jugador.' ?>
            </p>
            <?php if ($missatge !== ''): ?>
                <p class="correcte"><?= escapar($missatge) ?></p>
            <?php endif; ?>

            <?php if ($error !== ''): ?>
                <p class="error"><?= escapar($error) ?></p>
            <?php endif; ?>

            <form action="index.php" method="POST">

                <!--
                    Token CSRF del formulari de creació i modificació.
                    El valor es genera a gestio/index.php i es guarda a la sessió del servidor.
                    En enviar el formulari, el controlador comprovarà que aquest token coincideix amb el de la sessió.
                -->
                <input
                    type="hidden"
                    name="csrf_token"
                    value="<?= escapar($_SESSION['csrf_token']) ?>"
                >    

                <!-- Indiquem al controlador quina operació volem fer. -->
                <input
                    type="hidden"
                    name="accio"
                    value="<?= $modeEdicio ? 'editar' : 'crear' ?>"
                >

                <!-- Si estem editant, enviem l'ID del jugador. -->
                <?php if ($modeEdicio): ?>
                    <input
                        type="hidden"
                        name="id"
                        value="<?= (int) $idEdicio ?>"
                    >
                <?php endif; ?>

                <label for="nom">Nom</label>
                <input
                    type="text"
                    id="nom"
                    name="nom"
                    maxlength="100"
                    value="<?= escapar($dades['nom']) ?>"
                    required
                >
                <?php if (isset($errors['nom'])): ?>
                    <p class="error"><?= escapar($errors['nom']) ?></p>
                <?php endif; ?>

                <label for="cognoms">Cognoms</label>
                <input
                    type="text"
                    id="cognoms"
                    name="cognoms"
                    maxlength="150"
                    value="<?= escapar($dades['cognoms']) ?>"
                    required
                >
                <?php if (isset($errors['cognoms'])): ?>
                    <p class="error"><?= escapar($errors['cognoms']) ?></p>
                <?php endif; ?>

                <label for="dni">DNI</label>
                <input
                    type="text"
                    id="dni"
                    name="dni"
                    maxlength="20"
                    value="<?= escapar($dades['dni']) ?>"
                    required
                >
                <?php if (isset($errors['dni'])): ?>
                    <p class="error"><?= escapar($errors['dni']) ?></p>
                <?php endif; ?>

                <label for="dorsal">Dorsal</label>
                <input
                    type="number"
                    id="dorsal"
                    name="dorsal"
                    min="1"
                    value="<?= escapar((string) $dades['dorsal']) ?>"
                    required
                >
                <?php if (isset($errors['dorsal'])): ?>
                    <p class="error"><?= escapar($errors['dorsal']) ?></p>
                <?php endif; ?>

                <label for="posicio">Posició</label>
                <input
                    type="text"
                    id="posicio"
                    name="posicio"
                    maxlength="50"
                    value="<?= escapar($dades['posicio']) ?>"
                    required
                >
                <?php if (isset($errors['posicio'])): ?>
                    <p class="error"><?= escapar($errors['posicio']) ?></p>
                <?php endif; ?>

                <label for="equip_id">Equip</label>
                <select id="equip_id" name="equip_id" required>
                    <option value="">Selecciona un equip</option>

                    <?php foreach ($equips as $equip): ?>
                        <option
                            value="<?= (int) $equip['id'] ?>"
                            <?= (string) $dades['equip_id'] ===
                                (string) $equip['id'] ? 'selected' : '' ?>
                        >
                            <?= escapar($equip['nom']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <?php if (isset($errors['equip_id'])): ?>
                    <p class="error"><?= escapar($errors['equip_id']) ?></p>
                <?php endif; ?>

                
                <button type="submit">
                    <?= $modeEdicio ? 'Desar canvis' : 'Afegir jugador' ?>
                </button>

                <?php if ($modeEdicio): ?>
                    <p>
                        <a href="index.php">Cancel·lar edició</a>
                    </p>
                <?php endif; ?>
            </form>
        </section>
    </main>
</body>
</html>
