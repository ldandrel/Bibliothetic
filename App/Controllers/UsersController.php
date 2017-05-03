<?php
namespace App\Controllers;

use \App\System\App;
use \App\System\Settings;
use \App\System\FormValidator;
use \App\Controllers\Controller;
use \App\Models\UsersModel;
use \App\System\Mailer;

class UsersController extends Controller {

    public function login() {
        $client = new \Google_Client();
        $client->setClientId(Settings::getConfig()['google_client']['id']);
        $client->setClientSecret(Settings::getConfig()['google_client']['secret']);
        $client->setRedirectUri(Settings::getConfig()['google_client']['redirect_uri']);
        $client->addScope('email');
        $client->addScope('profile');

        $auth_url = $client->createAuthUrl();
        $service  = new \Google_Service_Oauth2($client);

        if(isset($_GET['code'])) {
            $client->authenticate($_GET['code']);
            $client->setAccessToken($client->getAccessToken());
            $user = $service->userinfo->get();

            $model = new UsersModel();

            if($data = $model->exist($user->email)) {


                $_SESSION['auth'] = $data;
                $_SESSION['timestamp'] = '';

                App::redirect();
            }

            else {
                $model->signin([
                    'email'      => $user->email,
                    'last_name'  => $user->familyName,
                    'first_name' => $user->givenName
                ]);

                $data = $model->exist($user->email);
                $_SESSION['auth'] = $data;
                $_SESSION['timestamp'] = '';

                App::redirect();
            }
        } elseif ($_GET['success'] == 'true') {
            $model = new UsersModel();

            $data = $model->exist('demo@demo.demo');

            $_SESSION['auth'] = $data;
            $_SESSION['timestamp'] = '';
            App::redirect();

        } else {

            $this->render('pages/login.twig', [
                'title'       => 'Se connecter',
                'page'        => 'login',
                'flash'       =>  [
                    'statut'  => isset($errors) ? $errors : '',
                    'message' =>  isset($errors['message']) ? $errors['message'] : '',
                ],
                'auth_url'    => $auth_url
            ]);

        }



    }

    public function logout() {
        session_destroy();
        App::redirect();
    }

}
