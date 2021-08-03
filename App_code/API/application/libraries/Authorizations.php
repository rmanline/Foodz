<?php
/*
  Authors : initappz (Rahul Jograna)
  Website : https://initappz.com/
  App Name : ionic 5 groceryee app
  Created : 10-Sep-2020
  This App Template Source code is licensed as per the
  terms found in the Website https://initappz.com/license
  Copyright and Good Faith Purchasers © 2020-present initappz.
*/


class Authorizations{

    public $secretKey  = '!@(..!.)mylongsecretcodewithjwt/Vk7mLQyzqaS34Q4oR1ew=(..!.)';
    // 1 = admin
    // 2 = store
    // 3 = User
    // 4 = driver
	function verify($autToken = null) {
        try {
            if($autToken !=null){
                $jwt = new JWT();
                $decrypt = $jwt->urlsafeB64Decode($autToken);
                $token = $jwt->decode($decrypt, $this->secretKey, 'HS256');
                $now = new DateTimeImmutable();
                $serverName = base_url();
                
                if ($token->iss !== $serverName || $token->nbf > $now->getTimestamp() || $token->exp < $now->getTimestamp()){
                    $response = 401;
                }else{
                    $response = 200;
                }
            }else{
                $response = 404;
            }

            return $response;
        } catch (\Throwable $th) {
            return 500;
        }

	}

    function verifyAdminToken($autToken = null) {
        try {
            if($autToken !=null){
                $jwt = new JWT();
                $decrypt = $jwt->urlsafeB64Decode($autToken);
                $token = $jwt->decode($decrypt, $this->secretKey, 'HS256');
                $now = new DateTimeImmutable();
                $serverName = base_url();
                
                if ($token->iss !== $serverName || $token->irl !== '1' || $token->nbf > $now->getTimestamp() || $token->exp < $now->getTimestamp()){
                    $response = 401;
                }else{
                    $response = 200;
                }
            }else{
                $response = 404;
            }
            return $response;
        } catch (\Throwable $th) {
            return 500;
        }
		
	}

    function verifyStoreToken($autToken = null) {
        try {
            if($autToken !=null){
                $jwt = new JWT();
                $decrypt = $jwt->urlsafeB64Decode($autToken);
                $token = $jwt->decode($decrypt, $this->secretKey, 'HS256');
                $now = new DateTimeImmutable();
                $serverName = base_url();
                
                if ($token->iss !== $serverName || $token->irl !== '2' || $token->nbf > $now->getTimestamp() || $token->exp < $now->getTimestamp()){
                    $response = 401;
                }else{
                    $response = 200;
                }
            }else{
                $response = 404;
            }
            return $response;
        } catch (\Throwable $th) {
            return 500;
        }
		
	}

    function generate($id=null,$role=null){
        if($id !=null && $role !=null){
            $issuedAt   = new DateTimeImmutable();
            $expire     = $issuedAt->modify('+15 days')->getTimestamp();      // minutes, days,hours,years
            $serverName = base_url();

            $data = [
                'iat'  => $issuedAt->getTimestamp(),         // Issued at: time when the token was generated
                'iss'  => $serverName,                       // Issuer
                'nbf'  => $issuedAt->getTimestamp(),         // Not before
                'exp'  => $expire,                           // Expire
                'irl' => $role,                              // User name
                'iid' =>$id                                  // UID
            ];

            $jwt = new JWT();
            
            $token =  $jwt->encode($data,$this->secretKey,'HS256');
            $crypt = $jwt->urlsafeB64Encode($token);
            
            $response = [
                'status'=>true,
                'code'=>200,
                'token'=>$crypt,
            ];    
            return $response;
        }else{
            $response = [
                'status'=>false,
                'code'=>400,
                'message'=>'Bad Request'
            ];    
            return $response;
        }
    }

    function getAuthorizationHeader(){
        $headers = null;
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        }
        else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            //print_r($requestHeaders);
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }
        return $headers;
    }


     function getBearerToken() {
        $headers = $this->getAuthorizationHeader();
        if (!empty($headers)) {
            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                return $matches[1];
            }
        }
        return null;
    }

}
?>