<?php
namespace App\Controllers;

use App\Models\Model;
use \App\System\App;
use \App\System\Settings;
use \App\Models\BooksModel;
use \App\System\Mailer;



class BooksController extends Controller {


    public function all() {
        $model = new BooksModel();

        if(isset($_POST['borrow']) && isset($_POST['condition']) == 'check'){
            if($_SESSION['timestamp'] + 1 * 60 <= time()) {
                $book_id  = $_POST['borrow'];
                if( $_SESSION['auth']->current_book == '') {
                    $_SESSION['auth']->current_book = $book_id;
                    $user_id = $_SESSION['auth']->id ;
                    $model->borrow($book_id,$user_id);
                    $errors['error'] = 'success';
                    $errors['message'] = 'Livre bien emprunté';
                    $_SESSION['timestamp'] = time();


                } else {
                    $errors['error'] = 'error';
                    $errors['message'] = 'Vous ne pouvez emprunter qu\'un livre à la fois';
                }
            } else {
                $errors['error'] = 'error';
                $errors['message'] = 'Veuillez attendre 1 min avant de remprunter un livre';
            }



        } else if (isset($_POST['borrow']) && isset($_POST['condition']) !== 'check') {

            $errors['error'] = 'error';
            $errors['message'] = 'Veuillez cocher les conditions d\'emprunt';
        }

        if(isset($_POST['return']) && isset($_POST['condition']) == 'check'){
            $book_id  = $_POST['return'];

            $_SESSION['auth']->current_book = $book_id;
            $user_id = $_SESSION['auth']->id ;
            $model->render($book_id,$user_id);
            $_SESSION['auth']->current_book = '';
            $errors['error'] = 'success';
            $errors['message'] = 'Vous avez bien rendu le livre, merci !';

            $data = $model->find($book_id);
            $body = App::getTwig()->render('pages/email.twig', [
                'type'       => 'render',
                'first_name' => $_SESSION['auth']->first_name,
                'last_name'  => $_SESSION['auth']->last_name,
                'book'       => $data
            ]);

            $model->mailer('bibli@hetic.net', 'Bibliothétic, livre rendu', $body);

        } else if (isset($_POST['return']) && isset($_POST['condition']) !== 'check') {

            $errors['error'] = 'error';
            $errors['message'] = 'Veuillez confirmer que vous avez bien rangé le livre dans la bibliothèque';
        }

        $data = $model->all();
        $categories = $model->categories();

        $this->render('pages/index.twig', [
            'page'        => 'index',
            'flash'       =>  [
                'statut'  => isset($errors['error']) ? $errors['error'] : '',
                'message' => isset($errors['message']) ? $errors['message'] : '',
            ],
            'books'       => $data,
            'categories'  => $categories,
            'user'        => $_SESSION['auth']
        ]);



    }

    //Get book detail
    public function book($id) {
        $model = new BooksModel();
        $data = $model->find($id);
        $response = ['book' => $data];
        echo json_encode($response);
    }

    //Email for confirmation or reminder
    public function email($name, $id) {
        $model = new BooksModel();
        $data = $model->find($id);
        $this->render('pages/email.twig', [
            'book'       => $data,
            'user'        => $name
        ]);
    }



    public function contact() {

        $model = new Model();

        if(isset($_POST)) {
            if(!empty($_POST['message'])) {
                $email      = $_SESSION['auth']->email;
                $first_name = $_SESSION['auth']->first_name;
                $last_name  = $_SESSION['auth']->last_name;
                $message    = isset($_POST['message']) ? $_POST['message'] : '';

                $body = App::getTwig()->render('pages/email.twig', [
                    'type'       => 'contact',
                    'message'    => $message,
                    'first_name' => $first_name,
                    'last_name'  => $last_name,
                    'email'      => $email
                ]);

                if($model->mailer('bibli@hetic.net', 'Bibliothétic, formulaire de contact', $body)){
                    $errors['error'] = 'success';
                    $errors['message'] = 'Bien envoyé, merci !';
                } else {
                    $errors['error'] = 'success';
                    $errors['message'] = 'Une erreur est survenu, envoyé un mail à bibli@hetic.net';
                }
            }
        }

        $this->render('pages/contact.twig', [
            'page' => 'contact',
            'flash'       =>  [
                'statut'  => isset($errors['error']) ? $errors['error'] : '',
                'message' => isset($errors['message']) ? $errors['message'] : '',
            ],
            'user' => $_SESSION['auth']
        ]);
    }


    public function faq() {
        $this->render('pages/faq.twig', [
            'page' => 'faq',
            'user' => $_SESSION['auth']
        ]);
    }


    public function filter($search,$available,$filter) {
        $model = new BooksModel();
        $data = $model->filter($search,$available,$filter);
        $response = ['books' => $data];
        echo json_encode($response);
    }

    public function maintenance() {
        $this->render('pages/maintenance.twig', []);
    }
}
