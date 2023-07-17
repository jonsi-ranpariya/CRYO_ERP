<?php

namespace App\Listeners\Import;

use App\Events\Import\ItemMasterImportEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\Master\ItemMasterImport;

class ItemMasterImportListener
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
     * @param  ItemMasterImportEvent  $event
     * @return void
     */
    public function handle(ItemMasterImportEvent $event): void
    {
        Excel::import(New ItemMasterImport(), $event->filePath);
    }
}
