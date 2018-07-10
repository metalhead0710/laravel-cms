<?php

namespace PyroMans\Auxillary\Traits;

use PyroMans\User;
use PyroMans\Message;

trait SharedBackend {
    protected $newMsg;
    protected $count;
    protected $user;

    public function getSharedVars() {
        $this->newMsg = Message::where('isNew', true)->orderBy('created_at', 'DESC')->take(8)->get();
        $this->count = Message::where('isNew', true)->count();
        $this->user = User::first();
    }
}