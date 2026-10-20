# P01 · Formulari de contacte amb PHPMailer

Projecte didàctic MVC simplificat: `index.php` (controlador), `funcions.php` (serveis/validació), `index.vista.php` (vista), `estils.css` (estils).

## Posada en marxa
1. Copia la carpeta a `C:\xampp\htdocs\PractiquesPHP\Backend\NF1\P01`.
2. A XAMPP inicia **Apache**. MySQL no és necessari.
3. Copia `config.php.example` com a `config.php` i configura SMTP (no el pugis a GitHub).
4. Obre `http://localhost/PractiquesPHP/Backend/NF1/P01/`.
5. Prova camps buits, email incorrecte, conservació de valors i enviament SMTP real.

**Important:** el missatge «Enviat correctament» només apareix després que PHPMailer accepti l'enviament. La recepció final depèn del servidor de correu. Per Gmail, normalment cal verificació en dos passos i contrasenya d'aplicació o una configuració OAuth adequada. Mai facis servir la contrasenya habitual del compte en un repositori.

## Diferència respecte de la solució del professor
El professor presenta `index.php` + `index.vista.php`; aquí s'afegeix `funcions.php` per separar millor responsabilitats. El seu exemple conté referències de variables inconsistents i mostra un èxit sense confirmar adequadament el resultat SMTP; aquesta versió ho corregeix.
