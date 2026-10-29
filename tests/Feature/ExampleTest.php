<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'app.key' => 'base64:GroXmyGmS98B0bJcR/O32cdsN8LpbvrrDC7GnHCnUEQ=',
        ]);
    }

    public function test_the_application_returns_a_successful_response(): void
    {
        $this->get('/')->assertOk();
    }
}