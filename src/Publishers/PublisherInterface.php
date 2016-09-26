<?php

namespace Messenger\Publishers;

interface PublisherInterface
{
    /**
     * @param $message
     *
     * @return mixed
     */
    public function publish($message);
}
