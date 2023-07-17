<?php

namespace App\Actions\Import\Master;

use App\Events\Import\PartyMasterImportEvent;
use App\Models\Upload\FileUpload;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class PartyMasterImportAction
{
    use AsAction;

    public function handle(Request $request): JsonResponse
    {
        $data['name'] = $request->file('importFile')->getClientOriginalName();
        $data['path'] = $request->file('importFile')->storePublicly('/public/import/party-master');
        $res = FileUpload::saveData($data);

        event(new PartyMasterImportEvent($data['path']));
        return jsonData(['message' => 'data import in process', 'data' => $res]);
    }
}
