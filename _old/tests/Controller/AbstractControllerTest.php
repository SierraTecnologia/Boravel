<?php

namespace Boss\Tests\Controller;

use Boss\Boss;
use Boss\Tests\IntegrationTest;

abstract class AbstractControllerTest extends IntegrationTest
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->app['config']->set('app.key', 'base64:UTyp33UhGolgzCK5CJmT+hNHcA+dJyp3+oINtX+VoPI=');

        Boss::auth(function () {
            return true;
        });
    }
}
