<?php

require_once __DIR__ . '/../../src/helpers.php';

use PHPUnit\Framework\TestCase;

class RenewalCalculationTest extends TestCase
{
    public function test_calculate_next_renewal_for_daily_plan()
    {
        $planType = 'daily';
        $scheduleRules = json_encode(['plan_type' => 'daily']);
        
        $nextRenewal = calculateNextRenewal($planType, $scheduleRules);
        
        $this->assertNotNull($nextRenewal);
        $this->assertEquals((new DateTime('+1 day'))->format('Y-m-d'), (new DateTime($nextRenewal))->format('Y-m-d'));
    }

    public function test_calculate_next_renewal_for_weekly_plan()
    {
        $planType = 'weekly';
        // Assuming today is Monday (1), next renewal should be on Wednesday (3)
        $scheduleRules = json_encode(['plan_type' => 'weekly', 'days' => [1, 3, 5]]);
        
        $nextRenewal = calculateNextRenewal($planType, $scheduleRules);
        
        $this->assertNotNull($nextRenewal);
    }

    public function test_calculate_next_renewal_for_monthly_plan()
    {
        $planType = 'monthly';
        // Assuming today is the 10th, next renewal should be on the 15th
        $scheduleRules = json_encode(['plan_type' => 'monthly', 'days' => [1, 15, 30]]);
        
        $nextRenewal = calculateNextRenewal($planType, $scheduleRules);
        
        $this->assertNotNull($nextRenewal);
    }
}
