
<?php
/**
 * FITXER: index.vista.php
 *
 * Aquest fitxer representa la VISTA del formulari de contacte.
 * La seva responsabilitat és mostrar la interfície a l'usuari mitjançant HTML i presentar les dades i els errors que rep del controlador (index.php).
 *
 * El formulari permet introduir:
 * - Nom de l'usuari.
 * - Adreça de correu electrònic.
 * - Missatge de contacte.
 *
 * Aquest fitxer NO s'encarrega de validar les dades ni d'enviar correus electrònics. Aquestes operacions es gestionen des de la lògica PHP del projecte.
 *
 * ARQUITECTURA:
 * Separació entre controlador i vista (inspirada en MVC).
 *
 * DEPENDÈNCIES:
 * - index.php: prepara les dades i els errors.
 * - funcions.php: defineix la funció escapar().
 * - estils.css: defineix l'aparença visual.
 *
 * IMPORTANT:
 * Aquest fitxer està pensat per ser inclòs des d'index.php.
 * Per tant, utilitza variables que el controlador ja ha inicialitzat abans de carregar la vista.
 */
?>



<!-- DOCTYPE: Indica al navegador que el document utilitza HTML5. Ajuda a evitar modes de compatibilitat antics. -->
<!DOCTYPE html>

<!-- html: És l'element principal de tot el document HTML. -->
<!-- lang="ca": Indica que l'idioma principal de la pàgina és el català. És útil per a l'accessibilitat i els cercadors. -->
<html lang="ca">

<!-- head: Conté informació sobre el document. Aquesta informació no forma part del contingut principal visible de la pàgina. -->
<head>
    <!-- charset="UTF-8": Defineix la codificació de caràcters. UTF-8 permet mostrar correctament accents, dièresis, símbols i altres caràcters especials. -->
    <meta charset="UTF-8">

    <!-- 
        viewport: Permet adaptar la pàgina a diferents pantalles.
        width=device-width: Utilitza l'amplada del dispositiu.
        initial-scale=1: Estableix l'escala inicial de visualització.
    -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- description: Proporciona una breu descripció del contingut de la pàgina per a cercadors i altres eines. -->
    <meta
        name="description"
        content="Formulari de contacte desenvolupat amb PHP i PHPMailer per a la pràctica P01 de Desenvolupament Web en Entorn Servidor."
    >

    <!-- author: Identifica l'autor del document HTML. -->

    <!-- title: Defineix el títol que apareix a la pestanya del navegador. -->
    <title>Formulari de contacte</title>

    <!--
        link: Vincula el document HTML amb un fitxer extern.
        rel="stylesheet": Indica que el fitxer és un full d'estils CSS.
        href="estils.css": Indica la ruta relativa del fitxer CSS.
    -->
    <link rel="stylesheet" href="estils.css">
</head>

