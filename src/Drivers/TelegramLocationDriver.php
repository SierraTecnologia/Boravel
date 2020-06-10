<?php

namespace Boravel\Drivers;

use BotMan\Drivers\Telegram\TelegramLocationDriver as BotManTelegramLocationDriver;

class TelegramLocationDriver extends BotManTelegramLocationDriver
{

    use BuildServicePayloadWithLinksTrait;

}