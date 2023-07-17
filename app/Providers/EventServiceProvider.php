<?php

namespace App\Providers;

use App\Events\Import\ItemMasterImportEvent;
use App\Events\Import\PartyMasterImportEvent;
use App\Listeners\Import\ItemMasterImportListener;
use App\Listeners\Import\PartyMasterImportListener;
use App\Models\Bom\BillOfMaterialVersion;
use App\Models\Bom\BomVersionItem;
use App\Models\Bom\DrawingDocuments;
use App\Models\Despatch\NewChallanInvoiceItems;
use App\Models\Inventory\GoodsReceiptNoteItem;
use App\Models\Purchase\PurchaseOrderItem;
use App\Models\SalesCrm\SalesOrderItems;
use App\Observers\Bom\BillOfMaterialVersionObserver;
use App\Observers\Bom\BomVersionItemObserver;
use App\Observers\Despatch\NewChallanInvoiceItemObserver;
use App\Observers\DrawingDocumentsObserver;
use App\Observers\Inventory\GoodReceiptNoteItemObserver;
use App\Observers\Purchase\PurchaseOrderItemObserver;
use App\Observers\SalesCrm\SalesOrderItemObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        /*Registered::class => [
            SendEmailVerificationNotification::class,
        ],*/
        ItemMasterImportEvent::class => [
            ItemMasterImportListener::class
        ],
        PartyMasterImportEvent::class => [
            PartyMasterImportListener::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot(): void
    {
        DrawingDocuments::observe(DrawingDocumentsObserver::class);
        SalesOrderItems::observe(SalesOrderItemObserver::class);
        NewChallanInvoiceItems::observe(NewChallanInvoiceItemObserver::class);
        BillOfMaterialVersion::observe(BillOfMaterialVersionObserver::class);
        BomVersionItem::observe(BomVersionItemObserver::class);
        PurchaseOrderItem::observe(PurchaseOrderItemObserver::class);
        GoodsReceiptNoteItem::observe(GoodReceiptNoteItemObserver::class);
    }
}
