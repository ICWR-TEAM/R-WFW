<?php

class Flasher
{

    public static function setFlash($msg, $act, $type)
    {

        $_SESSION['flash'] = [

            'msg' => $msg

            /*
            'msg' => $msg,
            'act'  => $act,
            'type'  => $type
            */

        ];

    }

    public static function flash()
    {
        if( isset($_SESSION['flash']) ) {

            echo '<script>alert("' . $_SESSION['flash']['msg'] . '");</script>';
            unset($_SESSION['flash']);

        }
    }

}