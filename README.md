# Desenvolupament web en entorn servidor — DAW2

Repositori de pràctiques de l'assignatura **M0613 — Desenvolupament web en entorn servidor**, del segon curs del cicle formatiu de grau superior de **Desenvolupament d'Aplicacions Web (DAW)**.

## Objectiu

Aquest repositori recull les pràctiques i els exercicis que vaig fent durant el curs per aprendre PHP i el desenvolupament d'aplicacions web en entorn servidor.

L'objectiu és posar en pràctica els conceptes treballats a classe, entendre com funciona el codi i anar millorant l'organització dels projectes.

Cada pràctica té la seva pròpia carpeta i un fitxer `README.md` on explico els objectius, l'estructura dels fitxers, els conceptes treballats i les instruccions per executar-la.

També utilitzo Git i GitHub per guardar els canvis i poder consultar l'evolució de cada activitat.

## Entorn de treball

Les eines i tecnologies que utilitzo són:

- **Llenguatges:** PHP, HTML i CSS.
- **Editor:** Visual Studio Code.
- **Servidor local:** XAMPP amb Apache.
- **Base de dades:** MySQL/MariaDB, quan la pràctica ho requereixi.
- **Control de versions:** Git i GitHub.
- **Llibreries:** PHPMailer per a l'enviament de correus electrònics.

## Organització del repositori

```text
Backend/
├── README.md
├── .gitignore
└── NF1/
    ├── apuntsClasse/
    ├── P01/
    │   └── README.md
    ├── P02/
    │   └── README.md
    └── P03/
        └── README.md
```

- `README.md`: informació general del repositori.
- `.gitignore`: indica quins fitxers no s'han de pujar a GitHub, com ara configuracions privades i fitxers temporals.
- `NF1/`: conté les activitats del primer nucli formatiu.
- `apuntsClasse/`: apunts i exemples treballats a classe.
- `P01/`, `P02/` i `P03/`: carpetes de les diferents pràctiques.

L'estructura s'anirà ampliant a mesura que treballem nous continguts i activitats.

## Estat de les pràctiques

| Pràctica | Tema | Estat |
| --- | --- | --- |
| [P01](NF1/P01/README.md) | Formulari de contacte amb PHP, validacions i PHPMailer | Completada i provada |
| [P02](NF1/P02/README.md) | Pendent de revisar l'enunciat oficial | Pendent de revisió |
| [P03](NF1/P03/README.md) | Pendent de revisar l'enunciat oficial | Pendent de revisió |

### P01 — Formulari de contacte amb PHP i PHPMailer

En aquesta pràctica he creat un formulari amb els camps nom, correu electrònic i missatge.

El formulari valida les dades amb PHP, mostra els errors quan algun camp és incorrecte i conserva els valors introduïts perquè l'usuari els pugui corregir.

També he separat la lògica PHP de la vista HTML i he utilitzat PHPMailer per enviar els missatges mitjançant SMTP.

He comprovat el funcionament de les validacions i l'enviament real de correus amb Gmail des de l'entorn local de XAMPP.

La pràctica utilitza uns estils CSS amb colors blau, blanc i gris, inspirats en el projecte RAS Football.

La documentació completa es troba al [README de la P01](NF1/P01/README.md).

### P02 i P03

Aquestes pràctiques estan pendents de revisar segons els enunciats oficials.

Els fitxers i les explicacions de cada activitat s'aniran actualitzant a mesura que avanci el treball.

## Com executar les pràctiques

Per executar els projectes en local utilitzo XAMPP.

1. Instal·lar XAMPP i tenir PHP disponible.
2. Situar el repositori a la carpeta:

   `C:\xampp\htdocs\PractiquesPHP\Backend\`

3. Iniciar **Apache** des del panell de control de XAMPP.
4. Obrir al navegador la ruta de la pràctica que es vulgui executar.

Per exemple, per accedir a la P01:

`http://localhost/PractiquesPHP/Backend/NF1/P01/`

5. Iniciar MySQL/MariaDB només si la pràctica necessita una base de dades.
6. Consultar el `README.md` de cada pràctica per comprovar si cal alguna configuració addicional.

### Configuracions privades

Algunes pràctiques necessiten dades de configuració, com ara credencials per connectar-se a un servidor SMTP.

Aquestes dades es guarden en fitxers locals que no es pugen a GitHub.

Per exemple, la P01 inclou el fitxer `config.php.example`, que serveix de plantilla per crear el fitxer privat `config.php`.

El `.gitignore` evita que aquest fitxer de configuració privat s'afegeixi accidentalment al repositori, sempre que no estigui versionat prèviament.

## Criteris de treball

Durant les pràctiques intento seguir aquests criteris:

- Separar la lògica PHP de la vista HTML quan sigui possible.
- Organitzar el codi en diferents fitxers segons la seva funció.
- Afegir comentaris que m'ajudin a entendre el funcionament del codi.
- Validar les dades rebudes dels formularis des del servidor.
- Mostrar les dades de manera segura per evitar que s'interpreti codi HTML introduït per l'usuari.
- No publicar contrasenyes ni altres dades privades.
- Utilitzar Git amb missatges de commit que expliquin els canvis realitzats.
- Provar les funcionalitats abans de donar una pràctica per acabada.
- Revisar els requisits dels enunciats de cada activitat.

## Autoria

**Rasen Medina** — Alumne de 2n de DAW.

Repositori acadèmic per guardar les pràctiques i seguir el meu aprenentatge en desenvolupament web en entorn servidor.