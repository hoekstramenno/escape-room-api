<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ValidatedCodeResource;
use App\Support\CodeValidationResponse;
use App\Support\Validator\CodeValidator;
use Illuminate\Http\Request;
use InvalidArgumentException;

class CodeController extends Controller
{
    /**
     * @var \App\Http\Controllers\Api\CodeValidator
     */
    protected $validator;

    public function __construct(CodeValidator $validator)
    {
        $this->validator = $validator;
        $this->middleware('token');
    }

    public function validateCode(Request $request): array
    {
        if ($request->get('code') === null || $request->get('icon') === null || $request->get('number') === null) {
            throw new InvalidArgumentException('No code, no icon or no number found');
        }

        $response = new CodeValidationResponse(
            $request->get('number'),
            $this->validator->validate($request->get('code'), $request->get('icon'), $request->get('number'))
        );

        return [
            'data' => $response->toArray(),
        ];
    }
}
