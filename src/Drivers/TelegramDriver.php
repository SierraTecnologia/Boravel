<?php

namespace Boravel\Drivers;

use BotMan\Drivers\Telegram\TelegramDriver as BotManTelegramDriver;

class TelegramDriver extends BotManTelegramDriver
{

    use BuildServicePayloadWithLinksTrait;

}