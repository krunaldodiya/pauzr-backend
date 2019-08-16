<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\ResourceCollection;

class GetWinnersCollection extends ResourceCollection
{
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

            $data['user'] = [
                'id' => $item->user->id,
                'name' => $item->user->name,
                'gender' => $item->user->gender,
                'dob' => $item->user->dob,
                'avatar' => $item->user->avatar,
                'status' => $item->user->status
            ];

            return $data;
        });
    }
}
