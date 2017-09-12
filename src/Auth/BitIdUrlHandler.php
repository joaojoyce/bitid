<?php namespace JoaoJoyce\BitId\Auth;

class BitIdUrlHandler
{

    public static function getUrlFromNonce($nonce) {
        return config('bitid.url.scheme') .config('bitid.url.url') . '/' . config('bitid.url.callback') . '?x=' . $nonce . '&u=1';
    }



}
