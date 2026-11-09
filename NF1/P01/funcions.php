<?php
/**
 * FITXER: funcions.php
 *
 * Aquest fitxer conté les funcions reutilitzables que necessita el controlador del formulari de contacte.
 * Les funcions permeten agrupar instruccions que realitzen una tasca concreta.
 * D'aquesta manera, evitem repetir codi i mantenim el controlador index.php més ordenat i llegible.
 *
 * El formulari permet introduir:
 * - Nom de l'usuari.
 * - Adreça de correu electrònic.
 * - Missatge de contacte.
 *
 * FUNCIONS PRINCIPALS:
 *
 * 1. escapar():
 *    Converteix caràcters especials en entitats HTML
 *    quan volem mostrar informació a la pàgina.
 *
 * 2. validarFormulari():
 *    Comprova que les dades introduïdes per l'usuari
 *    compleixin les regles de validació.
 *
 * 3. enviarCorreu():
 *    Configura PHPMailer i intenta enviar el correu
 *    electrònic mitjançant un servidor SMTP.
 *
 * ARQUITECTURA:
 * Funcions de suport del controlador.
 * Separació de responsabilitats inspirada en MVC.
 *
 * DEPENDÈNCIES:
 * - index.php: crida les funcions d'aquest fitxer.
 * - index.vista.php: utilitza escapar().
 * - PHPMailer/: conté la biblioteca per enviar correus.
 * - config.php: proporciona les dades de configuració SMTP al controlador, que les passa a enviarCorreu().
 * 
 * IMPORTANT:
 * Aquest fitxer no genera directament una pàgina HTML. Defineix funcions que altres fitxers poden utilitzar.
 */

// 1. IMPORTEM LES CLASSES NECESSÀRIES DE PHPMAILER
/*
 * use: Permet referenciar una classe utilitzant un nom més curt.
 * PHPMailer\PHPMailer: És l'espai de noms (namespace) on es troben les classes de la biblioteca PHPMailer.
 * Un namespace serveix per organitzar classes i evitar conflictes entre noms.
 * Amb aquesta instrucció podem escriure:
 *  - new PHPMailer()
 * En lloc d'escriure el nom complet:
 *  - new \PHPMailer\PHPMailer\PHPMailer()
 * 
 * IMPORTANT:
 * use NO carrega automàticament el fitxer de la classe. Els fitxers de PHPMailer es carregaran més endavant mitjançant require_once.
*/
use PHPMailer\PHPMailer\PHPMailer;

/* 
 * Importem també la classe Exception de PHPMailer.
 * Aquesta classe representa excepcions que es poden produir durant la configuració o l'enviament del correu.
 * La utilitzarem dins de catch per gestionar possibles errors de PHPMailer.
*/
use PHPMailer\PHPMailer\Exception;

// 2. FUNCIÓ escapar()
/**
 * Converteix els caràcters especials d'una cadena en entitats HTML.
 * S'utilitza quan mostrem dades dins de l'HTML per evitar que determinats textos s'interpretin com a etiquetes o atributs HTML.
 * 
 * PARÀMETRES:
 * @param string $text Text que volem mostrar.
 *
 * RETORN:
 * @return string Text preparat per mostrar en HTML.
 *
 * EXEMPLE:
 * escapar('<b>Hola</b>')
 *
 * Retorna:
 * &lt;b&gt;Hola&lt;/b&gt;
 * 
 * El navegador mostrarà el text <b>Hola</b> en lloc d'interpretar-lo com una etiqueta HTML.
*/ 
function escapar(string $text): string {
    /*
     * htmlspecialchars(): És una funció incorporada de PHP. Converteix alguns caràcters especials en entitats HTML.
     *  < es converteix en &lt;
     *  > es converteix en &gt;
     *  & es converteix en &amp;
     *  " es converteix en &quot;
     * ENT_QUOTES: Indica que també s'han de convertir les cometes simples i dobles.
     * ENT_SUBSTITUTE: Substitueix seqüències de caràcters invàlides en lloc de provocar una cadena buida.
     * El símbol | combina aquestes dues opcions.
     * 'UTF-8': Indica la codificació del text.
    */
    return htmlspecialchars(
        $text,
        ENT_QUOTES | ENT_SUBSTITUTE, 
        'UTF-8'
    );
}

