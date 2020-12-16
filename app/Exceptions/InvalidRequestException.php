<?php


namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;

class InvalidRequestException extends Exception
{
    public function __construct($message = "", $code = 400)
    {
        parent::__construct($message, $code);
    }

    public function render(Request $request)
    {
        if ($request->expectsJson()) {
            return response()->json(['message'=>$this->message,'code'=>$this->code], $this->code);
        }
    }
}
