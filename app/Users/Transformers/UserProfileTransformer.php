<?php namespace App\Users\Transformers;

use App\Users\User;
use League\Fractal\TransformerAbstract;

class UserProfileTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'name' => $user->getName(),
        ];
    }
}
