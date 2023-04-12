<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\MediaResource;


class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {if(   $this->getMedia('images')->count()!=0){
        $images=$this->getMedia('images') ;
      
   }else{
       $images='null'; 
   }
        return [
      
      
            'id'=> $this->id,
            'name'=>$this->name,
            'description'=>$this->description,
            'link' =>$this->link,
            'user_id'=>$this->user_id,
            'skills'=>$this->skills()->get(),//->with('name'),
            'images' => MediaResource::collection($this->getMedia('images')), 
        ];
    }
}

