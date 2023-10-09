<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

trait ApiResponser
{

    private function successResponse($data, $code, $message = 'Success')
    {
        return response()->json($data, $code);
    }

    public function errorResponse($message, $code)
    {
        return response()->json([
            'ok' => false,
            'message' => $message, 'code' => $code], $code);
    }

    protected function showAll(Collection $collection, $message = 'Success', $code = 200)
    {
        return $this->successResponse(
            [
                'ok' => true,
                'message' => $message,
                'data' => $collection], $code);
    }

    protected function showArray(Array $array, $message = 'Success', $code = 200)
    {
        return $this->successResponse(
            [
                'ok' => true,
                'message' => $message,
                'data' => $array], $code);
    }

    protected function showOne(Model $instance, $message = 'Success', $code = 200)
    {
        return $this->successResponse([
            'ok' => true,
            'message' => $message,
            'data' => $instance], $code);
    }
    protected function successMessageResponse($message = 'Success',$code = 200)
    {
        return $this->successResponse([
            'ok' => true,
            'message' => $message], $code);
    }
}