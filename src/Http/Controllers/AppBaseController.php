<?php

namespace Boravel\Http\Controllers\Travels;

use InfyOm\Generator\Utils\ResponseUtil;
use Response;
use Muleta\Packagist\Traits\ResponseControllerTrait;

class AppBaseController extends Controller
{
    use ResponseControllerTrait;
    protected $packageName = TransmissorProvider::pathVendor;
    /**
     * @SWG\Swagger(
     *   basePath="/api/v1",
     * @SWG\Info(
     *     title="Laravel Generator APIs",
     *     version="1.0.0",
     *   )
     * )
     * This class should be parent class for other API controllers
     * Class AppBaseController
     */
    public function sendResponse($result, $message)
    {
        return Response::json(ResponseUtil::makeResponse($message, $result));
    }

    public function sendError($error, $code = 404)
    {
        return Response::json(ResponseUtil::makeError($error), $code);
    }
}
