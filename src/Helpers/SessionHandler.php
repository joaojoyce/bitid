<?php namespace JoaoJoyce\BitId\Helpers;

class SessionHandler
{

    public static function getUrl()
    {
        $nonce = Random::getRandomString(32);
        session(['nonce' => $nonce]);
        return self::getUrlFromNonce($nonce);
    }

    protected static function getUrlFromNonce($nonce) {
        return config('bitid.url.scheme') .config('bitid.url.url') . '/' . config('bitid.url.callback') . '?x=' . $nonce;
    }

}
