<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\ResourceCollection;

class GetFeedsCollection extends ResourceCollection
{
    public static $wrap = 'feeds';

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->transform(function ($item) {
            $data = $item->only(['id', 'user_id', 'url', 'description', 'when']);

            $data['owner'] = [
                'id' => $item->owner->id,
                'name' => $item->owner->name,
                'gender' => $item->owner->gender,
                'dob' => $item->owner->dob,
                'bio' => $item->owner->bio,
                'avatar' => $item->owner->avatar,
                'status' => $item->owner->status
            ];

            return $data;
        });
    }
}
