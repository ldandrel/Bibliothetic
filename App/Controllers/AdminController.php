<?php
namespace App\Controllers;

use \App\System\App;
use \App\System\Settings;
use \App\Models\BooksModel;
use \App\Models\UsersModel;


class AdminController extends Controller {

    public function admin() {
        $model = new BooksModel();
        $data  = $model->all();
        $categories = $model->categories();

        $this->render('admin/admin.twig', [
            'title'       => 'Admin Panel',
            'description' => 'Bibliothetic, a library made by students for students.',
            'page'        => 'index',
            'panel'       => 'admin',
            'categories'  => $categories,
            'books'       => $data,
            'user'        => $_SESSION['auth']

        ]);
    }

    public function users(){
        $model = new UsersModel();
        $data  = $model->all();

        $this->render('admin/users.twig', [
            'title'       => 'Admin Panel',
            'description' => 'Bibliothetic, a library made by students for students.',
            'page'        => 'users',
            'panel'       => 'admin',
            'users'       => $data,
            'user'        => $_SESSION['auth']
        ]);
    }

    public function user($id) {
        $model = new UsersModel();
        $user  = $model->find_user($id);
        $history = $model->user_history($id);

        $this->render('admin/user-page.twig', [
            'title'       => 'Admin Panel',
            'page'        => 'users',
            'panel'       => 'admin',
            'users'       => $user,
            'history'     => $history,
            'user'        => $_SESSION['auth']
        ]);

    }

    public function book($id)
    {
        $model = new BooksModel();
        $model_user = new UsersModel();
        if(isset($_POST['available'])) {
            $user_id      = isset($_POST['user_id']) ? $_POST['user_id'] : '';
            $model->render($id, $user_id);
            $errors['error'] = 'success';
            $errors['message'] = 'Livre bien rendu';
        }
        if(isset($_POST['delete'])) {
            $model->delete($id);
            $errors['error'] = 'success';
            $errors['message'] = 'Livre bien supprimé';
        }
        if(isset($_POST['edit'])) {
            $id       = isset($_POST['id']) ? $_POST['id'] : '';
            $title    = isset($_POST['title']) ? $_POST['title'] : '';
            $author   = isset($_POST['author']) ? $_POST['author'] : '';
            $category = isset($_POST['category']) ? $_POST['category'] : '';

            $model->update($id, [
                'title' => $title,
                'author' => $author,
                'category_id' => $category
            ]);

            $errors['error'] = 'success';
            $errors['message'] = 'Livre bien modifié';

        }

        $data       = $model->find($id);
        $categories = $model->categories();
        $name       = $model_user->find($id);
        $history    = $model_user->book_history($id);

        $this->render('admin/book.twig', [
            'title' => 'Admin Panel',
            'description' => 'Bibliothetic, a library made by students for students.',
            'page' => 'book',
            'panel' => 'admin',
            'book' => $data,
            'flash' => [
                'statut' => isset($errors['error']) ? $errors['error'] : '',
                'message' => isset($errors['message']) ? $errors['message'] : '',
            ],
            'names'       => $name,
            'history'    => $history,
            'categories' => $categories,
            'user' => $_SESSION['auth']
        ]);


    }


    public function add(){
        $model = new BooksModel();
        $categories = $model->categories();
        $amazon = '';

        if(!empty($_POST)){
            if(isset($_POST['isbn']) ){
                $amazon = $model->amazon($_POST['isbn']);

                $title    = isset($_POST['title']) ? $_POST['title'] : '';
                $author   = isset($_POST['author']) ? $_POST['author'] : '';
                $category = isset($_POST['category']) ? $_POST['category'] : '';
                $cover    = isset($_POST['cover']) ? $_POST['cover'] : '';

                if($title != '' && $author != '' && $category != '' && $cover != '') {

                    $model->create([
                        'title' => $title,
                        'author' => $author,
                        'category_id' => $category,
                        'cover' => $cover
                    ]);

                    $errors['error'] = 'success';
                    $errors['message'] = 'Livre bien ajouté';
                } else {
                    $errors['error'] = 'error';
                    $errors['message'] = 'Verifier que tout les champs soit remplis';
                }

            }
        }


        $this->render('admin/add.twig', [
            'title'       => 'Admin Panel',
            'description' => 'Bibliothetic, a library made by students for students.',
            'page'        => 'add-book',
            'panel'       => 'admin',
            'flash'       =>  [
                'statut'  => isset($errors['error']) ? $errors['error'] : '',
                'message' => isset($errors['message']) ? $errors['message'] : '',
            ],
            'categories'  => $categories,
            'book'        => $amazon,
            'user'        => $_SESSION['auth']

        ]);

    }

    public function stats() {
        $model = new BooksModel();
        $user_model = new UsersModel();
        $data = $model->all();
        $users = $user_model->all();
        $this->render('admin/stats.twig', [
            'title'       => 'Admin Panel',
            'description' => 'Bibliothetic, a library made by students for students.',
            'page'        => 'stats',
            'panel'       => 'admin',
            'flash'       =>  [
                'statut'  => isset($errors['error']) ? $errors['error'] : '',
                'message' => isset($errors['message']) ? $errors['message'] : '',
            ],
            'books'       => $data,
            'users'       => $users,
            'user'        => $_SESSION['auth']

        ]);
    }
}