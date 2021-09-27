<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class Barber extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "name_shop"=> $this->name_shop,
            "phone"=> $this->phone,
            "address"=> $this->address,
            "time_work_start"=> $this->time_work_start,
            "time_work_end"=> $this->time_work_end,
            "image_business_license"=> Storage::url($this->image_business_license),
            "image_hairdressing_degree"=> Storage::url($this->image_hairdressing_degree),
            "latitude"=> $this->latitude,
            "longitude"=> $this->longitude,
        ];
    }
}
