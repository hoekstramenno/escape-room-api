<?php

namespace App\Support\Validator;

use App\Contracts\ValidationTokenInterface;
use App\Model\ApiToken;

class TokenValidator implements ValidationTokenInterface
{

    public function validate($token = null): bool
    {

        if ($token === null) {
            return false;
        }
        $token = ApiToken::where('token', $token)
                         ->whereDate('active_until', '>', date('Y-m-d H:i:s'))
                                  ->first();
        return ($token instanceof ApiToken);
    }
}
