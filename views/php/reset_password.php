<?php
declare(strict_types = 1);

namespace Apex\ArmorSyrus\Views;

use Apex\Syrus\Syrus;
use Apex\Armor\User\Verify\ResetPassword;

/**
 * Render the template.
 */
class reset_password
{

    /**
     * Render
     */
    public function render(Syrus $syrus, ResetPassword $reset)
    {

        // Init password reset
        $action = $_POST['submit'] ?? '';
        if ($action == 'init') { 
            $reset->byEmail($_POST['email']);
            $syrus->addCallout("An e-mail has been sent to $_POST[email] if that e-mail address exists within the database.");
        }


        $syrus->assign('is_login', 0);
    }

}


