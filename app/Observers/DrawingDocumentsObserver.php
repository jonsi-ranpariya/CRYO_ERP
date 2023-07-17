<?php

namespace App\Observers;

use App\Models\Bom\DrawingDocuments;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DrawingDocumentsObserver
{
    /**
     * Handle the DrawingDocuments "created" event.
     *
     * @param DrawingDocuments $drawingDocuments
     * @return void
     */
    public function created(DrawingDocuments $drawingDocuments)
    {
        //
    }

    /**
     * Handle the DrawingDocuments "updated" event.
     *
     * @param DrawingDocuments $drawingDocuments
     * @return void
     */
    public function updated(DrawingDocuments $drawingDocuments)
    {
        //
    }

    /**
     * Handle the DrawingDocuments "deleted" event.
     *
     * @param DrawingDocuments $drawingDocuments
     * @return JsonResponse
     */
    public function deleted(DrawingDocuments $drawingDocuments)
    {
        try {
            deleteStorageItem($drawingDocuments->documentItem);
        } catch (FileNotFoundException $exception) {
            Log::error('DrawingDocuments Observer Error: '.$exception->getMessage());
        }
    }

    /**
     * Handle the DrawingDocuments "restored" event.
     *
     * @param DrawingDocuments $drawingDocuments
     * @return void
     */
    public function restored(DrawingDocuments $drawingDocuments)
    {
        //
    }

    /**
     * Handle the DrawingDocuments "force deleted" event.
     *
     * @param DrawingDocuments $drawingDocuments
     * @return void
     */
    public function forceDeleted(DrawingDocuments $drawingDocuments)
    {
        /*try {
            deleteStorageItem($drawingDocuments->documentItem);
        }catch (FileNotFoundException $exception)
        {
            $data['status'] = 404;
            $data['message'] = $exception->getMessage();
            return jsonData($data);
        }*/
    }
}
