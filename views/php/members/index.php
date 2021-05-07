<?php
declare(strict_types = 1);

namespace Apex\ArmorSyrus\Views\members;

use Apex\Syrus\Syrus;
use Apex\Armor\Armor;
use Apex\Armor\Auth\Operations\Phone;
use Apex\Container\Di;


/**
 * Render the template.
 */
class index
{

    /**
     * Render
     */
    public function render(Syrus $syrus, Armor $armor)
    {

        // Check for auth
        if (!$session = $armor->checkAuth()) {
            $syrus->addCallout('Unable to authenticate your session.  Please login again.', 'error');
            $syrus->setTemplateFile('login.html', true);
            return;
        }
        $user = $session->getUser();

        // Quick sanitize
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING) ?? [];
        $action = $post['submit'] ?? '';

        // Update 2FA
        if ($action == 'update_2fa') { 
            $user->updateTwoFactor($post['2fa_type'], $post['2fa_frequency']);
            $syrus->addCallout('Successfully updated your 2FA settings.');

        // Update password
        } elseif ($action == 'update_password') { 
            $user->updatePassword($post['new_password'], $post['old_password']);
            $syrus->addCallout('Successfully updated your password.');

        // Update e-mail
        } elseif ($action == 'update_email') { 
            $user->updateEmail($post['email']);
            $syrus->addCallout('Successfully updated your e-mail address.');

        // Update phone
        } elseif ($action == 'update_phone') { 
            $user->updatePhone(Phone::get());
            $syrus->addCallout('Successfully updated your phone number.');

        }

        // Assign profile
        $syrus->assign('user', $user->toArray());
    }

}


