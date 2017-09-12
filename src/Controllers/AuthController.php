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

    public function showLoginPage(Request $request) {

        $nonce = RandomSource::getRandomString(32);
        $url = BitIdUrlHandler::getUrlFromNonce($nonce);

        $request->session()->put('nonce', $nonce);

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

        \Log::info('Log Info:', $request->all());

        $public_key = $request->input('address');
        $signature = $request->input('signature');
        $uri = $request->input('uri');
        $nonce = MessageSigningService::getNonceFromUri($uri);

        $nonce_model = Nonce::where('nonce','=',$nonce)->first();

        if(MessageSigningService::verifyMessageSignature($signature,$public_key,$uri) && $nonce_model) {

            $user = User::where('bit_id','=',$public_key)->first();
            if(!$user) {
                $user = new User();
                $user->bit_id=$public_key;
                $user->save();
            }
            $nonce_model->user = $user->id;
            $nonce_model->save();
            return "OK";

        } else {
            return "NOP!";
        }

    }

    public function check(Request $request) {

        $nonce = $request->session()->get('nonce');

        $nonce= Nonce::where('nonce','=',$nonce)->first();

        if($nonce && $nonce->user) {
            $user = \Auth::loginUsingId($nonce->user, true);
            if($user) {
                //Clear tokens
                $nonce->delete();
                $request->session()->put("nonce",null);
                return "OK";
            }
        }
        abort(403);
    }

}