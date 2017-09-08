<?php namespace JoaoJoyce\BitId\Controllers;

use Illuminate\Routing\Controller as BaseController;
use JoaoJoyce\BitId\Helpers\Random;


class AuthController extends BaseController
{

    public function showLoginPage() {

        $nonce = Random::getRandomString(32);

        session(['nonce' => $nonce]);
        return view('bitid::login_page',array(
            'nonce' => $nonce
        ));
    }

    public function validateSession() {

    }

}