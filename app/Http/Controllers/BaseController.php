<?php

namespace App\Http\Controllers;

use App\Services\ApiResponse;


class BaseController extends Controller
{
    protected ApiResponse $api_response;

    protected function response(): ApiResponse
    {
        return $this->api_response ??= $this->api_response = new APIResponse();
    }

}
