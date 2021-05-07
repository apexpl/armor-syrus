<?php
declare(strict_types = 1);

namespace Apex\ArmorSyrus\Views\members;

use Apex\Syrus\Syrus;
use Apex\Armor\Armor;
use Apex\Armor\Auth\AuthSession;
use Apex\Container\Di;
use Apex\Db\Interfaces\DbInterface;


/**
 * Render the template.
 */
class twofactor2
{

    /**
     * Render
     */
    public function render(Syrus $syrus, Armor $armor, AuthSession $session)
    {

        // Update 2FA settings, if needed
        if (isset($_POST['submit']) && $_POST['submit'] == 'init') { 
            $user = $session->getUser();
            $user->updateTwoFactor($_POST['2fa_type'], 'none');
        }

        // Require 2FA
        $session->requireTwoFactor();

        /**
         * If we get here, we're already authorized
         */
        $syrus->assign('message', $_POST['message']);
    }

}



