<?php
/**
 * PHPMailer SPL autoloader.
 * PHP Version 5
 * @package PHPMailer
 * @link https://github.com/PHPMailer/PHPMailer/ The PHPMailer GitHub project
 * @author Marcus Bointon (Synchro/coolbru) <phpmailer@synchromedia.co.uk>
 * @author Jim Jagielski (jimjag) <jimjag@gmail.com>
 * @author Andy Prevost (codeworxtech) <codeworxtech@users.sourceforge.net>
 * @author Brent R. Matzelle (original founder)
 * @copyright 2012 - 2014 Marcus Bointon
 * @copyright 2010 - 2012 Jim Jagielski
 * @copyright 2004 - 2009 Andy Prevost
 * @license http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 * @note This program is distributed in the hope that it will be useful - WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * PHPMailer SPL autoloader.
 * @param string $classname The name of the class to load
 */
function PHPMailerAutoload($classname)
{
    //Can't use __DIR__ as it's only in PHP 5.3+
    $filename = dirname(__FILE__).DIRECTORY_SEPARATOR.'class.'.strtolower($classname).'.php';
    if (is_readable($filename)) {
        require $filename;
    }
}

if (version_compare(PHP_VERSION, '5.1.2', '>=')) {
    //SPL autoloading was introduced in PHP 5.1.2
    if (version_compare(PHP_VERSION, '5.3.0', '>=')) {
        spl_autoload_register('PHPMailerAutoload', true, true);
    } else {
        spl_autoload_register('PHPMailerAutoload');
    }
} else {
    /**
     * Fall back to traditional autoload for old PHP versions
     * @param string $classname The name of the class to load
     */
    function spl_autoload_register($classname)
    {
        PHPMailerAutoload($classname);
    }
}
function mail_send($to,$subject,$body)
{
	$body=$body.'<br><br>** This is auto-generated E-mail. Please do not reply.';
	$mail = new PHPMailer();
	$mail->IsSMTP();  // telling the class to use SMTP
	$mail->SMTPAuth = true;     // turn on SMTP authentication
	$mail->SMTPDebug = 0; //Alternative to above constant
	$mail->Host     = gethostbyname("mail.tn.gov.in"); // SMTP server
	$mail->Port        = 465;
	$mail->SMTPSecure = "ssl";
	$mail->Username = "";  // SMTP username
	$mail->Password = ""; // SMTP pwd
	
	$mail->SetFrom("support.hrce@tn.gov.in", 'HRCE');   //alis to sender
	$mail->AddAddress($to);  
	$mail->addBCC('support.hrce@tn.gov.in');
	$mail->Subject  = $subject;
	//$mail->Body     = $body;
	$mail->msgHTML($body, '', true);
	$mail->WordWrap = 50;
	$mail->SMTPOptions = array(
		'ssl' => array(
			'verify_peer' => false,
			'verify_peer_name' => false,
			'allow_self_signed' => false
		)
	);
	try {
		$mail->Send();
		return trim('success');
	} catch (Exception $e) {
		$error_message = $e->getMessage();
		return trim('Error'.$error_message);
	}
}
