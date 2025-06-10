<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use App\Traits\ApiResponser;

class Authenticate extends Middleware
{
    use ApiResponser;
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        abort($this->errorResponse('Unauthenticated', 401));
    }
}
