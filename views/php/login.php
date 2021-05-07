<?php
declare(strict_types = 1);

namespace Apex\ArmorSyrus\Views;

use Apex\Syrus\Syrus;
use Apex\Armor\Armor;
use Apex\Armor\Auth\Login as ArmorLogin;
use Apex\Container\Di;


/**
 * Render the template.
 */
class login
{

    /**
     * Render
     */
    public function render(Syrus $syrus, Armor $armor)
    {

        // Template variable
        $syrus->assign('cookie_username', $armor->getCookieUsername());
        $action = $_POST['submit'] ?? '';

        // Check for post
        if ($action != 'login') { 
            return;
        }

        // Quick sanitize
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING) ?? [];
        $remember_me = isset($post['remember_me']) && $post['remember_me'] == 1 ? true : false;
        $login = Di::make(ArmorLogin::class);

        // Login
        if (!$session = $login->withPassword($post['username'], $post['password'], 'user', true, $remember_me)) { 
            $syrus->addCallout('Invalid username or password.', 'error');
            return;
        }

        // Get user
        $user = $session->getUser();
        //$syrus->assign('user', $user->toArray());
        // Set file
        $syrus->setTemplateFile('members/index.html');
    }

}


