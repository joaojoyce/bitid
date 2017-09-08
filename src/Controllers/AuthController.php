<?php namespace JoaoJoyce\BitId\Controllers;

use Illuminate\Routing\Controller as BaseController;


class AuthController extends BaseController
{

    public function showLoginPage() {
        return view('bitid::login_page');
    }

    public function validateSession() {

    }

}