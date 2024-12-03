<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/dao/weapon.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/dao/viking.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/utils/server.php';

header('Content-Type: application/json');

if (!methodIsAllowed('delete')) {
    returnError(405, 'Method not allowed');
    return;
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $deleted = deleteWeapon($id);
    if ($deleted == 1) {
        // Mettre à jour les vikings qui avaient cette arme
        $db = getDatabaseConnection();
        $sql = "UPDATE viking SET weaponId = NULL WHERE weaponId = :weaponId";
        $stmt = $db->prepare($sql);
        $stmt->execute(['weaponId' => $id]);

        http_response_code(204);
    } elseif ($deleted == 0) {
        returnError(404, 'Weapon not found');
    } else {
        returnError(500, 'Could not delete the weapon');
    }
} else {
    returnError(400, 'Missing parameter: id');
}
