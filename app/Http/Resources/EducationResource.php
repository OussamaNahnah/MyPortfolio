<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EducationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
      
   
           return [
               'id'=> $this->id,
               'nameschool'=>$this->nameschool,
               'specialization'=>$this->specialization,
               'startdate'=>$this->startdate,
               'enddate'=>$this->enddate,
               'user_id'=>$this->user_id,
           ];
    }
}
