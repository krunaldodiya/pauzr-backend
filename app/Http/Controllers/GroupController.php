<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGroup;
use App\Group;
use App\GroupSubscriber;
use Illuminate\Http\Request;
use App\User;

class GroupController extends Controller
{
    public function create(CreateGroup $request)
    {
        $user = auth('api')->user();

        $group = Group::create([
            'name' => $request->name,
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

    public function syncContacts(Request $request)
    {
        $contacts = $request->contacts;

        $contact_list = [];

        foreach ($contacts as $contact) {
            foreach ($contact['phones'] as $phone) {
                $phone = preg_replace('/[^0-9]/', '', $phone['value']);

                if (strlen($phone >= 10)) {
                    $contact_list[] = substr($phone, -10);
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

        $groups = GroupSubscriber::with('group.subscribers')->where(['subscriber_id' => $user->id])->get();

        return ['groups' => $groups];
    }
}
