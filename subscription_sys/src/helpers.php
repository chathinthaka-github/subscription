<?php

function calculateNextRenewal($planType, $scheduleRulesJson, $isFixedTime, $fixedTime)
{
    $scheduleRules = json_decode($scheduleRulesJson, true);
    if (!$scheduleRules) {
        return null;
    }

    $now = new DateTime();
    $next = null;
    
    switch ($planType) {
        case 'daily':
            $next = clone $now;
            $next->modify('+1 day');
            break;
            
        case 'weekly':
            if (!empty($scheduleRules['days']) && is_array($scheduleRules['days'])) {
                $currentDay = (int)$now->format('N'); // 1-7 (Monday-Sunday)
                $nextDay = null;
                
                // Find next scheduled day
                foreach ($scheduleRules['days'] as $day) {
                    $day = (int)$day;
                    if ($day > $currentDay) {
                        $nextDay = $day;
                        break;
                    }
                }
                
                // If no day found this week, use first day of next week
                if ($nextDay === null && !empty($scheduleRules['days'])) {
                    $nextDay = (int)$scheduleRules['days'][0];
                    $daysToAdd = 7 - $currentDay + $nextDay;
                } else {
                    $daysToAdd = $nextDay - $currentDay;
                }
                
                $next = clone $now;
                $next->modify("+{$daysToAdd} days");
            }
            break;
            
        case 'monthly':
            if (!empty($scheduleRules['days']) && is_array($scheduleRules['days'])) {
                $currentDay = (int)$now->format('d');
                $currentMonth = (int)$now->format('m');
                $currentYear = (int)$now->format('Y');
                $nextDay = null;
                
                // Find next scheduled day
                foreach ($scheduleRules['days'] as $day) {
                    $day = (int)$day;
                    if ($day > $currentDay) {
                        $nextDay = $day;
                        break;
                    }
                }
                
                // If no day found this month, use first day of next month
                if ($nextDay === null && !empty($scheduleRules['days'])) {
                    $nextDay = (int)$scheduleRules['days'][0];
                    $next = new DateTime("{$currentYear}-{$currentMonth}-01");
                    $next->modify('+1 month');
                    $next->modify('+' . ($nextDay - 1) . ' days');
                } else {
                    $next = new DateTime("{$currentYear}-{$currentMonth}-{$nextDay}");
                }
            }
            break;
    }

    if ($next) {
        // Set time if fixed time is provided
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

function generateMtRefId()
{
    return 'MT' . date('YmdHis') . rand(1000, 9999);
}
