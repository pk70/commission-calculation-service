<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Services\FileService;
use App\Services\DepositService;
use App\Services\WithdrawService;
use Illuminate\Foundation\Testing\WithFaker;
use App\Http\Controllers\CommissionController;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CalculationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_calculation_by_csv_array()
    {
        $test_existing = new CommissionController(new FileService, new WithdrawService, new DepositService);
        $test_result = $test_existing->output();
        $this->assertContains('0.6', $test_result, 'success');
    }
}
