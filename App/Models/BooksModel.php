<?php
namespace App\Models;

use \App\System\App;
use \App\Models\Model;
use \App\System\Settings;

class BooksModel extends Model {

    protected $table = "books";
    protected $table_categories = "categories";
    protected $table_history = "history";
    protected $table_users = "users";

    public function all() {
        if(isset($_SESSION['auth']->current_book) && $_SESSION['auth']->current_book !== ''){
            return $this->query("SELECT books.*, categories.category FROM {$this->table} LEFT JOIN {$this->table_categories} ON books.category_id=categories.id ORDER BY books.id = {$_SESSION['auth']->current_book} DESC, books.id DESC");
        } else {
            return $this->query("SELECT books.*, categories.category FROM {$this->table} LEFT JOIN {$this->table_categories} ON books.category_id=categories.id ORDER BY books.id DESC");
        }
    }

    public function history() {
        return $this->query("SELECT history.*, books.*, categories.category FROM {$this->table_history} LEFT JOIN {$this->table} ON history.book_id=books.id LEFT JOIN {$this->table_categories} ON books.category_id=categories.id WHERE history.user_id={$_SESSION['auth']->id} ORDER BY history.date_return ASC");
    }

    public function find($book) {
        return $this->query("SELECT books.*, categories.category FROM {$this->table} LEFT JOIN {$this->table_categories} ON books.category_id=categories.id WHERE books.id = ?", [$book], true);
    }

    public function categories() {
        return $this->query("SELECT * FROM {$this->table_categories}");
    }

    public function filter($search,$available,$filter) {
        if(isset($_SESSION['auth']->current_book) && $_SESSION['auth']->current_book !== ''){
            return $this->query("SELECT books.*, categories.category FROM {$this->table} LEFT JOIN {$this->table_categories} ON books.category_id=categories.id WHERE books.available IN ($available) AND books.category_id IN ($filter) AND (books.title LIKE '%$search%' OR books.author LIKE '%$search%') ORDER BY books.id = {$_SESSION['auth']->current_book} DESC, books.id DESC");
        } else {
            return $this->query("SELECT books.*, categories.category FROM {$this->table} LEFT JOIN {$this->table_categories} ON books.category_id=categories.id WHERE books.available IN ($available) AND books.category_id IN ($filter) AND (books.title LIKE '%$search%' OR books.author LIKE '%$search%') ORDER BY books.id DESC");
        }

    }
    public function borrow($book,$user_id) {
        App::getDb()->execute("UPDATE {$this->table} INNER JOIN users ON users.id = $user_id SET books.available = 0, users.current_book= $book, books.date_return_planned = CURDATE() + INTERVAL 1 MONTH WHERE books.id = $book");
        App::getDb()->execute("INSERT INTO {$this->table_history} SET user_id = $user_id, book_id = $book, date_borrow = NOW()");
    }

    public function render($book,$user_id) {
        App::getDb()->execute("UPDATE {$this->table} INNER JOIN users ON users.id = $user_id SET books.available = 1, users.current_book=null, books.date_return_planned = null WHERE books.id = $book");
        App::getDb()->execute("UPDATE {$this->table_history} SET date_return = NOW() WHERE user_id = $user_id");
    }



    public function amazon($isbn) {
        $awsAccessKeyID = Settings::getConfig()['amazon']['awsAccessKeyID'];
        $awsSecretKey = Settings::getConfig()['amazon']['awsSecretKey'];
        $awsAssociateTag = Settings::getConfig()['amazon']['awsAssociateTag'];
        $host = 'ecs.amazonaws.com';
        $path = '/onca/xml';
        $args = array(
            'AssociateTag' => $awsAssociateTag,
            'AWSAccessKeyId' => $awsAccessKeyID,
            'IdType' => 'ISBN',
            'ItemId' => $isbn,
            'Operation' => 'ItemLookup',
            'ResponseGroup' => 'Medium',
            'SearchIndex' => 'Books',
            'Service' => 'AWSECommerceService',
            'Timestamp' => gmdate('Y-m-d\TH:i:s\Z'),
            'Version'=> '2009-01-06'
        );

        ksort($args);
        $parts = array();
        foreach(array_keys($args) as $key) {
            $parts[] = $key . "=" . $args[$key];
        }

        // Construct the string to sign
        $stringToSign = "GET\n" . $host . "\n" . $path . "\n" . implode("&", $parts);
        $stringToSign = str_replace('+', '%20', $stringToSign);
        $stringToSign = str_replace(':', '%3A', $stringToSign);
        $stringToSign = str_replace(';', urlencode(';'), $stringToSign);

        // Sign the request
        $signature = hash_hmac("sha256", $stringToSign, $awsSecretKey, TRUE);
        // Base64 encode the signature and make it URL safe
        $signature = base64_encode($signature);
        $signature = str_replace('+', '%2B', $signature);
        $signature = str_replace('=', '%3D', $signature);
        // Construct the URL
        $url = 'http://' . $host . $path . '?' . implode("&", $parts) . "&Signature=" . $signature;
        $rawData = file_get_contents($url);

        $metadata = simplexml_load_string($rawData);
        if (isset($metadata->Items->Request->Errors)) {
            return $metadata->Items->Request->Errors;
        } else {
            $cd['cover'] = (string) $metadata->Items->Item->LargeImage->URL;
            $cd['title'] = (string) $metadata->Items->Item->ItemAttributes->Title;
            $cd['author'] = (string) $metadata->Items->Item->ItemAttributes->Author;
            return $cd;
        }
    }

}
