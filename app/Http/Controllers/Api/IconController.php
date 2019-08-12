<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class IconController extends Controller
{
    public function __construct()
    {
        $this->middleware('token');
    }

    public function icons(): ResourceCollection
    {
        die('gwar');
        return JsonResource::collection(
            \MennoHoekstra\YellowDecoder\Enums\ShapesEnums::toArray()
        );
    }

}
