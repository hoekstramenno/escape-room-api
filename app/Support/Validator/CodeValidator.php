<?php

namespace App\Support\Validator;

use MennoHoekstra\YellowDecoder\Decoder;
use MennoHoekstra\YellowDecoder\DecoderValidator;
use MennoHoekstra\YellowDecoder\Factories\InputCodeFactory;

class CodeValidator
{
    /**
     * @var \MennoHoekstra\YellowDecoder\Factories\InputCodeFactory
     */
    protected $inputCodeFactory;

    /**
     * @var \App\Support\Validator\ValidatorInterface
     */
    protected $validator;

    public function __construct(InputCodeFactory $inputCodeFactory, DecoderValidator $validator)
    {
        $this->inputCodeFactory = $inputCodeFactory;
        $this->validator        = $validator;
    }

    public function validate(int $code, string $icon, int $number) : bool
    {
        $decoder = new Decoder();
        $decoderResponse = $decoder->decode(
            $this->inputCodeFactory->make($icon, $code, $number)
        );
        return $this->validator->validate($decoderResponse, $number);
    }
}
