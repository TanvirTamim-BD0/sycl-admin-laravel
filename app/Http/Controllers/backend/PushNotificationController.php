<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ladumor\OneSignal\OneSignal;

class PushNotificationController extends Controller
{

    public function pushNotification(){

        $fieldsh['include_player_ids'] = ['88a20577-4547-4833-9ec8-4bde5d6d2e6e'];

        $message = 'Hello !! It is a notification test.!';

        OneSignal::sendPush($fieldsh, $message);


    }
}
