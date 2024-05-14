<?php

use App\Controller\ProcessController;

include __DIR__ . '/logger.php';
include __DIR__ . '/vendor/autoload.php';

if (strpos($_SERVER['REQUEST_URI'], '/process') !== 0) {
    exit('Unsupported URI');
}

$controller = new ProcessController();

$request_method = $_SERVER['REQUEST_METHOD'];
$data = json_decode(file_get_contents('php://input'), true);
$params = $_GET['params'] ?? null;
$id = $_GET['id'] ?? null;

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        $controller->store($data);
        break;
    case 'GET':
        $id ? $controller->show($id) : $controller->index();
        break;
    case 'PUT':
        $controller->update($id, $data);
        break;
    case 'DELETE':
        $controller->delete($id);
        break;
    default:
        throw new \Exception('Unsupported');
}
