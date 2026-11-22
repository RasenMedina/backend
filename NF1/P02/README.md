# P02 — Connexions PDO amb MySQL

## Objectiu

En aquesta pràctica treballo la connexió entre PHP i una base de dades MySQL utilitzant **PDO (PHP Data Objects)**.

És una continuació del projecte iniciat a la P01. La idea és anar ampliant RAS Football amb noves funcionalitats i conservar cada pràctica com una versió del projecte en aquell moment.

L'objectiu principal és aprendre a consultar i gestionar dades des de PHP, utilitzant **Prepared Statements** i separant la lògica de les vistes amb el patró **MVC**.

## Adaptació de la pràctica

L'enunciat original proposa gestionar una taula d'articles. En el meu cas, he adaptat la base de dades a la temàtica de RAS Football, amb l'autorització del professor.

En lloc de treballar amb articles, utilitzaré dades relacionades amb el futbol. Principalment, implementaré les operacions de consulta, inserció, modificació i eliminació de jugadors.

Aquesta adaptació permet treballar els mateixos conceptes de PDO i SQL i, alhora, continuar desenvolupant el projecte.

## Conceptes que treballo

- Creació de bases de dades i taules amb MySQL.
- Gestió de dades des de phpMyAdmin.
- Claus primàries i claus foranes.
- Relacions entre taules.
- Consultes SQL amb `SELECT`, `INSERT`, `UPDATE` i `DELETE`.
- Consultes entre taules amb `JOIN`.
- Connexió a MySQL amb PDO.
- Consultes preparades amb `prepare()` i `execute()`.
- Recuperació de resultats amb `fetchAll()`.
- Gestió d'errors amb `try/catch` i `PDOException`.
- Separació entre model, vista i controlador (MVC).
- Validació de dades i protecció davant d'injeccions SQL.

Alguns d'aquests conceptes ja s'han treballat i d'altres s'aniran incorporant durant el desenvolupament de la pràctica.

## Base de dades

La base de dades s'anomena `pt02_rasen_medina` i conté quatre taules:

| Taula | Funció |
| --- | --- |
| `users` | Emmagatzemar els comptes d'usuari de l'aplicació. |
| `equips` | Guardar la informació dels equips de futbol. |
| `jugadors` | Guardar els jugadors i l'equip al qual pertanyen. |
| `entrenadors` | Guardar els entrenadors i l'equip al qual pertanyen. |

Les taules `jugadors` i `entrenadors` es relacionen amb `equips` mitjançant el camp `equip_id`.

La taula `users` queda preparada per a futures funcionalitats relacionades amb els comptes d'usuari.

L'esquema de la base de dades es guarda a:

`database/Pt02_Rasen_Medina.sql`

Aquest fitxer permet recrear l'estructura de les taules des de phpMyAdmin.

## Organització dels fitxers

La P02 conserva els fitxers de la pràctica anterior i incorpora una carpeta per treballar amb la base de dades.

```text
P02/
├── README.md
├── index.php
├── index.vista.php
├── funcions.php
├── estils.css
├── config.php.example
├── PHPMailer/
├── database/
│   ├── Pt02_Rasen_Medina.sql
│   ├── connexio.php
│   └── prova_connexio.php
└── gestio/
    ├── index.php
    ├── config/
    ├── controllers/
    ├── models/
    └── views/
```

### Fitxers principals

- `database/Pt02_Rasen_Medina.sql`: conté les instruccions SQL per crear la base de dades.
- `database/connexio.php`: defineix la funció `connectarBD()`, que retorna un objecte PDO.
- `database/prova_connexio.php`: comprova la connexió i mostra les taules disponibles.
- `gestio/`: carpeta destinada a implementar la gestió de jugadors seguint MVC.

Els fitxers del formulari de contacte i de PHPMailer es conserven de la P01.

La carpeta `gestio/` encara està en desenvolupament i la seva estructura pot canviar a mesura que avancem.

## Execució local

Per executar la pràctica utilitzo XAMPP.

1. Situar el projecte a `C:\xampp\htdocs\PractiquesPHP\Backend\NF1\P02\`.
2. Iniciar **Apache** i **MySQL** des de XAMPP.
3. Obrir phpMyAdmin a `http://localhost/phpmyadmin/`.
4. Crear la base de dades executant el fitxer `database/Pt02_Rasen_Medina.sql`.
5. Comprovar la connexió PDO obrint:

   `http://localhost/PractiquesPHP/Backend/NF1/P02/database/prova_connexio.php`

Si la connexió funciona, apareix el missatge **«Connexió PDO correcta!»** i els noms de les quatre taules.

La configuració del formulari de contacte es manté separada en un fitxer local `config.php`, que no s'ha de publicar al repositori.

## Proves realitzades

Fins ara he comprovat que:

- [x] La base de dades es crea correctament a phpMyAdmin.
- [x] Les quatre taules existeixen.
- [x] PHP es connecta correctament a MySQL mitjançant PDO.
- [x] Es poden recuperar els noms de les taules amb `prepare()`, `execute()` i `fetchAll()`.
- [x] S'han inserit dos equips i tres jugadors de prova a MySQL.
- [ ] Es poden consultar i mostrar els jugadors des de la interfície PHP.
- [ ] Es poden inserir jugadors des d'un formulari.
- [ ] Es poden modificar jugadors.
- [ ] Es poden esborrar jugadors.
- [ ] Es poden cercar jugadors per DNI.
- [ ] S'ha revisat el funcionament complet de la pràctica.

## Decisions de desenvolupament

He decidit conservar una carpeta independent per a cada pràctica perquè així puc consultar com ha anat evolucionant el projecte.

Per a la base de dades he separat equips, jugadors i entrenadors en diferents taules per evitar repetir informació i poder relacionar els registres mitjançant claus foranes.

També he separat la connexió PDO en un fitxer propi, `connexio.php`, per poder reutilitzar-la en diferents consultes sense haver d'escriure sempre el mateix codi.

Durant la pràctica aniré afegint comentaris als fitxers PHP per entendre què fa cada instrucció i poder repassar-la de cara a l'examen.

## Estat actual

**En desenvolupament.**

La base de dades està creada, la connexió PDO funciona i ja hi ha dades de prova. El següent pas és mostrar els jugadors des de PHP i implementar les operacions CRUD amb Prepared Statements.