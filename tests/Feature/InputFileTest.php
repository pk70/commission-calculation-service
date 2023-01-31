<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InputFileTest extends TestCase
{
    /** @test */

    public function test_input_file_exists()
    {
        $file = storage_path() . "/input.csv";

        $this->assertFileExists($file, "File exists");
    }

}
