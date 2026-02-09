<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestEmail extends Command
{
    protected $signature = 'test:email {to}';
    protected $description = 'Test email configuration';

    public function handle()
    {
        $to = $this->argument('to');
        
        $this->info('Testing email configuration...');
        $this->info('To: ' . $to);
        $this->info('Driver: ' . config('mail.default'));
        $this->info('Host: ' . config('mail.mailers.smtp.host'));
        $this->info('Port: ' . config('mail.mailers.smtp.port'));
        $this->info('Username: ' . config('mail.mailers.smtp.username'));
        $this->info('From: ' . config('mail.from.address'));
        
        try {
            Mail::raw('This is a test email from CMS', function ($message) use ($to) {
                $message->to($to)
                        ->subject('Test Email from CMS');
            });
            
            $this->info('✓ Email sent successfully!');
            return 0;
        } catch (\Exception $e) {
            $this->error('✗ Failed to send email:');
            $this->error($e->getMessage());
            return 1;
        }
    }
}
