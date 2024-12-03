<?php

function methodIsAllowed(string $action): bool {
    $method = $_SERVER['REQUEST_METHOD'];
    switch ($action) {
        case 'create':
            return $method == 'PUT';
        case 'read':
            return $method == 'GET';
        case 'update':
            return in_array($method, ['PATCH', 'PUT']);
        case 'delete':
            return $method == 'DELETE';
        default:
            return false;
    }
}

function getBody(): array {
    $body = file_get_contents('php://input');
    return json_decode($body, true);
}

function returnError(int $code, string $message) {
    http_response_code($code);
    echo json_encode(['error' => $message]);
    exit();
}

function validateMandatoryParams(array $data, array $mandatoryParams): bool {
    foreach ($mandatoryParams as $param) {
        if (!isset($data[$param])) {
            return false;
        }
    }
    return true;
}
