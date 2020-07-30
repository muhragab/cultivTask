<?php

namespace App\Traits;

use Exception;
use InfyOm\Generator\Utils\ResponseUtil;
use Response;

trait ResponseCustom
{
    public function sendResponse($result, $message)
    {
        return Response::json(ResponseUtil::makeResponse($message, $result));
    }

    public function sendError($error, $code = 400)
    {
        return Response::json(ResponseUtil::makeError($error), $code);
    }

}
