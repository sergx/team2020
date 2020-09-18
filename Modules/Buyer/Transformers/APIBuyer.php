<?php

namespace Modules\Buyer\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class APIBuyer extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param \Illuminate\Http\Request
   * @return array
   */
  public function toArray($request)
  {
    //return $this->resource->toArray($request);
    return parent::toArray($request);

    //  return [
    //    'id' => $this->id,
    //    'name' => $this->name,
    //    'user_id' => $this->user_id,
    //    'description' => $this->description,
    //    'place' => $this->place,
    //    'created_at' => $this->created_at,
    //    'updated_at' => $this->updated_at,
    //  ];
  }
}
