
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
                        </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        <?php endif; ?>


        <section class="formulari-jugador">

            <h2>Afegir un jugador</h2>

            <p>Introdueix les dades del nou jugador.</p>

            <?php if ($missatge !== ''): ?>
                <p class="correcte"><?= escapar($missatge) ?></p>
            <?php endif; ?>

            <?php if ($error !== ''): ?>
                <p class="error"><?= escapar($error) ?></p>
            <?php endif; ?>

            <form action="index.php" method="POST">

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

                <button type="submit">Afegir jugador</button>

            </form>

        </section>


    </main>

</body>
</html>
