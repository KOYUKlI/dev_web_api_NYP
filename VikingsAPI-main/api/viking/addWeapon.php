<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/dao/viking.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/dao/weapon.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/utils/server.php';

header('Content-Type: application/json');

if (!methodIsAllowed('update')) {
    returnError(405, 'Method not allowed');
}

if (!isset($_GET['id'])) {
    returnError(400, 'Missing parameter: id');
}

$vikingId = intval($_GET['id']);
$data = getBody();

if (!isset($data['weaponId'])) {
    returnError(400, 'Missing parameter in body: weaponId');
}

$weaponId = intval($data['weaponId']);

if ($weaponId !== null) {
    $weapon = findOneWeapon($weaponId);
    if (!$weapon) {
        returnError(400, 'Weapon does not exist');
    }
}

$updated = updateVikingWeapon($vikingId, $weaponId);
if ($updated == 1) {
    http_response_code(204);
} elseif ($updated == 0) {
    returnError(404, 'Viking not found');
} else {
    returnError(500, 'Could not update the viking');
}
