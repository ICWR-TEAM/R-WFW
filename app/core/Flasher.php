<?php

namespace App\Core;

class Flasher
{

    public static function setFlash(string $msg, string $act, string $type): void
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

    public static function flash(): void
    {
        if (isset($_SESSION['flash'])) {
            echo '<script>alert("' . $_SESSION['flash']['msg'] . '");</script>';
            unset($_SESSION['flash']);
        }
    }
}
