<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGroup;
use App\Group;
use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;
use App\GroupSubscription;
use Illuminate\Support\Facades\Storage;

class GroupController extends Controller
{
    public function deleteGroup(Request $request)
    {
        $delete_group = Group::where(['id' => $request->groupId])->delete();

        return response(['status' => true], 200);
    }

    public function exitGroup(Request $request)
    {
        $remove_subscription = GroupSubscription::where(['group_id' => $request->groupId, 'subscriber_id' => $request->userId])->delete();

        return response(['status' => true], 200);
    }

    public function removeParticipants(Request $request)
    {
        $user = User::find($request->userId);

        $remove_subscription = GroupSubscription::where(['group_id' => $request->groupId, 'subscriber_id' => $user->id])
            ->delete();

        $group = Group::with("owner", "subscriptions.subscriber.location")
            ->where('id', $request->groupId)
            ->first();

        return ['group' => $group];
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

        $group_subscription = GroupSubscription::insert($subscribers);

        $group = Group::with("owner", "subscriptions.subscriber.location")
            ->where('id', $request->groupId)
            ->first();

        return ['group' => $group];
    }

    public function editGroup(CreateGroup $request)
    {
        $edit_group = Group::where(['id' => $request->groupId])
            ->update([
                'name' => $request->name,
                'description' => $request->description ?? null,
                'photo' => $request->photo,
            ]);

        $group = Group::with("owner", "subscriptions.subscriber.location")
            ->where('id', $request->groupId)
            ->first();

        return ['group' => $group];
    }

    public function createGroup(CreateGroup $request)
    {
        $user = auth('api')->user();

        $create_group = Group::create([
            'name' => $request->name,
            'description' => $request->description,
            'photo' => $request->photo,
            'owner_id' => $user->id,
            'anyone_can_post' => false,
            'anyone_can_join' => true,
        ]);

        $create_group->subscriptions()->create([
            'subscriber_id' => $user->id,
            'is_admin' => true
        ]);

        $group = Group::with("owner", "subscriptions.subscriber.location")
            ->where('id', $create_group->id)
            ->first();

        return ['group' => $group];
    }

    public function uploadImage(Request $request)
    {
        try {
            $image_path = Storage::disk('public')->put("assets", $request->image);
            return ['name' => $image_path];
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function syncContacts(Request $request)
    {
        $user = auth('api')->user();
        $contacts = $request->contacts;

        $contact_list = [];

        foreach ($contacts as $contact) {
            foreach ($contact['phones'] as $phone) {
                $phone = preg_replace('/[^0-9]/', '', $phone['value']);

                if (strlen($phone) >= 10) {
                    $final = substr($phone, -10);

                    if ($final != $user->mobile) {
                        $contact_list[$final] = [
                            "mobile" => $final,
                            "givenName" => $contact['givenName'],
                            "displayName" => $contact['displayName'],
                        ];
                    }
                }
            }
        }

        $contact_numbers = [];

        foreach ($contact_list as $contact) {
            $contact_numbers[] = $contact['mobile'];
        }

        $users = User::select('id', 'name', 'mobile', 'avatar')
            ->where('status', true)
            ->whereIn('mobile', $contact_numbers)
            ->get()
            ->map(function ($user) use ($contact_list) {
                $user['givenName'] = $contact_list[$user['mobile']]['givenName'];
                $user['displayName'] = $contact_list[$user['mobile']]['displayName'];

                return $user;
            })
            ->toArray();

        return compact('users');
    }

    public function get(Request $request)
    {
        $user = auth('api')->user();

        $groups = GroupSubscription::with('group.owner', 'group.subscriptions.subscriber.location')
            ->where(['subscriber_id' => $user->id])
            ->get();

        return ['groups' => $groups];
    }
}
