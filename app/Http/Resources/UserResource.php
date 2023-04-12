<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
     if(   $this->getMedia('image')->count()!=0){
         $org_imag=$this->getMedia('image')->last()->getUrl();
         $thumb_imag=$this->getMedia('image')->last()->getUrl('thumb');
    }else{
        $org_imag='null';
        $thumb_imag='null';
    }

        return [


            'id'=> $this->id,
            'username'=>$this->username,
            'fullname'=>$this->fullname,
            'bio'=>$this->bio,
            'birthday'=>$this->birthday,
            'email'=>$this->email,
            'location'=> $this->location,
            
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'org_img' =>$org_imag,
            'thumb_img' => $thumb_imag,
          //  'count_images' => $this->getMedia('image')->count(),
           
        ];
    }
}
