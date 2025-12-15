<?php

// Set timezone to Colombo, Sri Lanka
date_default_timezone_set('Asia/Colombo');

/**
 * Calculate the next renewal date based on plan type and schedule rules.
 * 
 * @param string $planType       - 'daily', 'weekly', or 'monthly'
 * @param string $scheduleRulesJson - JSON containing schedule configuration
 * @param bool   $isFixedTime    - Whether to use fixed time
 * @param string $fixedTime      - Fixed time in HH:MM:SS format
 * @return string|null           - Next renewal datetime in 'Y-m-d H:i:s' format
 */
function calculateNextRenewal($planType, $scheduleRulesJson, $isFixedTime, $fixedTime)
{
    $scheduleRules = json_decode($scheduleRulesJson, true);
    if (!$scheduleRules) {
        return null;
    }

    $now = new DateTime();
    $skipSubscriptionDay = isset($scheduleRules['skip_subscription_day']) 
        ? (bool)$scheduleRules['skip_subscription_day'] 
        : false;
    
    $next = null;
    
    switch ($planType) {
        case 'daily':
            $next = calculateDailyRenewal($now, $skipSubscriptionDay, $isFixedTime, $fixedTime);
            break;
            
        case 'weekly':
            $next = calculateWeeklyRenewal($now, $scheduleRules, $skipSubscriptionDay, $isFixedTime, $fixedTime);
            break;
            
        case 'monthly':
            $next = calculateMonthlyRenewal($now, $scheduleRules, $skipSubscriptionDay, $isFixedTime, $fixedTime);
            break;
    }

    if ($next) {
        // Set fixed time if provided
        if ($isFixedTime && !empty($fixedTime)) {
            $time = explode(':', $fixedTime);
            if (count($time) >= 2) {
                $next->setTime((int)$time[0], (int)$time[1], (int)($time[2] ?? 0));
            }
        }
        return $next->format('Y-m-d H:i:s');
    }
    
    return null;
}

/**
 * Calculate next renewal for daily plan.
 */
function calculateDailyRenewal($now, $skipSubscriptionDay, $isFixedTime, $fixedTime)
{
    $next = clone $now;
    
    // If skip_subscription_day is false and we have a fixed time
    if (!$skipSubscriptionDay && $isFixedTime && !empty($fixedTime)) {
        $todayWithTime = clone $now;
        $time = explode(':', $fixedTime);
        if (count($time) >= 2) {
            $todayWithTime->setTime((int)$time[0], (int)$time[1], (int)($time[2] ?? 0));
            
            // If the fixed time is still in the future today, use today
            if ($todayWithTime > $now) {
                return $todayWithTime;
            }
        }
    }
    
    // Otherwise, schedule for tomorrow
    $next->modify('+1 day');
    return $next;
}

/**
 * Calculate next renewal for weekly plan.
 */
function calculateWeeklyRenewal($now, $scheduleRules, $skipSubscriptionDay, $isFixedTime, $fixedTime)
{
    if (empty($scheduleRules['days']) || !is_array($scheduleRules['days'])) {
        return null;
    }
    
    $currentDay = (int)$now->format('N'); // 1-7 (Monday-Sunday)
    $days = array_map('intval', $scheduleRules['days']);
    sort($days); // Ensure days are sorted
    
    $nextDay = null;
    $daysToAdd = 0;
    
    // Check if today is a scheduled day and we shouldn't skip
    if (!$skipSubscriptionDay && in_array($currentDay, $days)) {
        if (canScheduleToday($now, $isFixedTime, $fixedTime)) {
            // Today is valid - return today
            return clone $now;
        }
    }
    
    // Find next scheduled day after today
    foreach ($days as $day) {
        if ($day > $currentDay) {
            $nextDay = $day;
            $daysToAdd = $day - $currentDay;
            break;
        }
    }
    
    // If no day found this week, use first day of next week
    if ($nextDay === null) {
        $nextDay = $days[0];
        $daysToAdd = 7 - $currentDay + $nextDay;
    }
    
    $next = clone $now;
    $next->modify("+{$daysToAdd} days");
    return $next;
}

/**
 * Calculate next renewal for monthly plan.
 */
function calculateMonthlyRenewal($now, $scheduleRules, $skipSubscriptionDay, $isFixedTime, $fixedTime)
{
    if (empty($scheduleRules['days']) || !is_array($scheduleRules['days'])) {
        return null;
    }
    
    $currentDay = (int)$now->format('d');
    $currentMonth = (int)$now->format('m');
    $currentYear = (int)$now->format('Y');
    $days = array_map('intval', $scheduleRules['days']);
    sort($days); // Ensure days are sorted
    
    $nextDay = null;
    
    // Check if today is a scheduled day and we shouldn't skip
    if (!$skipSubscriptionDay && in_array($currentDay, $days)) {
        if (canScheduleToday($now, $isFixedTime, $fixedTime)) {
            // Today is valid - return today
            return clone $now;
        }
    }
    
    // Find next scheduled day after today in this month
    foreach ($days as $day) {
        if ($day > $currentDay) {
            // Validate day exists in current month
            $daysInMonth = (int)$now->format('t');
            if ($day <= $daysInMonth) {
                $nextDay = $day;
                break;
            }
        }
    }
    
    if ($nextDay !== null) {
        // Schedule for later this month
        return new DateTime("{$currentYear}-{$currentMonth}-{$nextDay}");
    }
    
    // No valid day this month, use first day of next month
    $nextMonth = clone $now;
    $nextMonth->modify('first day of next month');
    
    // Find first valid day in next month
    $daysInNextMonth = (int)$nextMonth->format('t');
    foreach ($days as $day) {
        if ($day <= $daysInNextMonth) {
            $nextMonth->setDate(
                (int)$nextMonth->format('Y'),
                (int)$nextMonth->format('m'),
                $day
            );
            return $nextMonth;
        }
    }
    
    // Fallback to first day of next month if no valid days
    return $nextMonth;
}

/**
 * Check if we can schedule a renewal for today based on fixed time.
 * Returns true if:
 *   - No fixed time is set, OR
 *   - Fixed time is in the future today
 */
function canScheduleToday($now, $isFixedTime, $fixedTime)
{
    if (!$isFixedTime || empty($fixedTime)) {
        // No fixed time constraint - can schedule now
        return true;
    }
    
    $todayWithTime = clone $now;
    $time = explode(':', $fixedTime);
    if (count($time) >= 2) {
        $todayWithTime->setTime((int)$time[0], (int)$time[1], (int)($time[2] ?? 0));
        return $todayWithTime > $now;
    }
    
    return false;
}

/**
 * Generate unique MT reference ID.
 */
function generateMtRefId()
{
    return 'MT' . date('YmdHis') . rand(1000, 9999);
}
