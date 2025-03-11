<?php

namespace App\Policies;

use App\Models\Ad;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class Adpolicy
{
    public  static function modify(User $user, Ad $ad): Response{
        return $user->id === $ad->user_id
        ? Response::allow()
        : Response::deny('you do not own this ad');
        ;
    
       }
}
