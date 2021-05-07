<?php
declare(strict_types = 1);

namespace Apex\ArmorSyrus\Views\members;

use Apex\Syrus\Syrus;
use Apex\Armor\Auth\AuthSession;
use Apex\Armor\User\Verify\VerifyEmail;

/**
 * Render the template.
 */
class verify_email
{

    /**
     * Render
     */
    public function render(Syrus $syrus, AuthSession $session, VerifyEmail $verify)
    {

        // Resent, if needed
        if (isset($_POST['submit']) && $_POST['submit'] == 'resend') { 
            $verify->init($session->getUser());
            $syrus->addCallout('Successfully resent e-mail verification message.');
        }

    }

}


