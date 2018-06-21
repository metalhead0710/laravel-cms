<?php

namespace PyroMans\Exceptions;

use Exception;
use Intervention\Image\Exception\NotFoundException;
use PyroMans\User;
use PyroMans\Message;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    const NOT_FOUND = 404;
    const SERVER_ERROR = 500;

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if($this->isHttpException($e)) {
            if ($e->getStatusCode() === self::NOT_FOUND) {
                if ($request->is('dominator/*')) {
                    return response()->view(
                        "admin.errors.{$e->getStatusCode()}",
                        [
                            'exception' => $e,
                            'count' => Message::where('isNew', true)->count(),
                            'newMsg' => Message::where('isNew', true)
                                                ->orderBy('created_at', 'DESC')
                                                ->take(8)
                                                ->get(),
                            'user' => User::firstOrFail()
                        ],
                        $e->getStatusCode(),
                        $e->getHeaders()
                    );
                } elseif ($e->getStatusCode() === self::SERVER_ERROR) {
                    echo 500; die;
                } else {
                    return $this->renderHttpException($e);
                }
            }
        }

        return parent::render($request, $e);
    }
}
