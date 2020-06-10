<?php

namespace Boss\Tests\Feature;

use Boss\Boss;
use Boss\Tests\IntegrationTest;
use Boss\Http\Middleware\Authenticate;

class AuthTest extends IntegrationTest
{
    public function test_authentication_callback_works()
    {
        $this->assertFalse(Boss::check('taylor'));

        Boss::auth(function ($request) {
            return $request === 'taylor';
        });

        $this->assertTrue(Boss::check('taylor'));
        $this->assertFalse(Boss::check('adam'));
        $this->assertFalse(Boss::check(null));
    }

    public function test_authentication_middleware_can_pass()
    {
        Boss::auth(function () {
            return true;
        });

        $middleware = new Authenticate;

        $response = $middleware->handle(
            new class {
            },
            function ($value) {
                return 'response';
            }
        );

        $this->assertSame('response', $response);
    }

    /**
     * @expectedException \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function test_authentication_middleware_responds_with_403_on_failure()
    {
        Boss::auth(function () {
            return false;
        });

        $middleware = new Authenticate;

        $middleware->handle(
            new class {
            },
            function ($value) {
                return 'response';
            }
        );
    }
}
