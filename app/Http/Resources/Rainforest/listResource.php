<?php

namespace App\Http\Resources\Rainforest;

use Illuminate\Http\Resources\Json\JsonResource;

class listResource extends JsonResource
{

    public function toArray($request)
    {
        $data = parent::toArray($request);
        dd($data);
    }
}
