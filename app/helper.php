<?php
function app_constants()
{
    return [
        'TOKEN_EXPIRED' => 'You session has expired, please login to renew your session',

//        Event
        'EVENT_CREATED' => 'Event created successfully',
        'INVALID_EVENT_TYPE' => 'Event type specified does not exist.',
        'DUPLICATE_EVENT_TITLE' => 'Event title has already been used for another event',
        'INVALID_EVENT' => 'Event does not exist',
        'REGISTRATION_EXISTS' => 'The names provided had already been registered for this event.',
        'EVENT_DATA' => 'Event and it\'s registrations',
        'EVENTS_DATA' => 'Events and their registrations',
        'EVENT_DEL_SUCCESSFUL' => 'Event was deleted successfully',
        'EVENT_UPDATED' => 'Event was updated successfully',
        'INVALID_REGISTRATION_NUMBER' => 'Invalid Registration Number',
        'EVENT_CHECKIN_SUCCESSFUL' => 'Event check-in was successfully',
        'EVENT_REG_DATA' => 'Event registration and it\'s check-in meta data',
        'ADDRESS_UPDATED' => 'Address has been added',

//        Member
        'INVALID_MEMBER' => "The member does not exist",
        'PASSWORD_CHANGE_SUCCESSFUL' => "Password change successful.",
        'INVALID_PASSWORD' => 'The password you specified does not match your registered password, please try again with the right password.',
        'INVALID_OLD_PASSWORD' => 'The old password your specified does not match your registered password, please try again with the right password.',
        'INVALID_EMAIL' => "There is no account linked to the email you provided.",
        'MEM_PROFILE_UPDATED' => "Your profile has been updated successful",

//        Forgot Password
        'PASSWORD_RESET_LINK_SENT' => "Reset link has been sent to the email.",


//        AUTH

        'TOKEN_INVALIDATED' => 'Your session has expired, please log in to continue',
        'TOKEN_INVALID' => 'Illegal access. Please log in or register',
        'TOKEN_GEN' => 'Successfully logged you into the app',
        'INVALID_CREDENTIALS' => 'The login credentials you used is not valid, please check and retry.',
        'TOKEN_REFRESHED' => 'Your session has been refreshed.',
        'MEMBER' => 'Member details',
        'MEMBER_NOT_FOUND' => 'Member details does not exist',
        'TOKEN_CREATION_ERR' => 'We are sorry but we could not log you into the app. A group of experts are already on this matter. ',


//        MISCELLANEOUS
        'PROCESSING' => 'The action is being processed and would be resolved soon.',
        'PUSH_MESSAGE' => 'Message has been sent to device.',

        'RESET_EMAIL_SENT' => 'The email reset link has been successfully sent to your email. Use the link provided in the email to reset your password. ',
        'EMAIL_FROM' => "Event Hub",

//        CODE
        'VALIDATION_EXCEPTION_CODE' => '402',
        'TOKEN_INVALID_CODE' => '401',
        'TOKEN_INVALIDATED_CODE' => '406',
        'EXCEPTION_CODE' => '500',

//       Exceptions
        'VALIDATION_EXCEPTION' => 'You did not fill one or more required fields in the form. Please fill all the required fields.',
        'INVALID_EMAIL_EXCEPTION' => 'We could not send a reset link to the email because the email does not have an account attached to it.',
        'REG_VALIDATION_EXCEPTION' => 'The email you chose already has an account. Try logging into the app with your email  and retry your registration again.',
        'EXCEPTION' => 'This is embarrassing. Something went wrong while trying to process your request but a group of experts are already on this matter.',
    ];
}


function genericResponse($message = null, $status_code = null, $request = null, $trace = null)
{
    $app_const = app_constants();
    $code = ($status_code != null) ? $status_code : "404";
    $body = [
        'message' => "$message",
        'code' => $code,
        'status_code' => $code,
        'status' => false
    ];


    if (!is_null($request)) {
        save_log($request, $body);
        if ($code == "500") {
            $trace = (!is_null($trace) && is_array($trace)) ? $trace : [];
            $message = 'URL : ' . $request->fullUrl() .
                '<br /> METHOD: ' . $request->method() .
                '<br /> DATA_PARAM: ' . json_encode($request->all()) .
                '<br /> RESPONSE: ' . json_encode($body) .
                '<br /> <b> Trace: ' . json_encode($trace) . "</b>";
//            sendEmail($message, 'API ERROR ALERT', "{$app_const['EMAIL_FROM']}", 'ndu4george@gmail.com');
        }
    }

    return response()->json($body)->setStatusCode("$code");
}