<!-- body: Conté tots els elements visibles de la pàgina. -->
<body>
    <!-- main: Representa el contingut principal de la pàgina. -->
    <main class="contenidor">

        <!-- h1: És el títol principal de la pàgina. -->  
        <h1>Formulari de contacte amb PHPMailer</h1>

        <!-- Paràgraf informatiu per indicar a l'usuari què ha d'introduir al formulari -->
        <p>Introdueix el teu nom, correu i missatge.</p>

        <!-- 
            form: Defineix el formulari HTML.
            action: Indica a quina URL s'enviaran les dades.
            $_SERVER['PHP_SELF']: Conté la ruta del script PHP que s'està executant en la petició actual.
            ?? 'index.php': Utilitza index.php si PHP_SELF no existeix o té el valor null.
            escapar(): Converteix caràcters especials en entitats HTML per evitar que s'interpretin com a codi dins de l'atribut action.
            method="post": Envia les dades mitjançant el mètode HTTP POST.
            novalidate: Desactiva la validació automàtica del navegador. Així podem practicar i mostrar les validacions realitzades al servidor amb PHP (controlador).
        -->
        <form 
            action="<?= escapar($_SERVER['PHP_SELF'] ?? 'index.php') ?>" 
            method="post" 
            novalidate
        >

            <!-- 
                label: Defineix l'etiqueta descriptiva del camp.
                for="nom": Relaciona aquesta etiqueta amb l'element que tingui id="nom". 
            -->
            <label for="nom">Nom</label>

            <!--
                input: Permet introduir dades a l'usuari.
                id="nom": Identificador del camp dins del document.
                name="nom": Nom de la clau que PHP rebrà a $_POST.
                type="text": Indica que s'introdueix text.
                value: Mostra el valor que hi ha a $dades['nom']. Si hi ha un error, el controlador conserva el valor i l'usuari no l'ha de tornar a escriure.
                escapar(): Evita que el contingut de l'usuari s'interpreti com a HTML.
            -->
            <input 
                id="nom" 
                name="nom" 
                type="text" 
                value="<?= escapar($dades['nom']) ?>"
            >

            <!-- 
                Comprovem si existeix un error del camp nou i si és el cas el mostrem.
                isset():  Retorna true si la variable o element existeix i no té el valor null.
                $errors['nom']: Conté el missatge d'error associat al nom.
                class="error": Permet aplicar estils CSS a l'error.
                escapar(): Mostra el missatge com a text segur.
            -->
            <?php if (isset($errors['nom'])): ?>
                <p class="error">
                    <?= escapar($errors['nom']) ?>
                </p>
            <?php endif; ?>

            <!-- Etiqueta vinculada al camp de correu. -->
            <label for="correu">Correu electrònic</label>

            <!-- 
                type="email": Identifica el camp com una adreça de correu.
                name="correu": PHP rebrà aquest camp com $_POST['correu'].
                value: Conserva el correu introduït anteriorment.
                La validació real del format del correu es realitza al controlador PHP.
            -->
            <input 
                id="correu" 
                name="correu" 
                type="email" 
                value="<?= escapar($dades['correu']) ?>"
            >

            <!-- Si el controlador ha detectat un error al correu electrònic, el mostrem. -->
            <?php if (isset($errors['correu'])): ?>
                <p class="error">
                    <?= escapar($errors['correu']) ?>
                </p>
            <?php endif; ?>

            <!-- Etiqueta associada al camp de missatge. -->
            <label for="missatge">Missatge</label>

            <!-- 
                textarea: Permet introduir text de diverses línies.
                id="missatge": Identifica el camp.
                name="missatge": PHP rebrà $_POST['missatge'].
                rows="6": Defineix una alçada inicial aproximada de sis línies de text.
                escapar(): Evita interpretar el contingut com a HTML.
                A diferència d'input, textarea no utilitza l'atribut value. El contingut s'escriu entre les etiquetes d'obertura i tancament.
            -->
            <textarea 
                id="missatge" 
                name="missatge" 
                rows="6"
            >
                <?= escapar($dades['missatge']) ?>
            </textarea>

            <!-- Comprovem si existeix un error associat al camp missatge. -->
            <?php if (isset($errors['missatge'])): ?>
                <p class="error">
                    <?= escapar($errors['missatge']) ?>
                </p>
            <?php endif; ?>

            <!-- 
                $enviat: Variable booleana definida al controlador.
                Si és true, significa que el procés d'enviament ha finalitzat correctament.
                class="correcte": Aplica l'estil visual d'èxit.
                role="status": Permet identificar el missatge com una informació d'estat per a tecnologies d'assistència.
            -->
            <?php if ($enviat): ?>
                <p class="correcte" role="status">
                    Enviat correctament
                </p>
            
            <!-- 
                elseif: Comprova una segona condició si la primera no s'ha complert.
                !== '': Comprova que el missatge d'error d'enviament no sigui una cadena buida.
                Mostrem l'error produït durant el procés d'enviament del correu.
                role="alert": Identifica el contingut com un avís important per a tecnologies d'assistència.
            -->
            <?php elseif ($errorEnviament !== ''): ?>
                <p class="error" role="alert">
                    <?= escapar($errorEnviament) ?>
                </p>
            <?php endif; ?>

            <!-- 
                button: Crea un botó interactiu.
                type="submit": En prémer-lo, el navegador envia les dades del formulari a la URL indicada a l'atribut action.
            -->
            <button type="submit">
                Enviar correu
            </button>
        </form>
    </main>
</body>
</html>
