<?php


namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;

class GeneralException extends Exception
{
    public function __construct($message = "", $code = 200)
    {
        parent::__construct($message, $code);
    }

    public function render(Request $request)
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => $this->message,'code'=>$this->code], $this->code);
        }
    }
}
