<?php
declare(strict_types = 1);

namespace Apex\ArmorSyrus\Views\members;

use Apex\Syrus\Syrus;
use Apex\Armor\Armor;
use Apex\Armor\Auth\Operations\Phone;
use Apex\Container\Di;
use Apex\Db\Interfaces\DbInterface;


/**
 * Render the template.
 */
class aes
{

    /**
     * Render
     */
    public function render(Syrus $syrus, Armor $armor, DbInterface $db)
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

        // Encrypt
        if ($action == 'encrypt') { 
            $session->encryptData($post['message']);
            $syrus->addCallout('Successfully added encrypted message to your profile.');
        }

        // Go through
        $ids = $db->getColumn("SELECT data_id FROM armor_data_index WHERE uuid = %s ORDER BY id DESC", $session->getUuid());
        foreach ($ids as $id) { 
            $text = $session->decryptData((int) $id);
            $enc = $db->getField("SELECT encdata FROM armor_data WHERE id = %i", $id);

            // Add to encrypted
            $encdata = [
                'id' => $id, 
                'decrypted' => $text, 
                'encrypted' => $enc
            ];
            $syrus->addBlock('encdata', $encdata);
        }

    }

}


