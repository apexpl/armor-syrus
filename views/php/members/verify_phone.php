<?php
declare(strict_types = 1);

namespace Apex\ArmorSyrus\Views\members;

use Apex\Syrus\Syrus;
use Apex\Armor\Auth\AuthSession;
use Apex\Armor\User\Verify\VerifyPhone;

/**
 * Render the template.
 */
class verify_phone
{

    /**
     * Render
     */
    public function render(Syrus $syrus, AuthSession $session, VerifyPhone $verify)
    {

        // Confirm
        $action = $_POST['submit'] ?? '';
        if ($action == 'confirm') { 

            if (!$verify->verify($session->getUser(), $_POST['code'])) { 
                $syrus->addCallout('Invalid confirmation code.  Please double check, and try again.', 'error');
            } else { 
                $syrus->addCallout('Successfully verified your phone number.');
            }

        // Resend
        } elseif ($action == 'resend') { 
            $verify->init($session->getUser());
            $syrus->addCallout('Successfully resent confirmation code to your phone.');
        }


    }

}

