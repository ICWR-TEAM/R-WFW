<?php

namespace App\Models;

use App\Core\Model;

class SignatureModel extends Model
{
    public $auth;

    public function Create(): bool|string
    {
        if ($input = file_get_contents(filename: "php://input")) {
            if (json_decode(json: $input) !== null && json_last_error() === JSON_ERROR_NONE) {
                
                $signature = $this->auth->generateSignature(data: $input);

                return json_encode(value: [
                    "status" => "200",
                    "message" => "success",
                    "data" => [
                        "signature" => $signature
                    ]
                ]);
            } else {
                return json_encode(value: [
                    "status" => "401",
                    "message" => "Invalid JSON Payload!"
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
        if (file_get_contents(filename: "php://input")) {
            if ($response = $this->auth->verifySignatureHeader()) {
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

}
