<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGroup;
use App\Group;
use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;
use App\GroupSubscription;
use JD\Cloudder\Facades\Cloudder;
use App\UserContact;

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

        $group = Group::with("owner.city", "subscriptions.subscriber.city")
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

        $group = Group::with("owner.city", "subscriptions.subscriber.city")
            ->where('id', $request->groupId)
            ->first();

        return ['group' => $group];
    }

    public function editGroup(CreateGroup $request)
    {
        $edit_group = Group::where(['id' => $request->groupId])
            ->update([
                'name' => $request->name,
                'description' => $request->description ? $request->description : null,
                'photo' => $request->photo,
            ]);

        $group = Group::with("owner.city", "subscriptions.subscriber.city")
            ->where('id', $request->groupId)
            ->first();

        return ['group' => $group];
    }

    public function createGroup(CreateGroup $request)
    {
        $user = auth('api')->user();

        $create_group = Group::create([
            'name' => $request->name,
            'description' => $request->description ? $request->description : null,
            'photo' => $request->photo,
            'owner_id' => $user->id,
            'anyone_can_post' => false,
            'anyone_can_join' => true,
        ]);

        $create_group->subscriptions()->create([
            'subscriber_id' => $user->id,
            'is_admin' => true
        ]);

        $group = Group::with("owner.city", "subscriptions.subscriber.city")
            ->where('id', $create_group->id)
            ->first();

        return ['group' => $group];
    }

    public function uploadImage(Request $request)
    {
        try {
            Cloudder::upload($request->image, null);
            $data = Cloudder::getResult();

            return ['name' => $data['secure_url']];
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function syncContacts(Request $request)
    {
        $auth_user = auth('api')->user();
        $contacts = $request->contacts;
        $contacts_data = [];

        foreach ($contacts as $contact) {
            foreach ($contact['phones'] as $phone) {
                if ($phone["value"][0] == '+') {
                    $mobile = preg_replace('/[^0-9]/', '', $phone["value"]);

                    if ($auth_user['mobile_cc'] != $mobile) {
                        $contacts_data[$mobile] = [
                            "mobile" => $mobile,
                            "mobileWithCountryCode" => $mobile,
                            "givenName" => $contact['givenName'],
                            "displayName" => $contact['displayName'],
                        ];
                    }
                }
            }
        }

        $contact_numbers = [];

        foreach ($contacts_data as $contact) {
            $contact_numbers[] = $contact['mobile'];
        }

        $users_data = User::with('country')
            ->select('id', 'name', 'mobile_cc', 'mobile', 'avatar')
            ->where('status', true)
            ->whereIn('mobile_cc', $contact_numbers)
            ->get();

        $users = [];

        foreach ($contacts_data as $contact) {
            $existing_user = null;

            foreach ($users_data as $user) {
                if ($user['mobile_cc'] == $contact['mobileWithCountryCode']) {
                    $existing_user = [
                        'id' => $user['id'],
                        'name' => $user['name'],
                        'avatar' => $user['avatar'],
                        'mobile' => $user['mobile'],
                        'mobileWithCountryCode' => $user['mobile_cc'],
                        'givenName' => $contact['givenName'],
                        'displayName' => $contact['displayName'],
                    ];
                }
            }

            $users[] = $existing_user ?? [
                'id' => null,
                'name' => $contact['givenName'] ?? $contact['displayName'],
                'avatar' => null,
                'mobile' => $contact['mobile'],
                'mobileWithCountryCode' => $contact['mobileWithCountryCode'],
                'givenName' => $contact['givenName'],
                'displayName' => $contact['displayName'],
            ];
        }

        $user_contacts = collect($users)
            ->map(function ($user) {
                return [
                    'user_id' => $user['id'],
                    'mobile_cc' => $user['mobileWithCountryCode'],
                    'name' => $user['name']
                ];
            })->toArray();

        UserContact::where('user_id', $user->auth_user)->delete();

        UserContact::insert($user_contacts);

        return compact('users');
    }

    public function get(Request $request)
    {
        $user = auth('api')->user();

        $groups = GroupSubscription::with('group.owner', 'group.subscriptions.subscriber.city')
            ->where(['subscriber_id' => $user->id])
            ->orderBy("created_at", "desc")
            ->get();

        return ['groups' => $groups];
    }
}
