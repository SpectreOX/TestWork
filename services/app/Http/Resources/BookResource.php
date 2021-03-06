<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
        'id' => $this->id,
        'title' => $this->title,
        'description' => $this->description,
        'author_name' => $this->author_name,
        'publish_date' => $this->publish_date,
        'isbn' => $this->isbn,
        'category' => $this->category->name,
        ];
    }
}
