<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\ResourceCollection;

class GetWinnersCollection extends ResourceCollection
{
    public static $wrap = 'winners';

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->transform(function ($item) {
            $data = $item->only(['id', 'user_id', 'amount', 'type', 'status']);

            $created_at = $item->created_at;

            $data['date'] = $created_at->format("d-m-Y");
            $data['time'] = $created_at->format("h:i A");

            $data['user'] = [
                'id' => $item->user->id,
                'name' => $item->user->name,
                'avatar' => $item->user->avatar,
                'status' => $item->user->status
            ];

            return $data;
        });
    }
}
