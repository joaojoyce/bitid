<?php namespace JoaoJoyce\BitId\QRCode;

use PHPQRCode\QRcode;

class QRCodeAdapter
{

    private $qr_cache_folder;
    private $qr_base_url;


    public function __construct() {
        $this->qr_base_url = asset('storage/' . config('bitid.qr.cache_folder')) . '/';
        $this->qr_cache_folder = storage_path('app/public/' . config('bitid.qr.cache_folder'))  . '/';

        //TODO: This should be moved
        if (!file_exists($this->qr_cache_folder)) {
            mkdir($this->qr_cache_folder, 0777, true);
        }
    }


    public function getQRCode($url) {
        $qr_path = md5($url) . '.png';
        $img_url =  $this->qr_base_url . $qr_path;
        $storage_path = $this->qr_cache_folder . $qr_path;

        QRcode::png($url, $storage_path);

        return $img_url;

    }

}
