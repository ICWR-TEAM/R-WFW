<?php

namespace App\Models;

use App\Core\Model;

class AuthTestModel extends Model
{
    public $auth;

    public function Auth(): bool|string
    {
        if ($input = json_decode(json: file_get_contents(filename: "php://input"), associative: true)) {
            if ($input['username'] === "username" && $input['password'] === "password") {
                $payload = [
                    "message" => "success"
                ];
                
                $jwt = $this->auth->generateJwt(payload: $payload, expired: 1800);

                return json_encode(value: [
                    "status" => "200",
                    "message" => "success",
                    "data" => [
                        "token" => $jwt
                    ]
                ]);
            } else {
                return json_encode(value: [
                    "status" => "401",
                    "message" => "Invalid username or password!"
                ]);
            }
        } else {
            return json_encode(value: [
                "status" => "500",
                "message" => "error"
            ]);
        }
    }

    public function Check(): bool|string
    {
        if ($input = json_decode(json: file_get_contents(filename: "php://input"), associative: true)) {
            if ($response = $this->auth->verifyJwt(token: $input['token'])) {
                return json_encode(value: $response);
            } else {
                return json_encode(value: $response);
            }
        } else {
            return json_encode(value: [
                "status" => "500",
                "message" => "error"
            ]);
        }
    }

    public function CheckHeader(): bool|string
    {
        if ($response = $this->auth->verifyAuthHeader()) {
                return json_encode(value: $response);
        } else {
            return json_encode(value: [
                "status" => "500",
                "message" => "error"
            ]);
        }
    }

}
