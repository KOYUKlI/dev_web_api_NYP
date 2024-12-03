<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/dao/viking.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/dao/weapon.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/utils/server.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/viking/service.php';

header('Content-Type: application/json');

if (!methodIsAllowed('create')) {
    returnError(405, 'Method not allowed');
    return;
}

$data = getBody();

if (validateMandatoryParams($data, ['name', 'health', 'attack', 'defense'])) {
    verifyViking($data);

    $weaponId = isset($data['weaponId']) ? intval($data['weaponId']) : null;

    if ($weaponId !== null) {
        $weapon = findOneWeapon($weaponId);
        if (!$weapon) {
            returnError(400, 'Weapon does not exist');
        }
    }

    $newVikingId = createViking($data['name'], $data['health'], $data['attack'], $data['defense'], $weaponId);
    if (!$newVikingId) {
        returnError(500, 'Could not create the viking');
    }
    echo json_encode(['id' => $newVikingId]);
    http_response_code(201);
} else {
    returnError(412, 'Mandatory parameters: name, health, attack, defense');
}
