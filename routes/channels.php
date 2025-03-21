<?php
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('notification', function ($user) {
    return true; // السماح للجميع بالاستماع
});
