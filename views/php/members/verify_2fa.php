<?php
declare(strict_types = 1);

namespace Apex\ArmorSyrus\Views\members;

use Apex\Syrus\Syrus;
use Apex\Armor\Armor;
use Apex\Armor\Auth\AuthSession;
use Apex\Armor\Auth\TwoFactor\{TwoFactorEmailOTP, TwoFactorPhone};
use Apex\Container\Di;
use Apex\Db\Interfaces\DbInterface;


/**
 * Render the template.
 */
class verify_2fa
{

    /**
     * Render
     */
    public function render(Syrus $syrus, Armor $armor, AuthSession $session)
    {

        // Phone verification
        if ($_POST['type'] == 'phone') { 

            // Verify
            $verifier = Di::make(TwoFactorPhone::class);
            if (!$verifier->verify($session->getUser(), $_POST['code'])) { 

                $syrus->addCallout('Invalid verification code.  Please double check, and try again.', 'error');
                $syrus->setTemplateFile('/members/2fa_phone.html', true);
            }

        // E-mail via OTP
        } else {

            // Verify 
            $verifier = Di::make(TwoFactorEmailOTP::class);
            if (!$verifier->verify($session->getUser(), $_POST['code'])) { 
                $syrus->addCallout('Invalid verification code.  Please double check, and try again.', 'error');
                $syrus->setTemplateFile('/members/2fa_email_otp.html', true);
            }

        }

    }

}





