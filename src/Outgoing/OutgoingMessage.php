<?php


namespace Boravel\Outgoing;

use BotMan\BotMan\Messages\Outgoing\OutgoingMessage as BotManOutgoingMessage;

class OutgoingMessage extends BotManOutgoingMessage
{

    protected $actions = [];

    public function addLink($text, $url)
    {
        $this->actions[] = [
            'text' => $text,
            'url' => $url
        ];

        return $this;
    }

    public function getActions(): array
    {
        return $this->actions;
    }
}