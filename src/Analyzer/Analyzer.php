<?php

namespace Messenger\Analyzer;

use Messenger\Message\Message;

class Analyzer
{
    public function getTypeOfMessage($data)
    {
        $tokens = $data;
        if (is_string($data)) {
            $tokens = explode(" ", $data);
        }
        $type                 = Message::TYPE_COMMON_MESSAGE;
        $firstToken           = $tokens[0];
        $privateMessageRegexp = '/^@\w+$/';
        if (preg_match($privateMessageRegexp, $firstToken)) {
            $type = Message::TYPE_PRIVATE_MESSAGE;
        }

        return $type;
    }
}
