<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/dao/viking.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/utils/server.php';

header('Content-Type: application/json');

if (!methodIsAllowed('read')) {
    returnError(405, 'Method not allowed');
    return;
}

if (!isset($_GET['id'])) {
    returnError(400, 'Missing parameter: id');
}

$viking = findOneViking($_GET['id']);

if($viking['weapon']){
    $viking['weapon'] = "/weapon/findOne.php?id=" . $viking['weapon'];
}else{
    $viking['weapon'] = " ";
}

if (!$viking) {
    returnError(404, 'Viking not found');
}
echo json_encode($viking, JSON_UNESCAPED_SLASHES);
