<?php

namespace Tests\Feature;

use Illuminate\Http\Request;
use Tests\TestCase;
use The3labsTeam\NovaBusyResourceField\App\Http\Controllers\BusyController;

class BusyControllerTest extends TestCase
{
    public function test_it_returns_an_empty_busy_payload_for_new_resources(): void
    {
        $controller = new BusyController;
        $request = Request::create('/busy', 'POST');

        $response = $controller->isBusy($request);

        $this->assertSame([
            'success' => false,
            'data' => null,
            'lastUpdate' => null,
        ], $response->getData(true));
    }
}
