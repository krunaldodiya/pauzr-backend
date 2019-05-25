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
    public function exitGroup(Request $request)
    {
        $user = auth('api')->user();
        $group = Group::find($request->groupId);

        if ($group->owner_id == $user->id) {
            $group->delete();
        }

        if ($group->owner_id != $user->id) {
            GroupSubscriber::where(['group_id'->$group->id, 'subscriber_id'->$user->id])->delete();
        }

        return response(['status' => true], 200);
    }

    public function editGroup(CreateGroup $request)
    {
        $group = Group::where(['id' => $request->groupId])
            ->update([
                'name' => $request->name,
                'description' => $request->description,
                'photo' => $request->photo,
            ]);

        return ['group' => $group];
    }

    public function createGroup(CreateGroup $request)
    {
        $user = auth('api')->user();

        $group = Group::create([
            'name' => $request->name,
            'description' => $request->description,
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
                        $contact_list[] = ["mobile" => $final, "device_name" => $contact['givenName']];
                    }
                }
            }
        }

        $contact_numbers = collect($contact_list)
            ->map(function ($contact) {
                return $contact['mobile'];
            })
            ->toArray();

        $users = User::select('id', 'name', 'mobile', 'avatar')
            ->whereIn('mobile', $contact_numbers)
            ->get()
            ->map(function ($user) use ($contact_list) {
                $user['device_name'] = $contact_list['device_name'];
                return $user;
            })
            ->toArray();

        return compact('users');
    }

    public function get(Request $request)
    {
        $user = auth('api')->user();

        $groups = GroupSubscriber::with('group.owner', 'group.subscribers.info.location')
            ->where(['subscriber_id' => $user->id])
            ->get();

        return ['groups' => $groups];
    }
}
