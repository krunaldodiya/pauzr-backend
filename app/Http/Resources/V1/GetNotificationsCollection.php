<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\ResourceCollection;

class GetNotificationsCollection extends ResourceCollection
{
    public static $wrap = 'notifications';

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->transform(function ($item) {
            $data = $item->only(['id', 'type', 'notifiable_type', 'notifiable_id']);

            $data['when'] = $item->created_at->diffForHumans();
            $data['read'] = $item->read_at == null ? false : true;

            if (optional($item->data)['user']) {
                $data['user'] = [
                    'id' => optional($item->data)['user']['id'],
                    'name' => optional($item->data)['user']['name'],
                    'avatar' => optional($item->data)['user']['avatar'],
                    'status' => optional($item->data)['user']['status'],
                ];
            }

            if (optional($item->data)['follower']) {
                $data['user'] = [
                    'id' => optional($item->data)['follower']['id'],
                    'name' => optional($item->data)['follower']['name'],
                    'avatar' => optional($item->data)['follower']['avatar'],
                    'status' => optional($item->data)['follower']['status'],
                ];
            }

            if (optional($item->data)['post']) {
                $data['post'] = [
                    'id' => optional($item->data)['post']['id'],
                    'user_id' => optional($item->data)['post']['user_id'],
                    'url' => optional($item->data)['post']['url'],
                    'description' => optional($item->data)['post']['description'],
                    'when' => optional($item->data)['post']['when'],
                ];
            }

            return $data;
        });
    }
}
