<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExperienceResource extends JsonResource
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
            'name'=>$this->name,
            'titlejob'=>$this->titlejob,
            'location'=>$this->location,
            'startdate'=>$this->startdate,
            'enddate'=>$this->enddate,
            'user_id'=>$this->user_id,
        ];
    }
}
