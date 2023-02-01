<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;
use Tests\Traits\FixturesTrait;

abstract class TestCase extends BaseTestCase
{
    use FixturesTrait;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createApplication();
        $this->loadDump();
    }

    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }

    public function loadDump() {
        $dump = $this->getFixture('dump.sql');

        $this->clearDatabase();

        DB::unprepared($dump);
    }
}
