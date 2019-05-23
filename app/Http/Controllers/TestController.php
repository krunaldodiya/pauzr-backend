<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function check(Request $request)
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
            ->whereIn(['mobile' => $contact_list])
            ->get();

        return compact('users');
    }
}
