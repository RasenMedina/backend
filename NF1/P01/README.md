# P01 — Formulari de contacte amb PHP i PHPMailer

## Descripció

En aquesta primera pràctica de Backend he creat un formulari de contacte amb PHP que permet introduir un nom, una adreça de correu electrònic i un missatge.

Quan l'usuari envia el formulari, les dades es validen al servidor. Si hi ha algun error, es mostra un missatge indicant què s'ha de corregir i es conserven els valors introduïts. Si les dades són correctes, el formulari envia un correu electrònic utilitzant la llibreria PHPMailer i el protocol SMTP.

També he separat la lògica PHP de la vista HTML i he aplicat uns estils CSS amb colors blau, blanc i gris, inspirats en el projecte RAS Football.

## Objectius de la pràctica

- Crear un formulari HTML amb els camps nom, correu electrònic i missatge.
- Recollir les dades enviades mitjançant el mètode `POST`.
- Validar les dades amb PHP abans de processar-les.
- Mostrar missatges d'error quan algun camp sigui incorrecte.
- Mantenir les dades introduïdes si la validació falla.
- Evitar que el contingut HTML introduït per l'usuari s'interpreti en mostrar-lo.
- Separar el controlador, la vista i les funcions.
- Enviar correus electrònics amb PHPMailer mitjançant SMTP.
- Mostrar un missatge de confirmació quan l'enviament es completa correctament.

## Estructura del projecte

```text
P01/
├── README.md
├── index.php
├── index.vista.php
├── funcions.php
├── estils.css
├── config.php.example
├── config.php
└── PHPMailer/
    ├── PHPMailer.php
    ├── SMTP.php
    └── Exception.php
```

**Funció de cada fitxer:**

- `index.php`: és el controlador principal. Rep les dades del formulari, comprova les validacions i gestiona el resultat de l'enviament.
- `index.vista.php`: conté l'estructura HTML del formulari i mostra els missatges d'error o de confirmació.
- `funcions.php`: conté les funcions per escapar dades, validar el formulari i enviar el correu amb PHPMailer.
- `estils.css`: defineix l'aparença visual del formulari.
- `config.php.example`: és una plantilla amb les dades necessàries per configurar el servidor SMTP.
- `config.php`: conté la configuració SMTP privada. Aquest fitxer es crea localment i està exclòs de Git.
- `PHPMailer/`: conté els fitxers de la llibreria externa utilitzada per enviar correus electrònics.

Dins de la carpeta `PHPMailer`, els tres fitxers principals són:

- `PHPMailer.php`: prepara el missatge i coordina l'enviament.
- `SMTP.php`: gestiona la comunicació amb el servidor de correu.
- `Exception.php`: defineix una classe d'excepcions que permet gestionar determinats errors de PHPMailer.

## Validació del formulari

Les validacions es fan al servidor amb PHP, sense dependre únicament dels atributs HTML.

Es comprova que:

- El nom no estigui buit i no superi els 100 caràcters.
- El correu electrònic no estigui buit i tingui un format vàlid.
- El missatge no estigui buit i no superi els 5.000 caràcters.

Per validar el correu utilitzo `filter_var()` amb `FILTER_VALIDATE_EMAIL`.

Si hi ha errors, es mostren al formulari i es mantenen les dades introduïdes perquè l'usuari no les hagi de tornar a escriure.

Per mostrar les dades de manera segura a la vista, utilitzo `htmlspecialchars()` a través de la funció `escapar()`. Això evita que les etiquetes HTML introduïdes per l'usuari s'interpretin com a codi HTML quan es mostren.

## Enviament de correus amb PHPMailer

Per enviar els correus he utilitzat PHPMailer, una llibreria externa de PHP.

El formulari envia el missatge mitjançant un servidor SMTP. En les proves he utilitzat Gmail amb el port `587` i xifratge STARTTLS.

El compte configurat a SMTP s'utilitza com a remitent, mentre que el correu introduït per l'usuari s'afegeix com a adreça de resposta (`Reply-To`).

Així, els missatges arriben a l'adreça configurada com a destinatària i es poden respondre des del gestor de correu.

El contingut del missatge s'envia com a text pla.

## Execució en local

Per executar la pràctica cal tenir instal·lat XAMPP o un entorn equivalent amb PHP.

1. Col·locar el projecte dins de la carpeta `htdocs` de XAMPP.
2. Iniciar **Apache** des del panell de control de XAMPP.
3. Obrir el formulari al navegador:

   `http://localhost/PractiquesPHP/Backend/NF1/P01/`

4. Omplir els camps del formulari i comprovar les validacions.

No és necessari iniciar MySQL, ja que aquesta pràctica no utilitza cap base de dades.

### Configuració del correu SMTP

Per poder enviar correus reals, cal crear el fitxer `config.php` a partir de la plantilla `config.php.example`.

La configuració segueix aquesta estructura:

```php
<?php

return [
    'host' => 'smtp.gmail.com',
    'port' => 587,
    'usuari' => 'el_teu_correu@gmail.com',
    'contrasenya' => 'CONTRASENYA_D_APLICACIO',
    'destinatari' => 'el_teu_correu@gmail.com',
];
```

En el cas de Gmail, es pot utilitzar una contrasenya d'aplicació si el compte permet aquesta opció.

**Important:** el fitxer `config.php` conté informació privada i no es puja a GitHub. Només es comparteix la plantilla `config.php.example`, sense credencials reals.

## Proves realitzades

He comprovat el funcionament del formulari amb diferents situacions:

- Enviar el formulari amb camps buits.
- Introduir una adreça de correu amb un format incorrecte.
- Comprovar que els missatges d'error apareixen al camp corresponent.
- Verificar que els valors introduïts es conserven quan hi ha errors.
- Introduir etiquetes HTML i comprovar que es mostren com a text.
- Enviar missatges amb dades correctes.
- Comprovar que apareix el missatge **«Enviat correctament»**.
- Confirmar que els correus arriben a Gmail mitjançant PHPMailer.

Les proves s'han realitzat en local amb XAMPP.

## Conceptes treballats

Durant aquesta pràctica he treballat principalment:

- Formularis HTML i mètode `POST`.
- Variables superglobals `$_POST` i `$_SERVER`.
- Arrays associatius i funcions en PHP.
- Condicionals i validació de dades.
- Funcions com `trim()`, `filter_var()`, `mb_strlen()` i `htmlspecialchars()`.
- Separació entre lògica i vista.
- Inclusió de fitxers amb `include`, `require` i `require_once`.
- Introducció a les classes i els objectes amb PHPMailer.
- Gestió d'excepcions amb `try` i `catch`.
- Configuració i enviament de correus amb SMTP.
- Ús de Git i GitHub per controlar els canvis del projecte.

## Resultat

La pràctica està acabada i he comprovat que el formulari valida les dades, conserva els valors quan hi ha errors i envia correctament els missatges amb PHPMailer.

Aquesta activitat m'ha servit per entendre millor com es processen els formularis amb PHP, com separar el codi en diferents fitxers i com utilitzar una llibreria externa per afegir funcionalitats a una aplicació web.