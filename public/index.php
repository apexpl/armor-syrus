<?php
declare(strict_types = 1);

use Apex\Syrus\Syrus;
use Apex\Armor\Armor;
use Apex\Armor\User\Verify\{VerifyEmail, VerifyPhone};
use Apex\Armor\Auth\TwoFactor\TwoFactorEmail;
use Apex\Container\Di;
use Apex\Db\Interfaces\DbInterface;

// Load composer
require_once(__DIR__ . '/../vendor/autoload.php');

// Init Armor
$armor = new Armor(
    container_file: __DIR__ . '/../config/container_armor.php'
);


// Init syrus
$syrus = new Syrus(
    container_file: __DIR__ . '/../config/container_syrus.php'
);

// Init
$file = '';
$syrus->assign('is_login', 0);

// Authenticate request
if ($session = $armor->checkAuth()) { 
    $syrus->assign('user', $session->getUser()->toArray());
    $syrus->assign('is_login', 1);
} elseif (str_contains($_SERVER['REQUEST_URI'], 'members')) { 
    $syrus->setTemplateFile('login.html', true);
}

// Verify e-mail
if (preg_match("/^\/verify\/(.+)/", $_SERVER['REQUEST_URI'], $match)) { 
    $verifier = Di::make(VerifyEmail::class);
    $file = !$verifier->verify($match[1]) ? 'verify_fail.html' : 'verify_success.html';
} elseif (preg_match("/^\/2fa\/(.+)/", $_SERVER['REQUEST_URI'], $match)) { 
    $verify = Di::make(TwoFactorEmail::class);
    $verify->verify($match[1]);
}

// Render page
echo $syrus->render($file);


