<?php

namespace App\Listeners\Import;

use App\Events\Import\PartyMasterImportEvent;
use App\Imports\Master\PartyMasterImport;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Maatwebsite\Excel\Facades\Excel;

class PartyMasterImportListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {}

    /**
     * Handle the event.
     *
     * @param PartyMasterImportEvent $event
     * @return void
     */
    public function handle(PartyMasterImportEvent $event): void
    {
        Excel::import(new PartyMasterImport(), $event->filePath);
    }
}
