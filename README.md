# Desenvolupament web en entorn servidor — DAW2

Repositori de pràctiques de l'assignatura **M0613 — Desenvolupament web en entorn servidor**, del segon curs del cicle formatiu de grau superior de **Desenvolupament d'Aplicacions Web (DAW)**.

## Objectiu

Aquest repositori recull les pràctiques que vaig desenvolupant durant el curs per aprendre PHP i els fonaments del desenvolupament web al servidor. He començat a posar-me al dia amb algunes activitats més tard del previst; per això, vull conservar cada pràctica en una carpeta independent que reflecteixi què havia implementat i quins coneixements havia adquirit en aquell moment.

A més del resultat final, els commits de Git permeten consultar l'evolució del codi. Cada pràctica disposarà d'un README propi amb els objectius, els fitxers, les instruccions d'execució i les observacions.

## Entorn de treball

- **Llenguatge:** PHP, HTML i CSS.
- **Editor:** Visual Studio Code.
- **Entorn local:** XAMPP (Apache i, quan sigui necessari, MySQL/MariaDB).
- **Control de versions:** Git i GitHub.
- **Eines addicionals:** PHPMailer en les activitats que requereixin enviament de correu.

## Organització

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

L'estructura pot créixer amb altres nuclis formatius i activitats. Els fitxers de codi de cada pràctica s'afegiran dins de la carpeta corresponent.

## Estat de les pràctiques

| Pràctica | Tema | Estat |
| --- | --- | --- |
| [P01](NF1/P01/README.md) | Formulari de contacte amb PHP, validacions i PHPMailer | En desenvolupament i revisió |
| [P02](NF1/P02/README.md) | Pendent de consultar l'enunciat oficial | Pendent |
| [P03](NF1/P03/README.md) | Pendent de consultar l'enunciat oficial | Pendent |

**Nota:** Mentre no tingui accés als enunciats de P02 i P03 al Moodle, podré preparar exercicis basats en els apunts de classe. Aquests exercicis es revisaran posteriorment segons els requisits oficials, sense presentar-los com si ja fossin les pràctiques definitives.

## Com executar les pràctiques

1. Instal·lar i iniciar XAMPP.
2. Situar aquest repositori dins de `C:\xampp\htdocs\PractiquesPHP\Backend`.
3. Activar **Apache** al panell de XAMPP.
4. Obrir al navegador la ruta corresponent, per exemple:

   `http://localhost/PractiquesPHP/Backend/NF1/P01/`

5. Activar MySQL/MariaDB només en les pràctiques que utilitzin base de dades.
6. Consultar el README de cada pràctica per veure si necessita configuració addicional.

## Criteris de treball

- Separar, sempre que sigui possible, la lògica PHP de la vista HTML.
- Comentar el codi per explicar-ne la finalitat.
- Validar les dades rebudes del navegador al servidor.
- Evitar publicar contrasenyes, claus o credencials SMTP.
- Fer commits descriptius per conservar l'evolució de cada activitat.
- Revisar les solucions amb els enunciats oficials abans de donar-les per acabades.

## Autoria

**Rasen Medina** — Alumne de 2n de DAW.

Repositori acadèmic d'aprenentatge i seguiment de pràctiques.
