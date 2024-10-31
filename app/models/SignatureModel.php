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
                $this->response->setStatusCode(statusCode: 400);
                return json_encode(value: [
                    "status" => "400",
                    "message" => "Invalid JSON Payload!"
                ]);
            }
        } else {
            $this->response->setStatusCode(statusCode: 500);
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
            $this->response->setStatusCode(statusCode: 500);
            return json_encode(value: [
                "status" => "500",
                "message" => "error"
            ]);
        }
    }

    public function SignSpecific(): bool|string
    {
        if ($input = file_get_contents(filename: "php://input")) {

            if (json_decode(json: $input) !== null && json_last_error() === JSON_ERROR_NONE) {
                $input_array = json_decode(json: $input, associative: true);
                $data = [
                    "amount" => $input_array['amount'],
                    "qty" => $input_array['qty']
                ];

                $json_generate = json_encode(value: $data);
                $this->auth->generateSignature(data: $json_generate);

                return json_encode(value: [
                    "status" => "200",
                    "message" => "success",
                    "data" => $data
                ]);
            } else {
                $this->response->setStatusCode(statusCode: 400);
                return json_encode(value: [
                    "status" => "400",
                    "message" => "Invalid JSON Payload!"
                ]);
            }
        } else {
            $this->response->setStatusCode(statusCode: 500);
            return json_encode(value: [
                "status" => "500",
                "message" => "error"
            ]);
        }
    }

    public function SignSpecificCheck(): bool|string
    {

        if ($input = file_get_contents(filename: "php://input")) {

            if (json_decode(json: $input, associative: true) !== null && json_last_error() === JSON_ERROR_NONE) {
                $input_decode = json_decode(json: $input, associative: true);
                $receivedSignature = $_SERVER['HTTP_X_SIGNATURE'] ?? '';

                $input_data = [
                    "amount" => $input_decode['data']['amount'],
                    "qty" => $input_decode['data']['qty']
                ];

                $data = json_encode(value: $input_data);

                if ($this->auth->verifySignature(data: $data, signature: $receivedSignature)) {
                    return json_encode(value: [
                        "status" => "200",
                        "message" => "success",
                        "data" => [
                            "data" => $input_data
                        ]
                    ]);
                } else {
                    $this->response->setStatusCode(statusCode: 403);
                    return json_encode(value: [
                        "status" => "error",
                        "code" => 403,
                        "message" => "Invalid Signature."
                    ]);
                }
            }
        }

        $this->response->setStatusCode(statusCode: 400);
        return json_encode(value: [
            "status" => "400",
            "message" => "Invalid JSON Payload!"
        ]);
    }
}
