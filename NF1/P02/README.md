# P02 — Connexions PDO i gestió de jugadors

## Projecte RAS Football

**Pràctica:** P02 — Connexions PDO  
**Assignatura:** Desenvolupament Web en Entorn Servidor (DAW)  
**Alumne:** Rasen Medina  
**Tecnologies:** PHP, MySQL, PDO, HTML, CSS i phpMyAdmin

## 1. Descripció

En aquesta pràctica treballem la connexió entre PHP i una base de dades MySQL utilitzant PDO (*PHP Data Objects*).

Hem desenvolupat una aplicació de gestió de jugadors de futbol, anomenada **RAS Football**, seguint una estructura basada en el patró MVC (*Model-Vista-Controlador*).

L'aplicació permet consultar, afegir, modificar i eliminar jugadors.

## 2. Objectius

- Crear una base de dades MySQL.
- Connectar PHP amb MySQL mitjançant PDO.
- Utilitzar consultes SQL preparades (*prepared statements*).
- Recuperar i mostrar informació de la base de dades.
- Implementar les operacions CRUD.
- Separar la lògica, les dades i la presentació amb MVC.
- Validar les dades dels formularis.
- Aplicar mesures bàsiques de seguretat.

## 3. Base de dades

La base de dades utilitzada és `Pt02_Rasen_Medina`.

El fitxer `database/Pt02_Rasen_Medina.sql` conté les instruccions per crear la base de dades i les quatre taules:

| Taula | Finalitat |
|---|---|
| `equips` | Emmagatzema els equips de futbol. |
| `jugadors` | Emmagatzema les dades dels jugadors. |
| `entrenadors` | Emmagatzema els entrenadors. |
| `users` | Defineix l'estructura dels usuaris per a futures funcionalitats. |

La taula `jugadors` es relaciona amb `equips` mitjançant la clau forana `equip_id`.

La taula `users` està creada, però en aquesta fase no hem implementat el registre ni l'inici de sessió.

## 4. Estructura del projecte

Els fitxers principals de la pràctica són:

```text
P02/
├── css/
│   └── estils.css
├── database/
│   ├── connexio.php
│   ├── prova_connexio.php
│   └── Pt02_Rasen_Medina.sql
├── gestio/
│   ├── config/
│   │   └── connexio.php
│   ├── controllers/
│   │   └── JugadorController.php
│   ├── models/
│   │   └── JugadorModel.php
│   ├── views/
│   │   └── jugadors.vista.php
│   └── index.php
├── PHPMailer/
├── config.php.example
├── funcions.php
├── index.php
├── index.vista.php
└── README.md
```

## 5. Funcionament del patró MVC

### Model

El fitxer `gestio/models/JugadorModel.php` conté les funcions que interactuen amb la base de dades mitjançant PDO.

S'encarrega de consultar, inserir, actualitzar i eliminar registres.

### Vista

El fitxer `gestio/views/jugadors.vista.php` genera la interfície HTML.

Mostra el llistat de jugadors, els formularis i els missatges de confirmació o error.

### Controlador

El fitxer `gestio/controllers/JugadorController.php` processa les peticions del navegador.

Recupera i valida les dades dels formularis, crida les funcions del model i prepara la informació que necessita la vista.

### Punt d'entrada

El fitxer `gestio/index.php` inicia la sessió, prepara el token CSRF i carrega el controlador.

## 6. Operacions CRUD implementades

| Operació | Funcionalitat | Estat |
|---|---|---|
| CREATE | Afegir un jugador nou | Implementada i provada |
| READ | Mostrar els jugadors i els seus equips | Implementada i provada |
| UPDATE | Modificar les dades d'un jugador | Implementada i provada |
| DELETE | Eliminar un jugador | Implementada i provada |

Les operacions utilitzen PDO i consultes preparades.

Després de crear, modificar o eliminar un jugador correctament, l'aplicació redirigeix el navegador i mostra un missatge de confirmació.

## 7. Validació i seguretat

Hem incorporat diverses mesures de seguretat:

- Validació dels camps obligatoris.
- Comprovació dels identificadors numèrics.
- Restricció de longitud dels camps.
- Consultes preparades amb PDO per evitar la inserció directa de dades de l'usuari a l'SQL.
- Ús de la funció `escapar()` per mostrar dades de manera segura a l'HTML.
- Protecció CSRF dels formularis de creació, modificació i eliminació.
- Confirmació abans d'eliminar un jugador.
- Registre dels errors tècnics al servidor.

Aquestes mesures formen part de la seguretat bàsica de la pràctica i no substitueixen una auditoria completa de seguretat.

## 8. Execució en local

Per executar la pràctica:

1. Iniciar Apache i MySQL des de XAMPP.
2. Crear la base de dades important el fitxer `database/Pt02_Rasen_Medina.sql` amb phpMyAdmin.
3. Configurar la connexió local amb MySQL.
4. Obrir al navegador:

`http://localhost/PractiquesPHP/Backend/NF1/P02/gestio/`

La configuració local que contingui credencials no s'ha de publicar al repositori.

## 9. Proves realitzades

Hem comprovat que:

- La connexió amb MySQL funciona.
- Es poden recuperar els jugadors de la base de dades.
- Es mostra el nom de l'equip corresponent a cada jugador.
- Es poden inserir jugadors nous.
- Es poden modificar jugadors existents.
- Es poden eliminar jugadors després de confirmar l'acció.
- Els formularis mostren missatges de confirmació.
- El sistema detecta errors com els DNI duplicats.
- Els fitxers PHP revisats superen la comprovació de sintaxi.

## 10. Conclusions

Amb aquesta pràctica hem après a treballar amb bases de dades relacionals des de PHP mitjançant PDO.

També hem aplicat el patró MVC per separar responsabilitats i hem desenvolupat un CRUD funcional de jugadors.

La pràctica representa una nova fase del projecte respecte de la P01, incorporant persistència de dades, consultes SQL i gestió de registres.