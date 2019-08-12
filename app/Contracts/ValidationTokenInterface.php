<?php

namespace App\Contracts;

interface ValidationTokenInterface
{
    public function validate($token = null): bool;

}
