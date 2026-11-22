<?php
/**
 * FITXER: index.php
 *
 * Aquest fitxer representa el CONTROLADOR del formulari de contacte.
 * El controlador s'encarrega de gestionar la lògica del formulari de contacte. 
 * És a dir, rep les dades introduïdes per l'usuari (POST), les prepara, comprova que siguin correctes i, si no hi ha errors, intenta enviar el correu electrònic amb PHPMailer.
 *
 * RESPONSABILITATS DEL CONTROLADOR:
 * 1. Carregar les funcions necessàries.
 * 2. Inicialitzar les variables del formulari.
 * 3. Comprovar si s'ha enviat el formulari amb POST.
 * 4. Recuperar i preparar les dades introduïdes.
 * 5. Validar les dades i guardar els possibles errors.
 * 6. Comprovar que existeix la configuració SMTP.
 * 7. Intentar enviar el correu si les dades són correctes.
 * 8. Preparar els missatges que mostrarà la vista.
 * 9. Carregar el fitxer index.vista.php.
 *
 * ARQUITECTURA:
 * Separació entre controlador i vista (inspirada en MVC).
 *
 * DEPENDÈNCIES:
 * - funcions.php: conté les funcions de validació, escapament HTML i enviament de correus.
 * - config.php: conté la configuració privada del correu SMTP.
 * - index.vista.php: mostra el formulari i els resultats.
 *
 * IMPORTANT:
 * Aquest fitxer és el punt d'entrada principal de la pràctica.
 * El navegador accedeix a index.php, que executa la lògica i finalment carrega la vista.
 */

// 1. CARREGUEM LES FUNCIONS NECESSÀRIES
/*
 * require_once: Permet incorporar el contingut d'un altre fitxer PHP.
 * require: Si el fitxer no existeix, PHP produeix un error i interromp l'execució.
 * _once: Evita carregar el mateix fitxer més d'una vegada durant la mateixa execució.
 * __DIR__: És una constant màgica de PHP que conté la ruta absoluta del directori on es troba aquest fitxer. Així la ruta funciona independentment del directori des d'on s'executi el programa.
 * El punt (.) és l'operador de concatenació de PHP. Serveix per unir cadenes de text.
*/
require_once __DIR__ . '/funcions.php';


// 2. INICIALITZEM LES VARIABLES DEL FORMULARI
/* 
 * $dades: És un array associatiu que conté els valors dels camps del formulari. 
 * Un array associatiu guarda informació en parelles de CLAU => VALOR.
 * - 'nom' és la clau del nom de l'usuari.
 * - 'correu' és la clau del correu electrònic.
 * - 'missatge' és la clau del missatge.
 * Inicialment tots els camps tenen una cadena buida (''), perquè l'usuari encara no ha introduït informació.
 * Aquestes claus han de coincidir amb els atributs name dels camps del formulari HTML.
 * La vista utilitzarà aquest array per mostrar els valors introduïts i conservar-los si es produeix algun error.
 */
$dades = [
    'nom' => '',
    'correu' => '',
    'missatge' => ''
];

/*
 * $errors: És un array que guardarà els errors de validació.
 * Inicialment està buit perquè encara no s'han comprovat les dades del formulari.
 * Si hi ha errors, podria contenir:
 * $errors = [
 *     'nom' => 'Has d'introduir el nom.',
 *     'correu' => 'El correu no és vàlid.'
 * ];
 * La vista consultarà aquest array per mostrar els errors al costat del camp corresponent.
*/
$errors = [];

/*
 * $enviat: És una variable booleana.
 * Inicialment és false perquè encara no s'ha enviat cap correu electrònic.
 * Només passarà a true si la funció enviarCorreu() retorna que l'enviament s'ha completat correctament.
*/
$enviat = false;

/*
 * $errorEnviament: Guarda un missatge d'error relacionat amb el procés d'enviament del correu electrònic.
 * Inicialment és una cadena buida perquè encara no s'ha produït cap error.
*/
$errorEnviament = '';

