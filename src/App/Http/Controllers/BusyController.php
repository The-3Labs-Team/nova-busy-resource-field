<?php

namespace The3labsTeam\NovaBusyResourceField\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BusyController extends Controller
{
    public function storeBusy(Request $request)
    {
        // If is a new resource, return false
        if (! $request['model-id'] || ! $request['model-name']) {
            return;
        }
        $resource = $this->getResource($request['model-id'], $request['model-name']);
        $user = \App\Models\User::find($request['user-id']);
        $resource->busyFrom($user);
    }

    protected function getResource(string $id, string $name)
    {
        $modelId = $id;
        $modelName = '\App\Models\\'.Str::studly(Str::singular($name));

        return $modelName::find($modelId);
    }

    public function isBusy(Request $request)
    {
        // If is a new resource, return false
        if (! $request['model-id'] || ! $request['model-name']) {
            return response()->json([
                'success' => false,
                'data' => null,
                'lastUpdate' => null,
            ]);
        }

        $resource = $this->getResource($request['model-id'], $request['model-name']);

        if (! $resource) {
            return response()->json([
                'success' => false,
                'data' => null,
                'lastUpdate' => null,
            ]);
        }

        return response()->json([
            'success' => $resource->isBusy(),
            'data' => $resource->isBusy() ? $resource->busyData() : null,
            'lastUpdate' => $resource->isBusy() ? Carbon::parse($resource->busyData()['pivot']['updated_at'])->diffForHumans() : null,
        ]);
    }
}
