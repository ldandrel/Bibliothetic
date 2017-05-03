<?php
namespace App\Models;

use \App\System\App;
use \PHPMailer;
use \App\System\Settings;



class Model {
    
    protected $table;





    public function update($id, $fields) {
        $sql_parts  = [];
        $attributes = [];

        foreach($fields as $k => $v) {
            $sql_parts[]  = "$k = ?";
            $attributes[] = $v;
        }

        $sql_part = implode(', ', $sql_parts);
        App::getDb()->execute("UPDATE {$this->table} SET $sql_part WHERE id = $id", $attributes);
    }

    public function delete($id){
        App::getDb()->execute("DELETE FROM {$this->table} WHERE id = $id");
    }

    public function create($fields) {
        $sql_parts  = [];
        $attributes = [];

        foreach($fields as $k => $v) {
            $sql_parts[]  = "$k = ?";
            $attributes[] = $v;
        }

        $sql_part = implode(', ', $sql_parts);

        App::getDb()->execute("INSERT INTO {$this->table} SET $sql_part", $attributes);
    }

    public function query($statement, $attributes = null, $one = false) {
        if($attributes){
            return App::getDb()->prepare(
                $statement,
                $attributes,
                $one
            );
        }

        else {
            return App::getDb()->query(
                $statement,
                $one
            );
        }
    }

    public function mailer($to, $subject, $body) {
        date_default_timezone_set('Etc/UTC');
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host =  Settings::getConfig()['mail']['host'];
        $mail->Port = Settings::getConfig()['mail']['port'];
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth = true;
        $mail->CharSet = 'UTF-8';
        $mail->Username = Settings::getConfig()['mail']['username'];
        $mail->Password = Settings::getConfig()['mail']['password'];
        $mail->setFrom(Settings::getConfig()['mail']['from'], Settings::getConfig()['name']);
        $mail->addReplyTo(Settings::getConfig()['mail']['from'], Settings::getConfig()['name']);
        $mail->addAddress($to);
        $mail->Subject = $subject;
        $mail->msgHTML($body);
        if (!$mail->send()) {
            return false;
        } else {
            return true;
        }


    }

}