// 3. FUNCIÓ validarFormulari()
/**
 * Comprova que els camps del formulari compleixin les regles de validació establertes.
 * Aquesta funció rep les dades que el controlador ja ha recuperat i preparat.
 * 
 * PARÀMETRES:
 * @param array $dades Array associatiu amb els camps: nom, correu i missatge.
 *
 * RETORN:
 * @return array Array associatiu amb els errors.
 * Si totes les dades són correctes: Retorna un array buit [].
 * Si hi ha errors: Retorna un array amb els missatges corresponents.
 *
 * EXEMPLE:
 * $errors = [
 *     'nom' => 'Has de posar el nom.',
 *     'correu' => 'El correu no és vàlid.'
 * ];
*/
function validarFormulari(array $dades): array {
    // 3.1 Inicialitzem l'array d'errors.
    /*
     * Al principi l'array està buit perquè encara no hem comprovat cap camp.
     * Si detectem errors, els afegirem a aquest array.
    */
    $errors = [];

    // 3.2 Validem el nom
    /*
     * Comprovem si el nom està buit.
     * $dades['nom']: Accedeix al valor del camp nom.
     * Si el camp nom està buit, guardem un error dins de $errors['nom'].
     * mb_strlen(): Retorna la longitud d'una cadena de text tenint en compte caràcters multibyte. És útil quan treballem amb accents, caràcters especials i text UTF-8.
     * > 100: Comprova si el nom supera els 100 caràcters.
     * Si el camp nom és massa llarg, guardem un error dins de $errors['nom'].
    */
    if ($dades['nom'] === '') $errors['nom'] = 'Has de posar el nom.';
    elseif (mb_strlen($dades['nom'], 'UTF-8') > 100) $errors['nom'] = 'El nom és massa llarg.';
    
    // 3.3 Validem el correu electrònic
    /*
     * Comprovem que l'usuari hagi introduït un correu electrònic.
     * Si el camp correu està buit, guardem un error dins de $errors['correu'].
     * filter_var(): És una funció incorporada de PHP que permet validar o filtrar dades.
     * FILTER_VALIDATE_EMAIL: És una constant que indica que volem validar el format d'una adreça de correu.
     * filter_var() retorna el valor validat si el format és correcte, o false si no supera la validació.
     * Si el camp correu no és vàlid, guardem un error dins de $errors['correu'].
     * 
     * IMPORTANT:
     * Aquesta validació no garanteix que l'adreça existeixi ni pugui rebre correus.
    */
    if ($dades['correu'] === '') $errors['correu'] = 'Has de posar el correu.';
    elseif (!filter_var($dades['correu'], FILTER_VALIDATE_EMAIL)) $errors['correu'] = 'El correu no és vàlid.';

    // 3.4 Validem el missatge
    /*
    * Comprovem que el missatge no sigui una cadena buida.
     * Si el camp missatge està buit, guardem un error dins de $errors['missatge'].
     * mb_strlen(): Calcula la longitud del text.    
     * Utilitzem UTF-8 per comptar correctament els caràcters habituals en català.
     * > 5000: Comprova si el missatge és massa llarg.
     * Si el camp missatge és massa llarg, guardem un error dins de $errors['missatge'].
    */
    if ($dades['missatge'] === '') $errors['missatge'] = 'Has de posar el missatge.';
    elseif (mb_strlen($dades['missatge'], 'UTF-8') > 5000) $errors['missatge'] = 'El missatge és massa llarg.';

    // 3.5 Retornem els errors
    /*
     * return: Retorna l'array $errors al controlador.
     * Si l'array està buit, significa que no s'ha detectat cap error.
     * Si conté elements, el controlador no intentarà enviar el correu.
     * La vista utilitzarà aquests missatges per informar l'usuari.
    */
    return $errors;
}

