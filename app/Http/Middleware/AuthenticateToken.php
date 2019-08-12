<?php

namespace App\Http\Middleware;


use App\Contracts\ValidationTokenInterface;
use Closure;
use Illuminate\Http\Response;

class AuthenticateToken
{

    protected $tokenValidator;

    public function __construct(ValidationTokenInterface $tokenValidator)
    {
        $this->tokenValidator = $tokenValidator;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['message' => 'Token is missing.'],
                Response::HTTP_FORBIDDEN
            );
        }

        if (!$this->tokenValidator->validate($token)) {
            return response()->json(['message' => 'Invalid Token'],
                Response::HTTP_FORBIDDEN
            );
        }

        return $next($request);
    }
}
