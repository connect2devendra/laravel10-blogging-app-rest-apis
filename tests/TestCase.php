<?php

namespace Tests;


use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Notification;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    
    public function setUp(): void
    {
        parent::setUp();      
        //Add it into phpunit.xml configuration file
        // \Config(['app.url' => 'http://localhost:8000']);
        // $this->withoutExceptionHandling();
        // Notification::fake();
    }
}
