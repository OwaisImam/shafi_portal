<?php

namespace App\Repositories\ExternalRepository;

use Carbon\Carbon;

class FirebaseRepository
{
    private $database;

    public function __construct()
    {
        $this->database = app('firebase.database');
    }

    public function fetch()
    {
        return $this->database->getReference('notifications')->getValue();
    }

    public function storeNotification($user, $message = '')
    {
        return $this->database->getReference('notifications/' . $user->id)
             ->set([
                 'user_id' => $user->id,
                 'name' => $user->name,
                 'email' => $user->email,
                 'datetime' => Carbon::now(),
                 'message' => $message,
                 'is_seen' => 0,
             ]);
    }
}
