<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    //资源服务器拉取用户授权页面，用户授权后->获取资源服务器返回的code
    public function getcode(Request $request){
    	
    	$http = new \GuzzleHttp\Client();

		$response=$http->post('http://www.passportdev.com/oauth/token',[
			'form_params'=>[
				'grant_type'=>'authorization_code',
				'client_id'=>'3',
				'client_secret'=>'lOmlz05Cda7tmbbTXPO7kXCUDGLr8h0JLSnOEuzG',
				'redirect_uri'=>'http://www.passportclient.com/callback',
				'code'=>$request->code,
			],
		]);
		$tmp = json_decode((string) $response->getBody(),true);
    
		$access_token = $tmp['access_token'];
		
    	$http = new \GuzzleHttp\Client();
      
   		$header = ['Authorization'=>'Bearer '.$access_token ];
      
   		$request = new \GuzzleHttp\Psr7\Request('get','http://www.passportdev.com/api/user',$header);
      
   		$response = $http->send($request);

   	  dump(json_decode((string) $response->getBody(), true));

   	}
 	
}
