<?php
/*
 * FITXER: Exception.php
 * 
 * Aquest fitxer forma part de la llibreria externa PHPMailer.
 * Defineix una classe d'excepcions que hereta de la classe Exception pròpia de PHP i permet gestionar errors
 * relacionats amb el funcionament de PHPMailer.
 * 
 * FUNCIÓ DINS DE LA NOSTRA PRÀCTICA:
 * La funció enviarCorreu(), definida a funcions.php, utilitza un bloc try/catch per capturar possibles
 * excepcions durant la configuració i l'enviament del correu.
 * 
 * Si es produeix una excepció de PHPMailer, podem consultar el missatge d'error, registrar-lo al servidor i retornar
 * false per indicar que l'operació no s'ha completat.
 * 
 * RELACIÓ AMB ELS ALTRES FITXERS:
 * PHPMailer.php prepara el missatge i coordina l'enviament.
 * SMTP.php gestiona la comunicació amb el servidor SMTP.
 * Exception.php defineix un tipus d'excepció utilitzat per comunicar determinats errors de la llibreria.
 * 
 * IMPORTANT:
 * Aquest fitxer no és codi propi de la pràctica.
 * Conservem el codi original de la llibreria i les dades dels seus autors i de la seva llicència.
*/

/**
 * PHPMailer Exception class.
 * PHP Version 5.5.
 *
 * @see       https://github.com/PHPMailer/PHPMailer/ The PHPMailer GitHub project
 *
 * @author    Marcus Bointon (Synchro/coolbru) <phpmailer@synchromedia.co.uk>
 * @author    Jim Jagielski (jimjag) <jimjag@gmail.com>
 * @author    Andy Prevost (codeworxtech) <codeworxtech@users.sourceforge.net>
 * @author    Brent R. Matzelle (original founder)
 * @copyright 2012 - 2020 Marcus Bointon
 * @copyright 2010 - 2012 Jim Jagielski
 * @copyright 2004 - 2009 Andy Prevost
 * @license   http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 * @note      This program is distributed in the hope that it will be useful - WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE.
 */

namespace PHPMailer\PHPMailer;

/**
 * PHPMailer exception handler.
 *
 * @author Marcus Bointon <phpmailer@synchromedia.co.uk>
 */
class Exception extends \Exception
{
    /**
     * Prettify error message output.
     *
     * @return string
     */
    public function errorMessage()
    {
        return '<strong>' . htmlspecialchars($this->getMessage()) . "</strong><br />\n";
    }
}
