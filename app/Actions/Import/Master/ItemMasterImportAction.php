<?php

namespace App\Actions\Import\Master;

use App\Events\Import\ItemMasterImportEvent;
use App\Models\Upload\FileUpload;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;


class ItemMasterImportAction
{
    use AsAction;

    public function handle(Request $request): JsonResponse
    {
        $data['name'] = $request->file('importFile')->getClientOriginalName();
        $data['path'] = $request->file('importFile')->storePublicly('/public/import/item-master');
        $res = FileUpload::saveData($data);

        event(new ItemMasterImportEvent($data['path']));
        return jsonData(['message' => 'data import in process', 'data' => $res]);
    }
}
