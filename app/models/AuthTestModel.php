<?php

namespace App\Models;

use App\Core\Model;

class AuthTestModel extends Model
{
    public $auth;

    public function Auth()
    {
        if ($input = json_decode(file_get_contents("php://input"), true)) {
            if ($input['username'] === "username" && $input['password'] === "password") {
                $payload = [
                    "message" => "success"
                ];
                
                $jwt = $this->auth->generateJwt($payload, 1800);

                return json_encode([
                    "status" => "200",
                    "message" => "success",
                    "data" => [
                        "token" => $jwt
                    ]
                ]);
            } else {
                return json_encode([
                    "status" => "401",
                    "message" => "Invalid username or password!"
                ]);
            }
        } else {
            return json_encode([
                "status" => "500",
                "message" => "error"
            ]);
        }
    }

    public function Check()
    {
        if ($input = json_decode(file_get_contents("php://input"), true)) {
            if ($response = $this->auth->verifyJwt($input['token'])) {
                return json_encode($response);
            } else {
                return json_encode($response);
            }
        } else {
            return json_encode([
                "status" => "500",
                "message" => "error"
            ]);
        }
    }

}
