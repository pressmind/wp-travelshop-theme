<?php
$output = [];
$output['success'] = false;
if ((htmlspecialchars($_POST['api_key'])) && (htmlspecialchars($_POST['email'])) && (htmlspecialchars($_GET['formid'])) && (htmlspecialchars($_GET['listid']))) {
    $api = new SoapClient("https://api.cleverreach.com/soap/interface_v5.1.php?wsdl");
    $user = array(
        "email" => htmlspecialchars($_POST['email']),
        "registered" => time(),
        "activated" => "",
        "source" => "IB3",
        "attributes" => array(
            0 => array("key" => "title", "value" => htmlspecialchars($_POST['title'])),
            1 => array("key" => "firstname", "value" => htmlspecialchars($_POST['first_name'])),
            2 => array("key" => "lastname", "value" => htmlspecialchars($_POST['last_name'])),
            3 => array("key" => "country", "value" => htmlspecialchars($_POST['nationality'])),
            4 => array("key" => "salutation", "value" => htmlspecialchars($_POST['gender'])),
        ),
    );
    $result = $api->receiverAdd(htmlspecialchars($_POST['api_key']), htmlspecialchars($_GET['listid']), $user);
    $doidata = array(
        "user_ip" => $_SERVER['REMOTE_ADDR'],
        "user_agent" => htmlspecialchars($_SERVER['HTTP_USER_AGENT']),
        "referer" => $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
        "postdata" => "title:" . htmlspecialchars($_POST['title']) . ",firstname:" . htmlspecialchars($_POST['first_name']) . ",lastname:" . htmlspecialchars($_POST['last_name']) . ",country:" . htmlspecialchars($_POST['nationality']) . ",salutation:" . htmlspecialchars($_POST['gender']),
        "info" => "IB3",
    );
    // $result = $api->formsSendActivationMail(htmlspecialchars($_POST['api_key']), htmlspecialchars($_GET['formid']), htmlspecialchars($_POST['email']), $doidata);
    $result = $api->formsActivationMail(htmlspecialchars($_POST['api_key']), htmlspecialchars($_GET['formid']), htmlspecialchars($_POST['email']));
    if($result->status == "SUCCESS") {
        $output['success'] = true;
    }
    $output['message'] = $result->message;
} else {
    $output['message'] = "api_key,email,listid and/or form id missing.";
}
header('Content-Type: application/json');
echo json_encode($output, JSON_PRETTY_PRINT);
exit;
