<?php

declare(strict_types=1);

namespace App;

use App\Controller\ProcessController;

class Router
{
    private string $request_method;
    private array $uri;
    private array $params;
    private array $data;

    public function __construct()
    {
        $this->request_method = $_SERVER['REQUEST_METHOD'];
        $this->uri = parse_url($_SERVER['REQUEST_URI']);
        $this->params = $_GET;
        $this->data = json_decode(file_get_contents('php://input'), true);
    }

    public function run()
    {
        $id = null;
        $path = $this->uri['path'];
        $pathParts = explode('/', $path);

        if ($pathParts[1] === 'processes') {
            $controller = new ProcessController();

            if (isset($pathParts[2])) {
                if (!is_numeric($pathParts[2])) {
                    exit('Unsupported URI');
                }

                $id = (int) $pathParts[2];
            }

            switch (true) {
                // GET http://127.0.0.1:8000/processes список всех процессов
                case $this->request_method === 'GET' && $id === null:
                    echo $controller->index($this->params);
                    break;

                // POST http://127.0.0.1:8000/processes создать процесс
                case $this->request_method === 'POST' && $id === null:
                    echo $controller->store($this->data);
                    break;

                // GET http://127.0.0.1:8000/processes/{id} создать процесс
                case $this->request_method === 'GET' && $id !== null:
                    echo $controller->show($id);
                    break;

                // POST http://127.0.0.1:8000/processes/{id} добавить 1 или несколько полей в процесс
                case $this->request_method === 'POST' && $id !== null:
                    echo $controller->addFields($id, $this->data);
                    break;
            }
        } else {
            exit('Unsupported URI');
        }
    }
}
