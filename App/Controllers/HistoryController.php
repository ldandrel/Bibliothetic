<?php
namespace App\Controllers;

use \App\System\App;
use \App\System\Settings;
use \App\System\FormValidator;
use \App\Controllers\Controller;
use \App\Models\BooksModel;
use \App\System\Mailer;

class HistoryController extends Controller {

    public function history(){
        $model = new BooksModel();
        $user_id = $_SESSION['auth']->id;
        $data = $model->history($user_id);
        $this->render('pages/history.twig', [
            'page'        => 'history',
            'flash'       =>  [
                'statut'  => isset($errors['error']) ? $errors['error'] : '',
                'message' => isset($errors['message']) ? $errors['message'] : '',
            ],
            'history'     => $data,
            'user'        => $_SESSION['auth']
        ]);
    }
}
