<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        InvalidRequestException::class
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Exception
     */
    public function render($request, Exception $exception)
    {
        // 参数验证错误的异常
        if ($exception instanceof ValidationException) {
            return response()->json(
                [
                    'code' => 400,
                    'message' => $exception->validator->errors()->first(),
                ]);
        }

        // 未登录或登录状态失效，我们需要返回 401 的 http code 和错误信息
        if ($exception instanceof UnauthorizedHttpException) {
            return response()->json([
                'code' => 401,
                'message' => $exception->getMessage()
            ],200);
        }
        // token  黑名单
        if ($exception instanceof TokenBlacklistedException){
            return response()->json([
                'code' => 401,
                'message' => $exception->getMessage()
            ],200);
        }
        // token不正确
        if ($exception instanceof TokenInvalidException){
            return response()->json([
                'code' => 401,
                'message' => $exception->getMessage()
            ]);
        }
        // 没有 token
        if ($exception instanceof JWTException){
            return response()->json([
                'code' => 401,
                'message' => $exception->getMessage()
            ]);
        }

        return parent::render($request, $exception);
    }
}
