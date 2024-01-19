<?php

namespace The3labsTeam\NovaBusyResourceField\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;


class BusyController extends Controller
{
    public function storeBusy(Request $request)
    {
        $resource = $this->getResource($request['model-id'], $request['model-name']);
        $user = \App\Models\User::find($request['user-id']);
        $resource->busyFrom($user);
    }

    public function isBusy(Request $request)
    {
        $resource = $this->getResource($request['model-id'], $request['model-name']);

        return response()->json([
            'success' => $resource->isBusy(),
            'data' => $resource->isBusy() ? $resource->busyData() : null,
            'lastUpdate' => $resource->isBusy() ? Carbon::parse($resource->busyData()['pivot']['updated_at'])->diffForHumans() : null,
        ]);
    }

    protected function getResource(string $id, string $name)
    {
        $modelId = $id;
        $modelName = '\App\Models\\'.Str::studly(Str::singular($name));

        return $modelName::find($modelId);
    }
}