function save_log($request, $response)
{
    return \App\ApiLog::create([
        'url' => $request->fullUrl(),
        'method' => $request->method(),
        'data_param' => json_encode($request->all()),
        'response' => json_encode($response),
    ]);
}


function generic_logger($fullUrl = null, $method = null, $param, $response)
{
    \App\ApiLog::create([
        'url' => $fullUrl,
        'method' => $method,
        'data_param' => json_encode($param),
        'response' => json_encode($response),
    ]);
}


function validResponse($message = null, $data = [], $request = null)
{
    $body = [
        'message' => "$message",
        'data' => $data,
        'status' => true
    ];

    if (!is_null($request)) {
        save_log($request, $body);
    }

    return response()->json($body)->setStatusCode("200");
}


function isValidEmail($email)
{
    return (boolean)filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match('/@.+\./', $email);
}


function sendEmail($message_data, $subject, $from, $to, $type = null)
{
    if (!$type) {
        $type = "default";
    }
    $info['message'] = $message_data;
    $info['from'] = $from;
    $info['email'] = $to;
    $info['subject'] = $subject;


    \Illuminate\Support\Facades\Mail::send('emails.' . $type, compact('message_data', 'info'), function ($message) use ($info) {
        $message->from("noreply@event-hub.com", "5Platters");
        $message->bcc($info['email'])->subject($info['subject']);
    });

}


function search_query_constructor($searchString, $col)
{
    $dataArray = (array_filter(explode(" ", trim($searchString))));
    $constructor_sql = "(";
    if (count($dataArray) < 1) {
        return " 1 ";
    }
    if (is_array($col)) {
        foreach ($col as $col_name) {
            if ($col_name !== $col[0]) {
                $constructor_sql .= " OR ";
            }
            for ($i = 0; $i < count($dataArray); $i++) {
                if (count($dataArray) - 1 === $i) {
                    $constructor_sql .= "$col_name LIKE '%{$dataArray[$i]}%' ";
                } else {
                    $constructor_sql .= "$col_name LIKE '%{$dataArray[$i]}%' OR ";
                }
            }
        }
    } else {
        for ($i = 0; $i < count($dataArray); $i++) {
            if (count($dataArray) - 1 === $i) {
                $constructor_sql .= "$col LIKE '%{$dataArray[$i]}%' ";
            } else {
                $constructor_sql .= "$col LIKE '%{$dataArray[$i]}%' OR ";
            }
        }
    }
    $constructor_sql .= ")";
    return $constructor_sql;
}

function multi_unset($array, $keys)
{
    if (is_array($array)) {
        foreach ($keys as $key) {
            unset($array[$key]);
        }

        return $array;

    } else {
        return null;
    }
}


function encrypt3Des($data, $key = "BKhjatdfXhbTYUErbekj")
{
    //Generate a key from a hash
    $key = md5(utf8_encode($key), true);
    //Take first 8 bytes of $key and append them to the end of $key.
    $key .= substr($key, 0, 8);

    $encData = openssl_encrypt($data, 'DES-EDE3', $key, OPENSSL_RAW_DATA);
    return base64_encode($encData);
}

function decrypt3Des($data, $secret = "BKhjatdfXhbTYUErbekj")
{
    //Generate a key from a hash
    $key = md5(utf8_encode($secret), true);
    //Take first 8 bytes of $key and append them to the end of $key.
    $key .= substr($key, 0, 8);
    $data = base64_decode($data);

    $decData = openssl_decrypt($data, 'DES-EDE3', $key, OPENSSL_RAW_DATA);

    return $decData;
}

function getResetPasswordURL($email)
{
    return url('/reset-password?q=' . urlencode($email));
}



