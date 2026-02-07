<?php

namespace App\Providers;
use App\Models\UserCustom;
use Carbon\Carbon;
use Illuminate\Auth\GenericUser;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;

class CustomUserProvider extends EloquentUserProvider {

  

  /**
   * Validate a user against the given credentials.
   *
   * @param  \Illuminate\Contracts\Auth\Authenticatable $user
   * @param  array $credentials
   * @return bool
   */
    public function validateCredentials(UserContract $user, array $credentials)
    {

        if (is_object($user) && get_class($user) == 'App\Models\UserCustom'){
            $user->getAttributes();

            $attributes = $user->getAttributes();

            $salted = $credentials["password"] . "{" . $attributes["salt"] . "}";
            $digiest = hash('sha512', $salted, true);


            for ($i=1; $i<5000; $i++){
              $digiest = hash('sha512', $digiest.$salted, true);
            }

            $hash = base64_encode($digiest);

            if ($hash === $attributes["password"]){
                
                return true;
            }
        }

        return false;
    }
}