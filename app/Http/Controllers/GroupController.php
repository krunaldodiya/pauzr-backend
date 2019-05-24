<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGroup;
use App\Group;
use App\GroupSubscriber;
use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;

class GroupController extends Controller
{
    public function create(CreateGroup $request)
    {
        $user = auth('api')->user();

        $group = Group::create([
            'name' => $request->name,
            'photo' => $request->photo,
            'owner_id' => $user->id,
            'anyone_can_post' => false,
            'anyone_can_join' => true,
        ]);

        $group->subscribers()->create([
            'subscriber_id' => $user->id,
            'is_admin' => true
        ]);

        return ['group' => $group];
    }

    public function uploadImage(Request $request)
    {
        $image = $request->image;

        $name = $image->getClientOriginalName();

        $image->move("users", $name);

        return ['name' => $name];
    }

    public function addParticipants(Request $request)
    {
        $subscribers = collect($request->participants)
            ->map(function ($subscriber_id) use ($request) {
                return [
                    'group_id' => $request->groupId,
                    'subscriber_id' => $subscriber_id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            })
            ->toArray();

        $group = GroupSubscriber::insert($subscribers);

        return ['group' => $group];
    }

    public function syncContacts(Request $request)
    {
        $user = auth('api')->user();
        $contacts = $request->contacts;

        $contact_list = [];

        foreach ($contacts as $contact) {
            foreach ($contact['phones'] as $phone) {
                $phone = preg_replace('/[^0-9]/', '', $phone['value']);

                if (strlen($phone >= 10)) {
                    $final = substr($phone, -10);

                    if ($final != $user->mobile) {
                        $contact_list[] = $final;
                    }
                }
            }
        }

        $users = User::select('id', 'name', 'mobile', 'avatar')
            ->whereIn('mobile', $contact_list)
            ->get();

        return compact('users');
    }

    public function get(Request $request)
    {
        $user = auth('api')->user();

        $groups = GroupSubscriber::with('group.subscribers.info')->where(['subscriber_id' => $user->id])->get();

        return ['groups' => $groups];
    }
}
