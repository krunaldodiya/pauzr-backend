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

            $created_at = $item->created_at;
            $read_at = $item->read_at;

            $data['when'] = $created_at->diffForHumans();
            $data['read'] = $read_at ? true : false;

            if (optional($item->data)['user']) {
                $data['user'] = [
                    'id' => optional($item->data)['user']['id'],
                    'name' => optional($item->data)['user']['name'],
                    'gender' => optional($item->data)['user']['gender'],
                    'dob' => optional($item->data)['user']['dob'],
                    'avatar' => optional($item->data)['user']['avatar'],
                    'status' => optional($item->data)['user']['status'],
                ];
            }

            if (optional($item->data)['follower']) {
                $data['follower'] = [
                    'id' => optional($item->data)['follower']['id'],
                    'name' => optional($item->data)['follower']['name'],
                    'gender' => optional($item->data)['follower']['gender'],
                    'dob' => optional($item->data)['follower']['dob'],
                    'avatar' => optional($item->data)['follower']['avatar'],
                    'status' => optional($item->data)['follower']['status'],
                ];
            }

            if (optional($item->data)['following']) {
                $data['following'] = [
                    'id' => optional($item->data)['following']['id'],
                    'name' => optional($item->data)['following']['name'],
                    'gender' => optional($item->data)['following']['gender'],
                    'dob' => optional($item->data)['following']['dob'],
                    'avatar' => optional($item->data)['following']['avatar'],
                    'status' => optional($item->data)['following']['status'],
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