function useJSON($url, $username, $apikey, $flash, $sendername, $messagetext, $recipients) {
    $gsm = array();
    $country_code = '234';
    $arr_recipient = explode(',', $recipients);
    foreach ($arr_recipient as $recipient) {
        $mobilenumber = trim($recipient);
        if (substr($mobilenumber, 0, 1) == '0'){
            $mobilenumber = $country_code . substr($mobilenumber, 1);
        }
        elseif (substr($mobilenumber, 0, 1) == '+'){
            $mobilenumber = substr($mobilenumber, 1);
        }
        $generated_id = uniqid('int_', false);
        $gsm['gsm'][] = array('msidn' => $mobilenumber, 'msgid' => $generated_id);
    }
    $message = array(
        'sender' => $sendername,
        'messagetext' => $messagetext,
        'flash' => "{$flash}",
    );

    $request = array('SMS' => array(
        'auth' => array(
            'username' => $username,
            'apikey' => $apikey
        ),
        'message' => $message,
        'recipients' => $gsm
    ));
    $json_data = json_encode($request);
    if ($json_data) {
        $response = doPostRequest($url, $json_data, array('Content-Type: application/json'));
        $result = json_decode($response);
        return $result->response->status;
    } else {
        return false;
    }
}

function useXML($url, $username, $apikey, $flash, $sendername, $messagetext, $recipients) {
    $country_code = '234';
    $arr_recipient = explode(',', $recipients);
    $count = count($arr_recipient);
    $msg_ids = array();
    $recipients = '';

    $xml = new SimpleXMLElement('<SMS></SMS>');
    $auth = $xml->addChild('auth');
    $auth->addChild('username', $username);
    $auth->addChild('apikey', $apikey);

    $msg = $xml->addChild('message');
    $msg->addChild('sender', $sendername);
    $msg->addChild('messagetext', $messagetext);
    $msg->addChild('flash', $flash);

    $rcpt = $xml->addChild('recipients');
    for ($i = 0; $i < $count; $i++) {
        $generated_id = uniqid('int_', false);
        $generated_id = substr($generated_id, 0, 30);
        $mobilenumber = trim($arr_recipient[$i]);
        if (substr($mobilenumber, 0, 1) == '0') {
            $mobilenumber = $country_code . substr($mobilenumber, 1);
        } elseif (substr($mobilenumber, 0, 1) == '+') {
            $mobilenumber = substr($mobilenumber, 1);
        }
        $gsm = $rcpt->addChild('gsm');
        $gsm->addchild('msidn', $mobilenumber);
        $gsm->addchild('msgid', $generated_id);
    }
    $xmlrequest = $xml->asXML();

    if ($xmlrequest) {
        $result = doPostRequest($url, $xmlrequest, array('Content-Type: application/xml'));
        $xmlresponse = new SimpleXMLElement($result);
        return $xmlresponse->status;
    }
    return false;
}

function useHTTPGet($url, $username, $apikey, $flash, $sendername, $messagetext, $recipients) {
    $query_str = http_build_query(array('username' => $username, 'apikey' => $apikey, 'sender' => $sendername, 'messagetext' => $messagetext, 'flash' => $flash, 'recipients' => $recipients));
    return file_get_contents("{$url}?{$query_str}");
}

//Function to connect to SMS sending server using HTTP POST
function doPostRequest($url, $arr_params, $headers = array('Content-Type: application/x-www-form-urlencoded')) {
    $response = array();
    $final_url_data = $arr_params;
    if (is_array($arr_params)) {
        $final_url_data = http_build_query($arr_params, '', '&');
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $final_url_data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
    curl_setopt($ch, CURLOPT_VERBOSE, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    $response['body'] = curl_exec($ch);
    $response['code'] = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return $response['body'];
}

function encrypt_decrypt($action, $string)
{
    try {

        $output = false;

        $encrypt_method = "AES-256-CBC";
        $secret_key = 'H899JHShjdfhjhejkse@14447DP';
        $secret_iv = 'TYEHVn0dUIK888JSBGDD';

        // hash
        $key = hash('sha256', $secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        if ($action == 'encrypt') {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if ($action == 'decrypt') {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }

        return $output;

    } catch (Exception $e) {
        return false;
    }
}

function pending_orders(){
    $orders = \App\Order::wherebetween('status',[1,2])->count();
    return $orders;
}


function dispatchers(){
    $dispatcher = \App\Dispatcher::all();
    return $dispatcher;
}

function food_status($status){
        if($status == "0"){
            return "<div class='label label-danger'>Failed</div>";
        }else if($status =="1"){
            return "<div class='label label-default'>Food received</div>";
        }else if($status == "2"){
            return "<div class='label label-warning'>Food dispatched</div>";
        }else if($status == "3"){
            return "<div class='label label-success'>Food successfully delivered</div>";
        }else{
            return "<div class='label label-danger'>Rejected</div>";
        }
    }