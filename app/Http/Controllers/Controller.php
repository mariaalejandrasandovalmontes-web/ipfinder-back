<?php

namespace App\Http\Controllers;

use App\Services\ApiClient;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    private ApiClient $_client;

    public function client(): ApiClient
    {
        return $this->_client ??= $this->_client = new ApiClient();
    }
}
