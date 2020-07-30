<?php

namespace App\Http\Controllers\V1\API;

use App\Http\Controllers\AppBaseController;
use Carbon\Carbon;
use League\Flysystem\FileNotFoundException;

class GeneralController extends AppBaseController
{
    public function heartbeats()
    {

        try {
            $contents = \File::get(app_path('Heartbeats/StoreHeartBeat.heartbeat'));
            $now = Carbon::now();
            return $this->sendResponse([
                'last heatbeat' => $now->diffInSeconds(Carbon::parse($contents)),
                'last heartbeat timet' => $contents,
            ], '');
        } catch (FileNotFoundException $exception) {
            die("The file doesn't exist");
        }
    }

    public function appVersion()
    {

        try {
            $contents = \File::get(storage_path('docs/api-docs.json'));
            return $this->sendResponse(json_decode($contents), '');
        } catch (FileNotFoundException $exception) {
            die("The file doesn't exist");
        }
    }
}
