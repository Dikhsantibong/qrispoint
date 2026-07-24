<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Habit thresholds
    |--------------------------------------------------------------------------
    |
    | Aturan status kebiasaan transaksi merchant, dihitung oleh HabitService
    | dalam jendela waktu sejak merchant di-onboarding.
    |
    */

    'habit_threshold_tx' => 7,

    'habit_window_days' => 14,

    /*
    |--------------------------------------------------------------------------
    | Incentive rates
    |--------------------------------------------------------------------------
    |
    | Nominal insentif yang cair ke agen, dievaluasi oleh IncentiveService.
    |
    */

    'incentive_first_tx' => 15000,

    'incentive_activation' => 35000,

    'activation_tx' => 10,

    /*
    |--------------------------------------------------------------------------
    | Funnel
    |--------------------------------------------------------------------------
    |
    | Ambang "repeat user" dipakai oleh FunnelService untuk KPI repeat usage.
    |
    */

    'repeat_user_min_tx_per_week' => 4,

];
