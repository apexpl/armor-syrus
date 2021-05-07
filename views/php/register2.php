<?php
declare(strict_types = 1);

namespace Apex\ArmorSyrus\Views;

use Apex\Syrus\Syrus;
use Apex\Armor\Armor;
use Apex\Armor\User\{Validator, ArmorUser};
use Apex\Armor\Auth\Operations\Phone;
use Apex\Armor\Exceptions\ArmorProfileValidationException;
use redis;

/**
 * Render the template.
 */
class register2
{

    /**
     * Render
     */
    public function render(Syrus $syrus, Armor $armor, Validator $validator, redis $redis)
    {

        // Quick sanitize
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING) ?? [];
        $phone = Phone::get($post);

        // Validate user
        try {
            $validator->validate('', $post['password'], $post['username'], $post['email'], $phone);
        } catch(ArmorProfileValidationException $e) {
            $syrus->addCallout($e->getMessage(), 'error');
            $syrus->setTemplateFile('register.html');
            return;
        }

        // Create user
        $user = $armor->createUser('', $post['password'], $post['username'], $post['email'], $phone, 'user', null, true);

        // Assign template variables
        $syrus->assign('user', $user->toArray());
    }

}


