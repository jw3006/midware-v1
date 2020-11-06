<?php
defined('BASEPATH') or exit('No direct script access allowed');

class BP_Token
{
    public function _get_tokens($data)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://ibluatcommonapi.scmprofit.net:80/token",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "grant_type=" . $data["grant_type"] . "&username=" . $data["username"] . "&password=" . $data["password"] . "",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/x-www-form-urlencoded"
            ),
        ));

        $response = curl_exec($curl);
        $curl_err = curl_errno($curl);
        curl_close($curl);

        if (!$curl_err) {
            if ($response) {
                $resp_json = json_decode($response, true);
                if (!$resp_json['error']) {
                    $CI = &get_instance();
                    $data = array(
                        'id' => '1',
                        'date' => date('Y-m-d H:i:s'),
                        'token_type' => $resp_json['token_type'],
                        'expires_in' => date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . " + 1 days")),
                        'access_token' => $resp_json['access_token'],
                    );
                    $CI->db->replace('tb_token', $data);
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