// 4. FUNCIÓ enviarCorreu()
/**
 * Configura PHPMailer i intenta enviar un correu electrònic mitjançant SMTP.
 * 
 * PARÀMETRES:
 * @param array $dades Dades del formulari.
 * @param array $config Configuració del servidor SMTP.
 *
 * RETORN:
 * @return bool true si PHPMailer confirma l'enviament.
 *              false si es produeix un error gestionat.
 *
 * IMPORTANT:
 * Un resultat true indica que PHPMailer ha completat l'operació d'enviament amb el servidor SMTP.
 * No garanteix que el missatge arribi finalment a la safata d'entrada del destinatari.
*/
function enviarCorreu(array $dades, array $config): bool {
    // 4.1 Carreguem els fitxers de PHPMailer
    /*
     * require_once: Carrega els fitxers necessaris de la biblioteca.
     * __DIR__: Indica el directori on es troba funcions.php.
     * Exception.php: Defineix la classe d'excepcions de PHPMailer.
     * PHPMailer.php: Defineix la classe principal per crear i enviar missatges.
     * SMTP.php: Conté la implementació del protocol SMTP utilitzada per PHPMailer.
     * 
     * IMPORTANT:
     * Aquestes rutes corresponen a l'estructura de carpetes actual del nostre projecte.
    */
    require_once __DIR__ . '/PHPMailer/Exception.php';
    require_once __DIR__ . '/PHPMailer/PHPMailer.php';
    require_once __DIR__ . '/PHPMailer/SMTP.php';

    // 4.2 Creem un objecte PHPMailer
    /*
     * new: Permet crear un objecte a partir d'una classe.
     * PHPMailer: És la classe que utilitzem per gestionar la configuració i l'enviament del correu.
     * $mail: És la variable que conté l'objecte creat.
     * true: Indica a PHPMailer que llanci excepcions quan es produeixin determinats errors.
    */
    $mail = new PHPMailer(true);

    // 4.3 Gestionem possibles errors amb try/catch
    /*
     * try: Conté les instruccions que volem executar i que poden provocar una excepció.
     * 
     * isSMTP(): Indica a PHPMailer que utilitzi SMTP com a mecanisme d'enviament.
     * SMTP significa: Simple Mail Transfer Protocol. És un protocol utilitzat per transferir correus electrònics entre sistemes.
     * 
     * Host: Indica l'adreça del servidor SMTP. El valor es recupera de l'array $config. Per exemple: smtp.gmail.com
     * 
     * SMTPAuth: Activa l'autenticació SMTP. 
     * true: Indica que PHPMailer haurà d'identificar-se amb les credencials configurades.
     * 
     * Username: Nom d'usuari del compte SMTP. Normalment és una adreça de correu.
     * 
     * Password: Contrasenya o credencial d'aplicació del compte SMTP.
     * IMPORTANT: Mai no hem d'escriure aquesta credencial directament dins de funcions.php.
     * 
     * SMTPSecure: Configura el mecanisme de seguretat de la connexió SMTP.
     * PHPMailer::ENCRYPTION_STARTTLS: Indica que volem utilitzar STARTTLS.
     * STARTTLS permet passar d'una connexió inicial a una connexió protegida amb TLS, si el servidor ho admet. El servidor ha de tenir una configuració compatible amb aquest mecanisme.
     * 
     * Port: Defineix el port del servidor SMTP.
     * (int): Converteix el valor a un número enter.
     * El port 587 és habitual amb STARTTLS, però cal utilitzar el que indiqui el proveïdor del servei SMTP.
     * 
     * CharSet: Defineix la codificació del missatge.
     * UTF-8: Permet representar correctament accents i altres caràcters.
     * 
     * setFrom(): Defineix l'adreça del remitent i el nom que es mostrarà.
     * $config['usuari']: Utilitzem el compte SMTP autenticat.
     * 'Formulari P01': És el nom visible del remitent. 
     * No utilitzem el correu del visitant com a remitent perquè molts servidors exigeixen una identitat autoritzada.
     * 
     * isHTML(false): Indica que el cos del missatge s'enviarà com a text pla.
     * Així el contingut introduït per l'usuari no es tractarà com a HTML del missatge. Si utilitzéssim isHTML(true), hauríem de construir i escapar adequadament el contingut HTML.
     * 
     * Subject: Defineix l'assumpte del correu. És el text que apareixerà com a títol del missatge al client de correu.
     * 
     * Body: Defineix el contingut principal del correu.
     * Utilitzem cometes dobles perquè PHP pugui incorporar els valors de les variables dins de la cadena.
     * {$dades['nom']}: Insereix el nom de l'usuari.
     * {$dades['correu']}: Insereix el correu de l'usuari
     * {$dades['missatge']}: Insereix el missatge introduït.
     * \n: Representa un salt de línia.
     * \n\n: Representa dos salts de línia, per separar visualment el contingut.
     * 
     * send(): Intenta enviar el missatge utilitzant la configuració establerta.
     * return: Retorna el resultat al controlador.
     *  - Si l'operació funciona, retorna true.
     *  - Si es produeix un error, PHPMailer pot llançar una excepció.
     * index.php guardarà aquest resultat a la variable $enviat.
    */
    try {
        $mail->isSMTP();
        $mail->Host = $config['host'];
        $mail->SMTPAuth = true;
        $mail->Username = $config['usuari'];
        $mail->Password = $config['contrasenya'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = (int)$config['port'];
        $mail->CharSet = 'UTF-8';
        $mail->setFrom($config['usuari'], 'Formulari P01');
        $mail->addAddress($config['destinatari']);
        $mail->addReplyTo($dades['correu'], $dades['nom']);
        $mail->isHTML(false); // Text pla: no interpretem HTML enviat per l'usuari.
        $mail->Subject = 'Nou missatge del formulari P01';
        $mail->Body = "Nom: {$dades['nom']}\nCorreu: {$dades['correu']}\n\n{$dades['missatge']}";
        return $mail->send();       
    } 
    
    /*
     * catch: Captura les excepcions de PHPMailer que es produeixin dins del bloc try.
     * Exception $e: Representa l'objecte de l'excepció capturada.
     * Encara que aquí no utilitzem directament $e, ens permet gestionar l'error sense mostrar els detalls tècnics a l'usuari.
     * 
     * error_log(): És una funció incorporada de PHP.
     * Permet registrar informació d'errors al sistema de registre configurat al servidor.
     * 
     * $mail->ErrorInfo: Conté informació sobre l'error detectat per PHPMailer.
     * Aquesta informació pot ser útil durant el desenvolupament.
     * 
     * IMPORTANT:
     * Els registres poden contenir dades tècniques sensibles. No s'han de publicar.
     * 
     * El punt (.) concatena les dues cadenes.
     * 
     * Si l'enviament ha fallat, retornem false al controlador.
     * D'aquesta manera, index.php podrà mostrar un missatge genèric d'error a l'usuari.
    */
    catch (Exception $e) {
        error_log('PHPMailer: ' . $mail->ErrorInfo);
        return false;
    }
}
