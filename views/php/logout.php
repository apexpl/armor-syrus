<?php
declare(strict_types = 1);

namespace Apex\ArmorSyrus\Views;

use Apex\Syrus\Syrus;
use Apex\Armor\Auth\AuthSession;

/**
 * Render the template.
 */
class logout
{

    /**
     * Render
     */
    public function render(Syrus $syrus, AuthSession $session)
    {

        // Logout
        $session?->logout();
        $syrus->assign('is_login', 0);
    }

}


