<?php namespace JoaoJoyce\BitId\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

//TODO: Remove these from here. Do dependency injection.
use JoaoJoyce\BitId\Crypto\RandomSource;
use JoaoJoyce\BitId\Model\Nonce;
use JoaoJoyce\BitId\QRCode\QRCodeAdapter;
use JoaoJoyce\BitId\Auth\BitIdUrlHandler;
use JoaoJoyce\BitId\Crypto\MessageSigningService;


class AuthController extends BaseController
{

    private $qr_code;

    public function __construct() {
        $this->qr_code = new QRCodeAdapter();
    }

    public function showLoginPage() {

        $nonce = RandomSource::getRandomString(32);
        $url = BitIdUrlHandler::getUrlFromNonce($nonce);

        session(['nonce' => $nonce]);

        $img_url = $this->qr_code->getQRCode($url);

        $nonce_model = new Nonce();
        $nonce_model->nonce = $nonce;
        $nonce_model->qr_code_name = $img_url;
        $nonce_model->save();

        return view('bitid::login_page',array(
            'url' => $url,
            'img_url' => $img_url
        ));
    }

    public function verifySignature(Request $request) {

        $public_key = $request->input('public_key');
        $signature = $request->input('signature');
        $nonce = MessageSigningService::getNonceFromSignature($signature);

        $nonce_model = Nonce::where('nonce','=',$nonce)->first();

        if(MessageSigningService::verifyMessageSignature($signature,$public_key) && $nonce_model) {

            $user = User::where('bit_id','=',$public_key)->first();
            if(!$user) {
                $user = new User();
                $user->bit_id=$public_key;
                $user->save();
            }
            $nonce_model->verified = true;
            $nonce_model->user = $user->id;
            $nonce_model->save();

        } else {

        }

    }

    public function check() {
        $nonce = session('nonce');

        echo $nonce;die();

        Nonce::where('nonce','=',$nonce)->first();

        if($nonce && $nonce->user && $nonce->verified) {
            $user = Auth::loginUsingId($nonce->user, true);
            if($user) {
                return "Logged in!!";
            }
        }
        return "Not logged in";
    }

}