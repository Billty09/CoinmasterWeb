<?php
 class cmapi{
	const CURL_TIMEOUT = 3600;
    const CONNECT_TIMEOUT = 30;
    private function Curl($method, $url, $header, $data, $cookie){
		$curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => $header,
        ));
        
        $result = curl_exec($curl);
        if (curl_errno($curl)) { 
            print curl_error($curl); 
        }
		return ($result);
        curl_close($ch);
    }

    private function headertoken(){
		$header = array(
            'User-Agent: Dalvik/2.1.0 (Linux; U; Android 5.1.1; SM-N976N Build/QP1A.190711.020)',
            'X-CLIENT-VERSION: 3.5.230',
            'X-PLATFORM: Android',
            'Authorization: Bearer '.$this->sessionToken
        );
		return $header;
    }
    
    public function accept_invitation(){
        // $url = 'https://vik-game.moonactive.net/api/v1/users/ror48__ckkimnb4s01klpll43jg8328y/accept_invitation';
        // $data = array(
        //     'Device[udid]' => 'f7bbe92e-652b-460c-8661-d4055b02be81'
        //     ,'API_KEY' => 'viki'
        //     ,'API_SECRET' => 'coin'
        //     ,'Device[change]' => ''
        //     ,'fbToken' => ''
        //     ,'locale' => 'en'
        //     ,'inviter' => 'ror43__ckjtvpw1v01djlllgdeeq9vzl'
        // );
        // $accept_invitation = $this->Curl("POST", $url, $this->headertoken(), $data, false);
        // $register = json_decode($accept_invitation);
        // print_r($register);
    }

    public function FacebookToken(){
        $tokenArr = [
            '395246678211876|Nc55uELrN7LFmSzx8NukLnmX8qI'	
            ,'333634617793866|kWgUPgcGg3bZBZ59hVXBHMva_fg'	
            ,'3221339467948484|cqi_xGosUj4ywr5F76GAjnO8ccE'	
            ,'660057474867552|c4sZJWmfO5ZBZudmsbxCMEvOb8k'		
        ];
        for($i=0; $i<=3; $i++){
            $curl = curl_init();
            curl_setopt_array($curl, array(
                //3221339467948484%7Ccqi_xGosUj4ywr5F76GAjnO8ccE
                CURLOPT_URL => 'https://graph.facebook.com/3221339467948484/accounts/test-users?access_token='.$tokenArr[$i].'&installed=true&permissions=read_stream&method=post',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
            ));
            $response = curl_exec($curl);
            if (curl_errno($curl)) { 
                print curl_error($curl); 
            }
            curl_close($curl);
            $token = json_decode($response,true);
            if(isset($token['access_token'])){break;}
        }
        return $token['access_token'];
    }

    private function update_fb_data(){
        $url = 'https://vik-game.moonactive.net/api/v1/users/'.$this->BotID.'/update_fb_data';
        $data = array(
            'Device[udid]' => $this->DeviceID
            ,'API_KEY' => 'viki'
            ,'API_SECRET' => 'coin'
            ,'Device[change]' => '20210128_8'
            ,'fbToken' => ''
            ,'locale' => 'en'
            ,'User[fb_token]' => $this->FacebookToken()
            //,'User[fb_token]' => 'EAAtxyoqwIcQBAIL5Te9nOn5RkdqgAw3dp4lSLTnK2cQLLKq7CYlR7BAlOBHZBKBgrZAfDXajuX9pgbINKbq7xJeGmZCTZCC7R2BuvDSPzHPB5P4iP5FMPjh9jQAzKDOECWBfTmlPZA2PYJMTPjvNDo138KrvgrxzPefpZCz8QgBcTFFAMWBiVxV9e4K9K6YPcBXZBdeZCXO2SQZDZD'
            ,'p' => 'fb'
            ,'Client[version]' => '3.5.230_fband'
        );
        return $this->Curl('POST', $url, $this->headertoken(), $data, false);
    }
    
    private function balance(){
        $url = 'https://vik-game.moonactive.net/api/v1/users/'.$this->BotID;
        $data = array(
            'Device[udid]' => $this->DeviceID
            ,'API_KEY' => 'viki'
            ,'API_SECRET' => 'coin'
            ,'Device[change]' => '20210128_8'
            ,'fbToken' => ''
            ,'locale' => 'en'
            ,'Device[os]' => 'Android'
            ,'Client[version]' => '3.5.230'
            ,'extended' => 'true'
            ,'segmented' => 'true'
        );
        return $this->Curl('POST', $url, $this->headertoken(), $data, false);
    }

    private function friends(){
        $url = 'https://vik-game.moonactive.net/api/v1/users/'.$this->BotID.'/friends';
        $data = array(
            'Device[udid]' => $this->DeviceID
            ,'API_KEY' => 'viki'
            ,'API_SECRET' => 'coin'
            ,'Device[change]' => '20210128_8'
            ,'fbToken' => ''
            ,'locale' => 'en'
            ,'non_players' => '500'
            ,'p' => 'fb'
            ,'snfb' => 'true'
        );
        return $this->Curl('POST', $url, $this->headertoken(), $data, false);
    }

    private function upgrade($item, $state){
        $url = 'https://vik-game.moonactive.net/api/v1/users/'.$this->BotID.'/upgrade';
        $data = array(
            'Device[udid]' => $this->DeviceID
            ,'API_KEY' => 'viki'
            ,'API_SECRET' => 'coin'
            ,'Device[change]' => '20210128_8'
            ,'fbToken' => '5dbb3068baab926036ec'
            ,'locale' => 'en'
            ,'item' => $item
            ,'state' => $state
            ,'include[0]' => 'pets'
        );
        return $this->Curl('POST', $url, $this->headertoken(), $data, false);
    }

    private function spin($seq){
        $url = 'https://vik-game.moonactive.net/api/v1/users/'.$this->BotID.'/spin';
        $data = array(
            'Device[udid]' => $this->DeviceID
            ,'API_KEY' => 'viki'
            ,'API_SECRET' => 'coin'
            ,'Device[change]' => '20210128_8'
            ,'fbToken' => ''
            ,'locale' => 'en'
            ,'seq' => $seq
            ,'auto_spin' => 'false'
            ,'bet' => '1'
            ,'Client[version]' => '3.5.230_fband'
        );
        return $this->Curl('POST', $url, $this->headertoken(), $data, false);
    }

    private function attack(){
        $url = 'https://vik-game.moonactive.net/api/v1/users/'.$this->BotID.'/targets/11111111/attack/structures/Statue';
        $data = array(
            'Device[udid]' => $this->DeviceID
            ,'API_KEY' => 'viki'
            ,'API_SECRET' => 'coin'
            ,'Device[change]' => '20210128_8'
            ,'fbToken' => ''
            ,'locale' => 'en'
            ,'state' => '13'
        );
        return $this->Curl('POST', $url, $this->headertoken(), $data, false);
    }

    private function raid($ID){
        $url = 'https://vik-game.moonactive.net/api/v1/users/'.$this->BotID.'/raid/dig/'.$ID;
        $data = array(
            'Device[udid]' => $this->DeviceID
            ,'API_KEY' => 'viki'
            ,'API_SECRET' => 'coin'
            ,'Device[change]' => '20210128_8'
            ,'fbToken' => ''
            ,'locale' => 'en'
        );
        return $this->Curl('POST', $url, $this->headertoken(), $data, false);
    }

    private function read_sys_messages(){
        $url = 'https://vik-game.moonactive.net/api/v1/users/ror48__ckkimnb4s01klpll43jg8328y/read_sys_messages';
        $data = array(
            'Device[udid]' => '817cdaf8-4f20-4951-a4f8-c6c3cf872ac6'
            ,'API_KEY' => 'viki'
            ,'API_SECRET' => 'coin'
            ,'Device[change]' => '20210128_8'
            ,'fbToken' => ''
            ,'locale' => 'en'
            ,'1611925897778' => 'delete'
        );
    }

    private function pending_requests($RequestLink){
        $url = 'https://vik-game.moonactive.net/api/v1/users/'.$this->BotID.'/friends/v2/'.$RequestLink.'/pending_requests';
        $data = array(
            'Device[udid]' => $this->DeviceID
            ,'API_KEY' => 'viki'
            ,'API_SECRET' => 'coin'
            ,'Device[change]' => '20210128_8'
            ,'fbToken' => ''
            ,'locale' => 'en'
        );
        return $this->Curl('POST', $url, $this->headertoken(), $data, false);
    }

    private function approve_request($InviteID){
        $url = 'https://vik-game.moonactive.net/api/v1/users/'.$this->BotID.'/friends/v2/'.$InviteID.'/approve_request';
        $data = array(
            'Device[udid]' => $this->DeviceID
            ,'API_KEY' => 'viki'
            ,'API_SECRET' => 'coin'
            ,'Device[change]' => '20210128_8'
            ,'fbToken' => ''
            ,'locale' => 'en'
        );
        return $this->Curl('POST', $url, $this->headertoken(), $data, false);
    }

    public function GetInviteID($link){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $link,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        if (curl_errno($curl)) { 
            print curl_error($curl); 
        }

        curl_close($curl);
        // $left =  explode('&amp;c=',$response);
        // $right =  explode('&amp;af_',$left[1]);
        $left = explode('&amp;c=',$response);
        $right = explode('&amp;af_',$left[1]);
        return ($right[0]);
    }

    public function start($Invite, $BotID, $DeviceID, $SessionToken){
        //SaveDeviceState
        $host = "localhost";
        $username = "tamapiin_tam1993";
        $password = "Tam260736";
        $db = "tamapiin_coinmaster";
        $objConnect = mysqli_connect($host,$username,$password,$db);
        $update = "UPDATE `devicetoken` SET `UseStatus` = '1' WHERE `DeviceID` = '" . $DeviceID. "';";
        mysqli_query($objConnect, $update);
        $InviteID = $this->GetInviteID($Invite);
        $this->BotID = $BotID;
        $this->DeviceID = $DeviceID;
        $this->sessionToken = $SessionToken;
        $Status = '';

        $left =  explode('com/~',$Invite);
        $right = explode('?s=m',$left[1]);
        $RequestLink = $right[0];
        //$this->accept_invitation(); --ติดcookies
        $update_fb_data = $this->update_fb_data(); 
        $Json = json_decode($update_fb_data);
        if(isset($Json->message)){
            //echo count($Json->message);
            if($Json->message == 'ANOTHER_DEVICE_IS_CONNECTING'){
                $Status = "PleaseUpdateSession";
            }else{
                $Status = "Err";
            }         
            exit();  
        }

        $balance = $this->balance();
        $friends = $this->friends();
        $upgrade = $this->upgrade('House','0');
        for($i=2;$i<=19;$i++){
            $response = $this->spin($i);
        }
        $attack = $this->attack();
        // for($i=13;$i<=15;$i++){
        //     $response = $this->spin($i);
        // }
        for($i=1;$i<=3;$i++){
            $response = $this->raid($i);
        }
        // for($i=16;$i<=19;$i++){
        //     $response = $this->spin($i);
        // }
        $pending_requests = $this->pending_requests($RequestLink);
        $approve_request = $this->approve_request($InviteID);
        $balance = $this->balance();
        $upgrade = $this->upgrade('House','1');
        $Status = "Ok";

        return $Status;
        
    }

    public function GetDevice(){
        $host = "localhost";
        $username = "tamapiin_tam1993";
        $password = "Tam260736";
        $db = "tamapiin_coinmaster";
        $objConnect = mysqli_connect($host,$username,$password,$db);
        $Select = "SELECT * FROM `devicetoken` WHERE UseStatus = 0 ORDER BY ID asc LIMIT 1";
        $result = mysqli_query($objConnect, $Select);

        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo "{\"ID\":\"" . $row["ID"]. "\",\"DeviceID\":\"". $row["DeviceID"]. "\",\"DeviceToken\":\"" . $row["DeviceToken"]."\"}";
            }
        } else {
            echo "0 results";
        }
          
    }

    public function GetDeviceLeft(){
        $host = "localhost";
        $username = "tamapiin_tam1993";
        $password = "Tam260736";
        $db = "tamapiin_coinmaster";
        $objConnect = mysqli_connect($host,$username,$password,$db);
        $Select = "SELECT count(*) total FROM `devicetoken` WHERE UseStatus = 0";
        $result = mysqli_query($objConnect, $Select);

        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo $row["total"];
            }
        } else {
            echo "0 results";
        }
          
    }

    public function updatedevice($deviceid){
    $host = "localhost";
        $username = "tamapiin_tam1993";
        $password = "Tam260736";
        $db = "tamapiin_coinmaster";
        $objConnect = mysqli_connect($host,$username,$password,$db);
        $update = "UPDATE `devicetoken` SET `UseStatus` = '1' WHERE `DeviceID` = '" . $deviceid. "';";
        mysqli_query($objConnect, $update);
    }
 }

?>