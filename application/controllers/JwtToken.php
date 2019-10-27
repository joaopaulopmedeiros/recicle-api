<?php
//application/controllers/JwtToken.php
    require APPPATH . '/libraries/CreatorJwt.php';

    class JwtToken extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->objOfJwt = new CreatorJwt();
            header('Content-Type: application/json');
        }

        /*************Generate token this function use**************/

        public function LoginToken()
        {
                $tokenData['id'] = '1';
                $tokenData['user'] = 'joao';
                $tokenData['pass'] = "123456";
                $tokenData['timeStamp'] = Date('d/m/Y');
                $jwtToken = $this->objOfJwt->GenerateToken($tokenData);
                echo json_encode(array('Token'=>$jwtToken));
             }
         
       /*************Use for token then fetch the data**************/
             
        public function GetTokenData()
        {
        $received_Token = $this->input->request_headers('Authorization');
            try
            {
                $jwtData = $this->objOfJwt->DecodeToken($received_Token['Token']);
                echo json_encode($jwtData);
                }
                catch (Exception $e)
                {
                http_response_code('401');
                echo json_encode(array( "status" => false, "message" => "errou, boy"));exit;
            }
        }
    }
?>
