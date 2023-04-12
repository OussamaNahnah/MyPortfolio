<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfNetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
           if(   $this->getMedia('icon')->count()!=0){
               $org_icon=$this->getMedia('icon')->last()->getUrl();
               $thumb_icon=$this->getMedia('icon')->last()->getUrl('thumb');
          }else{
              $org_icon='null';
              $thumb_icon='null';
          }
      
              return [
      
      
                  'id'=> $this->id,
                  'name'=>$this->name,
                  'link'=>$this->link,
                  'user_id'=>$this->user_id,                  
                  'isprincipal'=>$this->isprincipal,
                  'org_icon' =>$org_icon,
                  'thumb_icon' => $thumb_icon,

                 
              ];
       }
}
