<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
         return $user->isadmin;
    }
 
 
    public function delete(User $user, User $model): bool
    {
        return $user->isadmin;
    }

    public function deleteAny(User $user   ): bool
    {
        return $user->isadmin;
    }
   
  
}
