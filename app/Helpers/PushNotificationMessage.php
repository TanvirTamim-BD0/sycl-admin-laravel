<?php
namespace App\Helpers;
use Auth;

class PushNotificationMessage{

    public static function OrderComplete()
    {
        $data = "Successfully Order Complete";
        return $data;
    }

    public static function OrderAccept()
    {
        $data = "Successfully Admin Order Accept And Order Proccessing";
        return $data;
    }

    public static function OrderOutOfDelivery()
    {
        $data = "Order Out Of Delivery";
        return $data;
    }

    public static function OrderRejected()
    {
        $data = "Order Rejected";
        return $data;
    }

    public static function OrderSuccess()
    {
        $data = "Successfully Order Deliverd";
        return $data;
    }


}
