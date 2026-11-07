# P01 — Creació d'un formulari amb PHP

## Objectiu

Crear un formulari de contacte amb els camps **nom**, **correu electrònic** i **missatge**, i processar-lo amb PHP. L'activitat serveix per practicar el tractament de dades rebudes per POST, les validacions al servidor i la separació entre lògica i vista.

## Requisits de la pràctica

- Crear el formulari en HTML i aplicar-hi estils CSS.
- Comprovar que els camps no siguin buits i que el correu tingui un format vàlid.
- Mostrar els errors corresponents quan les dades siguin incorrectes.
- Conservar els valors introduïts si cal corregir algun camp.
- Evitar la interpretació de contingut HTML introduït per l'usuari en mostrar-lo.
- Mostrar **«Enviat correctament»** quan l'enviament s'hagi completat.
- Integrar PHPMailer per enviar el missatge mitjançant SMTP.
- Separar la lògica PHP de la vista HTML i comentar el codi.

## Conceptes que treballo

`form`, `action`, `method="POST"`, `name`, `$_POST`, `$_SERVER`, `isset()`, `trim()`, `filter_var()`, `FILTER_VALIDATE_EMAIL`, `htmlspecialchars()`, condicionals, arrays d'errors, `include`/`require` i PHPMailer.

## Estructura prevista

```text
P01/
├── README.md
├── index.php           # Controlador i validacions
├── index.vista.php     # Formulari i missatges
├── estils.css          # Estils visuals
├── mailer.php          # Enviament amb PHPMailer
├── config.exemple.php  # Plantilla de configuració SMTP
└── PHPMailer/          # Biblioteca per enviar correu
```

L'estructura descriu l'organització prevista; els fitxers s'aniran afegint i revisant durant la pràctica.

## Execució local

1. Col·locar la carpeta a `C:\xampp\htdocs\PractiquesPHP\Backend\NF1\P01`.
2. Iniciar **Apache** a XAMPP.
3. Obrir `http://localhost/PractiquesPHP/Backend/NF1/P01/`.
4. Provar el formulari amb camps buits, correu incorrecte i dades vàlides.
5. Per provar l'enviament real, configurar SMTP en un fitxer local exclòs de Git.

**Important:** No cal activar MySQL per a aquesta pràctica.

## Seguiment

- [ ] Revisar el formulari HTML i els estils.
- [ ] Entendre i provar les validacions PHP.
- [ ] Comprovar que els valors es conserven quan hi ha errors.
- [ ] Revisar l'escapament de les dades mostrades en HTML.
- [ ] Configurar i provar PHPMailer.
- [ ] Revisar els requisits del professor i preparar el lliurament.

## Observacions

Aquest README documenta el treball i l'aprenentatge de la pràctica. El codi i els resultats es revisaran abans de marcar l'activitat com a finalitzada.
