<?php

namespace Tests\Traits;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\AssertionFailedError;
use function Psy\debug;

trait FixturesTrait {
    protected function getFixturePath($file) {
        return base_path('tests/fixtures/'.class_basename($this).'/'.$file);
    }

    function getFixture($file) {
        $path = $this->getFixturePath($file);

        if(file_exists($path)) {
            return file_get_contents($path);
        } else {
            parent::fail($path.' fixture does not exists');
        }
    }

    function assertEqualFixtures($filename, $actual, $except = ['created_at', 'updated_at']) {
        $type = gettype($actual);
        switch ($type) {
            case 'string':
                parent::assertEquals($this->getFixture($filename), $this->getFixture($actual));
                break;
            case 'array':
                $expect = Arr::except($actual, $except);
                parent::assertJsonStringEqualsJsonString($this->getFixture($filename), json_encode($expect));
                break;
        }
    }

    protected function clearDatabase() {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        foreach (DB::select('SHOW TABLES') as $table) {
            foreach ($table as $key => $value) {
                DB::table($value)->truncate();
            }
        }
    }

    public function exportJson($fixture, $from) {
        file_put_contents($this->getFixturePath($fixture), json_encode($from, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }
}
