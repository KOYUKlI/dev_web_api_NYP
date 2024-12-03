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

$weaponId = intval($_GET['id']);
$vikings = findVikingsByWeapon($weaponId);

if (!$vikings) {
    returnError(404, 'No vikings found with the given weapon');
}

echo json_encode($vikings);
