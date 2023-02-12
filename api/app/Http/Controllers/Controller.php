<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Success response
     *
     * @param array $data = []
     * @param integer $code = 200
     * @return \Illuminate\Http\Response
     */
    public function responseSuccess(array $data = [], $code = 200)
    {
        return response()->json($data, $code);
    }

    /**
     * error respons 
     *
     * @param array $errors = []
     * @param integer $code = 500
     * @return \Illuminate\Http\Response
     */
    public function responseError(array $errors = [], int $code = 500)
    {
        return response()->json($errors, $code);
    }

    /**
     * Resource not found respons with message
     *
     * @param array $data = []
     * @param integer $code
     * @return \Illuminate\Http\Response
     */
    public function responseNotFound(array $data = [], int $code = 404)
    {
        return response()->json(array_merge(['message' => 'Resource not found'], $data), $code);
    }

    /**
     * Validation error with message
     *
     * @param array $errors = []
     * @param integer $code = 422
     * @return \Illuminate\Http\Response
     */
    public function responseValidationError(array $errors = [], int $code = 422)
    {
        return response()->json(['message' => 'Validation error', 'errors' => $errors], $code);
    }
}
