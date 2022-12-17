<?php

namespace App\Console\Commands;

use App\Mail\ReminderEmail;
use Carbon\CarbonImmutable;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ExecuteReminderEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:remind';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'タスク期限の前日であることを通知する．';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $now = CarbonImmutable::now()->toString();
        try {
            Mail::to(config('mail.from.address'))->send(new ReminderEmail($now));
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
        $this->comment('Reminder emails were sent');
    }
}
