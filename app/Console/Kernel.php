<?php

/** 這是 Laravel 的 Console Kernel，其定義了應用程式的命令行介面 (CLI) 的相關設定。Console Kernel 用於定義 Artisan 命令，並可用來設定計畫任務 (scheduled tasks)、註冊自訂的控制器命令、註冊指令和注入服務等。在 schedule() 方法中可以設定計畫任務。在 commands() 方法中，我們可以定義自己的 Artisan 命令。例如，通過 $this->load(__DIR__.'/Commands')，可以載入應用程式的自定義命令。 **/

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
