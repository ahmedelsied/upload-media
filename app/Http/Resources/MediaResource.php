<?php

namespace App\Http\Resources;

use App\Support\API\WithPagination;
use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
{
    use WithPagination;
    
     public function toArray($request)
     {
         return [
             'id'       =>  $this->id,
             'text'     =>  $this->text,
             'image'    =>  $this->getFirstMediaUrl('image'),
             'image'    =>  $this->getFirstMediaUrl('audio'),
         ];
     }
}
