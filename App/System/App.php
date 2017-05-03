<?php
namespace App\System;

use App\Models\BooksModel;
use \App\System\Settings;
use \App\Controllers\Controller;


class App {
    private static $database;
    private static $twig;
    public function __construct() {
        if(Settings::getConfig()['debug']) {
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
        }
        else {
            error_reporting(0);
            ini_set('display_errors', 0);
        }
    }
    public static function getDb() {
        if(self::$database === null) {
            self::$database = new Database(
                Settings::getConfig()['database']['name'],
                Settings::getConfig()['database']['username'],
                Settings::getConfig()['database']['password'],
                Settings::getConfig()['database']['host']
            );
        }
        return self::$database;
    }
    public static function getTwig() {
        if(self::$twig === null) {
            $loader = new \Twig_Loader_Filesystem(dirname(__DIR__) . '/Views');
            self::$twig = new \Twig_Environment($loader, [
                'cache' => Settings::getConfig()['twig']['cache'],
            ]);
            $asset = new \Twig_Function('asset', function ($path) {
                return Settings::getConfig()['url'] . 'assets/' . $path;
            });
            $excerpt = new \Twig_Function('excerpt', function ($content, $size = 30) {
                if(strlen($content) > 30) {
                    return substr($content, 0, $size) . '...';
                }
                else {
                    return $content;
                }
            });
            $dump = new \Twig_Function('dump', function ($string) {
                return print_r($string);
            });
            $url = new \Twig_Function('url', function ($slug, $id = null, $post_type = null) {
                return Settings::getConfig()['url'] . $slug;
            });
            $date = new \Twig_Function('date', function ($original_date) {
                return date("d/m/Y", strtotime($original_date));
            });
            $title = new \Twig_Function('title', function ($title = null) {
                if($title) return $title . ' - ' . Settings::getConfig()['name'];
                else return Settings::getConfig()['name'];
            });
            $description = new \Twig_Function('description', function () {
                return Settings::getConfig()['description'];
            });
            $utf8 = new \Twig_Function('utf8', function ($chain) {
                return utf8_decode($chain);
            });
            $utf8_encode = new \Twig_Function('utf8_encode', function ($chain) {
                return utf8_encode($chain);
            });
            $book_title = new \Twig_Function('book_title', function ($id) {
                $model = new BooksModel();
                $data = $model->find($id);
                return $data->title;
            });
            self::$twig->addFunction($asset);
            self::$twig->addFunction($excerpt);
            self::$twig->addFunction($url);
            self::$twig->addFunction($title);
            self::$twig->addFunction($date);
            self::$twig->addFunction($description);
            self::$twig->addFunction($dump);
            self::$twig->addFunction($utf8);
            self::$twig->addFunction($utf8_encode);
            self::$twig->addFunction($book_title);
            isset($_SESSION['auth']) ? self::$twig->addGlobal('auth', $_SESSION['auth']) : self::$twig->addGlobal('auth', '');
        }
        return self::$twig;
    }
    public static function error() {
        header("HTTP/1.0 404 Not Found");
        $controller = new \App\Controllers\Controller();
        $controller->render('pages/404.twig', [
            'user'        => $_SESSION['auth']
        ]);
    }
    public static function redirect($path = '') {
        $location = 'Location: ' . Settings::getConfig()['url'] . $path;
        header($location);
    }
    public static function secured() {
        if(!isset($_SESSION['auth'])) {
            self::redirect('connexion');
            exit;
        }
    }
    public static function adminAccess() {
        if(isset($_SESSION['auth']) && $_SESSION['auth']->state == 1) {
            return true;
        }
        else {
            self::redirect('');
            exit;
        }
    }
}