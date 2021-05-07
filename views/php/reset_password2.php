<?php
declare(strict_types = 1);

namespace Apex\ArmorSyrus\Views;

use Apex\Syrus\Syrus;
use Apex\Armor\User\Verify\ResetPassword;

/**
 * Render the template.
 */
class reset_password2
{

    /**
     * Render
     */
    public function render(Syrus $syrus, ResetPassword $reset)
    {

        // Init password reset
        $action = $_POST['submit'] ?? '';
        if ($action == 'reset') { 
            $reset->finish($_POST['new_password']);
            $syrus->setTemplateFile('login.html', true);
            $syrus->addCallout('Successfully reset your password.  You may login again.');
        }

    }

}


