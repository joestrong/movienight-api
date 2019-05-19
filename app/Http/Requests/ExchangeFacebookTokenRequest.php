<?php namespace App\Http\Requests;

use Illuminate\Http\Request;

class ExchangeFacebookTokenRequest extends Request
{
    public function rules()
    {
        return [
            'token' => 'string|required',
        ];
    }
}