// 3. COMPROVEM SI S'HA ENVIAT EL FORMULARI
/*
 * $_SERVER: És una variable superglobal de PHP. 
 * Les variables superglobals estan disponibles des de diferents àmbits del programa sense haver de declarar-les com a globals.
 * $_SERVER conté informació sobre el servidor i la petició HTTP que s'està processant.
 * $_SERVER['REQUEST_METHOD']: Indica quin mètode HTTP s'ha utilitzat.
 * Alguns mètodes habituals són:
 * - GET: habitualment per consultar informació.
 * - POST: habitualment per enviar dades al servidor.
 * Amb aquest if només processem les dades quan el formulari s'ha enviat amb POST.
*/
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // 4. RECUPEREM I PREPAREM LES DADES DEL FORMULARI
    /*
     * foreach: És una estructura repetitiva de PHP. Permet recórrer els elements d'un array. 
     * $camp: Guarda la clau de cada element.
     * En cada iteració tindrà un valor diferent:
     * - Primera iteració: 'nom'.
     * - Segona iteració: 'correu'.
     * - Tercera iteració: 'missatge'.
     * $_: És una variable que rep el valor de l'element, però que no utilitzarem.
     * 
    */
    foreach ($dades as $camp => $_) {
        /*
        * $_POST: És una variable superglobal que conté les dades enviades amb el mètode POST des d'un formulari.
        * $_POST[$camp]: Accedeix al valor del camp actual del foreach.
        * ??:
        *  - Si $_POST[$camp] existeix i no és null, utilitza aquest valor.
        *  - Si no existeix o és null, utilitza una cadena buida ('').
        */    
        $valor = $_POST[$camp] ?? '';

        /*
         * is_string(): Comprova si el valor rebut és una cadena de text.
         * * ? ... : ...:
         *  - Si $valor és una cadena de text: executem trim($valor).
         *  - Si $valor no és una cadena de text: guardem una cadena buida.
         * Finalment guardem el valor preparat dins de l'array $dades.
        */
        $dades[$camp] = is_string($valor) ? trim($valor) : '';
    }

    // 5. VALIDEM LES DADES INTRODUÏDES
    /*
     * validarFormulari(): És una funció definida al fitxer funcions.php.
     * La seva responsabilitat és comprovar que els camps compleixin les regles establertes.
     *  - Que el nom no estigui buit.
     *  - Que el correu tingui un format correcte.
     *  - Que el missatge contingui text vàlid.
     * La funció retorna un array d'errors.
    */
    $errors = validarFormulari($dades);

    // 6. COMPROVEM SI HI HA ERRORS DE VALIDACIÓ
    /*
     * En PHP, un array buit es considera false quan s'avalua com a condició booleana.
     *  - Si $errors = []; !$errors serà true.
     *  - Si $errors conté algun error: !$errors serà false.
     * Alternativa: if (empty($errors))
     * Només intentarem enviar el correu quan no hi hagi errors de validació.
    */
    if (!$errors) {
        
        // 7. LOCALITZEM LA CONFIGURACIÓ DEL CORREU
        /*
         * $rutaConfig: Guarda la ruta absoluta del fitxer config.php.
         * config.php: Conté la configuració SMTP, com ara el servidor, el compte de correu i les credencials d'autenticació.
         * __DIR__: Directori actual del fitxer index.php.
         * . '/config.php': Afegeix el nom del fitxer a la ruta. (ha de quedar exclòs de Git si conté contrasenyes o dades privades.)
        */
        $rutaConfig = __DIR__ . '/config.php';


        // 8. COMPROVAR QUE EXISTEIX EL FITXER config.php
        /*
         * is_file(): Comprova si la ruta indicada correspon a un fitxer existent.
         * !is_file($rutaConfig): Significa que el fitxer no existeix o que la ruta no correspon a un fitxer normal.
         * Si falta config.php, no podem intentar enviar el correu amb la configuració esperada.
         * Guardem un missatge d'error perquè la vista pugui informar del problema. No interrompem tota l'aplicació, El formulari continuarà mostrant-se.
        */
        if (!is_file($rutaConfig)) {
            $errorEnviament = 'Falta configurar el correu (config.php).';
        }

        /* config.php correcte */
        else {

            // 9. CARREGUEM LA CONFIGURACIÓ SMTP
            /*
            * require: Executa i incorpora un fitxer PHP.
            * config.php ha de retornar un array amb les dades de configuració, com per exemple:
            *  - return [
            *     'host' => 'smtp.gmail.com',
            *     'port' => 587
            *    ];
            * El valor retornat pel fitxer es guarda a la variable $config.
            */
            $config = require $rutaConfig;

            // 10. INTENTEM ENVIAR EL CORREU
            /*
             * enviarCorreu(): És una funció definida a funcions.php. Utilitza PHPMailer per intentar realitzar l'enviament.
             *  - true: si l'enviament ha funcionat.
             *  - false: si l'enviament ha fallat.
            */
            $enviat = enviarCorreu($dades, $config);

            // 11. COMPROVEM EL RESULTAT DE L'ENVIAMENT
            /*
             * Si $enviat és true, Reinicialitzem l'array $dades: Tots els camps tornen a quedar buits.
             * Si hi ha errors de validació o falla l'enviament, conservarem les dades perquè l'usuari no les hagi de repetir.
             * La vista mostrarà el missatge "Enviat correctament" perquè $enviat té el valor true.
            */
            if ($enviat) {
                // Buidem els camps després d'un enviament realment correcte.
                $dades = ['nom' => '', 'correu' => '', 'missatge' => ''];
            } 
            
            /*
             * Si enviarCorreu() retorna false, guardem un missatge d'error.
             * La vista mostrarà aquest error a l'usuari i conservarà les dades.
            */
            else {
                $errorEnviament = 'No ha estat possible enviar el correu. Revisa la configuració SMTP.';
            } // Final de la comprovació de l'enviament.
        } // Final de la comprovació de config.php.
    } // Final de la comprovació dels errors de validació.
} // Final del processament de la petició POST.

// CARREGUEM LA VISTA DEL FORMULARI
/*
 * require: Incorpora el fitxer index.vista.php.
 * La vista conté el codi HTML del formulari i els fragments de PHP necessaris per mostrar les dades i els missatges.
 * Com que el fitxer s'inclou des del controlador, pot accedir a les variables definides anteriorment: $dades, $errors, $enviat, $errorEnviament
 * Per això inicialitzem aquestes variables abans de carregar la vista.
 * 
 * La vista només presenta la informació.
 * Les validacions i l'enviament del correu es gestionen des del controlador i les funcions.
 * 
 * Si la petició és GET: Mostra el formulari inicial.
 * Si la petició és POST: Mostra el formulari amb els valors, errors o resultat de l'enviament.
 * 
 * En aquesta pràctica preparem les dades al controlador, les validem amb una funció i les escapem qual les mostrem a la vista
*/
require __DIR__ . '/index.vista.php';
