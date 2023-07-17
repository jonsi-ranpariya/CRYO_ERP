<?php

namespace App\Actions\Import;

use Illuminate\Support\Facades\Artisan;
use Lorisleiva\Actions\Concerns\AsAction;

class ImportNowAction
{
    use AsAction;

    public function handle()
    {
        return Artisan::call('php artisan queue:work');
    }
}
