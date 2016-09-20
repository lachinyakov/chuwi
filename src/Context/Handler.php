<?php

namespace Messenger\Context;

class Handler {

    protected $context;


    public function handle($arguments) {
        array_shift($arguments);
        if (!empty($arguments)) {
            $this->consumeArguments($arguments);
        } else {
            $this->offerSetArguments();
        }
    }

    private function consumeArguments($arguments)
    {
        $this->context = $arguments;

        if ('@mrBadger' === $arguments[0]) {
            return $arguments;
        } else {
            $this->offerAddConsumers();
        }
    }

    public function getUsers($input, $index) {
        return array(
            "mrBadger",
            "v",
            "dghost",
            "domio",
            "irvis",
            "ilia",
            "max",
            "alexander",
            "cnam",
            "moshhh",
            "slack/me",
            "slack/barabule4ka",
            "telegram"
        );
    }

    private function offerAddConsumers()
    {
        readline_completion_function(array($this, 'getUsers'));
        $consumeConsumers = trim(readline("Input Consumers: "));
        if (!empty($consumeConsumers)){
            $consumers = explode(" ", $consumeConsumers);
            foreach ($consumers as $key => $consumer)
            {
                $consumers[$key] = '@' . $consumer;
            }

            $this->context = array_merge($consumers, $this->context);
        }
    }

    private function offerSetArguments()
    {
        echo "\nPlease Input message: ";
        $message = trim(fgets(STDIN));

        if (!empty($message)) {
            $this->consumeArguments(explode(" ", $message));
        }
    }

    /**
     * @return mixed
     */
    public function getContext()
    {
        return $this->context;
    }
}