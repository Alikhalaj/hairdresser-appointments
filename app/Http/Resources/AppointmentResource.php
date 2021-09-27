<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return[
            "id"=> $this->id,
            "user_id"=> $this->user_id,
            "barber_id"=> $this->barber_id,
            "price"=> $this->price,
            "prepayment"=> $this->prepayment,
            "time_start"=>  $this->time_start,
            "time_end"=> $this->time_end,
            "created_at"=> $this->created_at,
            "updated_at"=> $this->updated_at
        ];
    }
}
