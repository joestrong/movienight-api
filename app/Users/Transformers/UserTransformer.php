<?php namespace App\Users\Transformers;

use App\Users\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'id' => $user->getId(),
            'name' => $user->getName(),
        ];
    }
}
