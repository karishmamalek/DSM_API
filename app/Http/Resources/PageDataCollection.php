<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
class PageDataCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function lastPageUrl()
    {
        $last = $this->lastPage();

        return $this->url($last);
    }
    public function toArray($request)
    {
       // return parent::toArray($request);
       return [
        'data' => $this->collection,
        'pagination' => [
            'first_page_url' => ($this->url(0) != '' ? $this->url(0) : null),
            'last_page' => ($this->lastPage() != '' ? $this->lastPage() : null),
            'last_page_url' => ($this->lastPageUrl() != '' ? $this->lastPageUrl() : null),
            'next_page_url' => ($this->nextPageUrl() != '' ? $this->nextPageUrl() : null),
            'per_page' =>  ($this->perPage() != '' ? $this->perPage() : null),
            'prev_page_url' => ($this->previousPageUrl() != '' ? $this->previousPageUrl() : null),
            'total_records' => $this->total(),
            'current_page' => ($this->currentPage() != '' ? $this->currentPage() : null),
            'total_pages' => $this->lastPage()
        ],
    ];

    }

    public function withResponse($request, $response)
    {
        $jsonResponse = json_decode($response->getContent(), true);
        $response->setContent(json_encode($jsonResponse));
    }
}
