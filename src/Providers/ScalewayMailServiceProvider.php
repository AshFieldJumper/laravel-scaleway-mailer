<?php

namespace ashfieldjumper\LaravelScalewayMailer\Providers;

use ashfieldjumper\LaravelScalewayMailer\Transport\ScalewayTransport;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Mail;

class ScalewayMailServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        Mail::extend('scaleway', function () {
            $secretKey = config('mail.mailers.scaleway.secret_key') ?? env('SCW_SECRET_KEY');
            $projectId = config('mail.mailers.scaleway.project_id') ?? env('SCW_PROJECT_ID');
            $region = config('mail.mailers.scaleway.region') ?? env('SCALEWAY_EMAIL_REGION', 'fr-par');

            return new ScalewayTransport($secretKey, $projectId, $region);
        });
    }
}