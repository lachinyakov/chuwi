<?php

/**
 * Общий интерфейс для всех трансформеров Message
 *
 * Interface TransformerInterface
 */
interface TransformerInterface
{
    /**
     * Трансформирует контекст в сообщение.
     *
     * @param $context
     * @return mixed
     */
    public function transform($context);
}
