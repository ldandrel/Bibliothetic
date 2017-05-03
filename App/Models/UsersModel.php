<?php
namespace App\Models;

use \App\System\App;
use \App\Models\Model;

class UsersModel extends Model {

    protected $table = "users";
    protected $table_history = "history";
    protected $table_books = "books";


    public function exist($email) {
        $user = App::getDb()->prepare('SELECT * FROM users WHERE email = ?', [$email], true);

        if($user) {
            return $user;
        }

        else {
            return false;
        }
    }

    public function signin($data) {
        $this->create($data);
    }

    public function login($data) {
        $_SESSION['auth'] = $data;
    }

    public static function logged(){
        if(!isset($_SESSION['auth'])) {
            App::redirect('connexion');
            exit;
        }
    }

    public function all(){
        return $this->query("SELECT * FROM {$this->table}");
    }

    public function book_history($book) {
        return $this->query("SELECT history.*, books.*, users.* FROM {$this->table_history} LEFT JOIN {$this->table_books} ON history.book_id=books.id LEFT JOIN {$this->table} ON history.user_id = users.id WHERE history.book_id= $book ORDER BY history.date_return ASC");
    }

    public function user_history($id){
            return $this->query("SELECT history.*, books.* FROM {$this->table_history} LEFT JOIN {$this->table_books} ON history.book_id=books.id WHERE history.user_id= $id ORDER BY history.date_return ASC");
    }

    public function find($id) {
        return $this->query("SELECT users.* FROM {$this->table} LEFT JOIN {$this->table_books} ON users.current_book=books.id WHERE users.current_book = $id");
    }

    public function find_user($id) {
        return $this->query("SELECT * FROM {$this->table} WHERE id = $id");

    }

}
