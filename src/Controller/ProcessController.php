<?php

namespace App\Controller;

use App\Model\Process;

class ProcessController extends Controller
{
    public function index(array $params = [])
    {
        $response['data'] = Process::fetchAll($params);

        return $this->jsonResponse($response, 200);
    }

    public function store(array $params)
    {
        // TODO:
        $process = new Process(0, $params['process_name']);

        if (!$process) {
            return $this->jsonResponse(['message' => 'Process not found'], 404);
        }

        $process->setName($params['process_name']);

        if ($process->save()) {
            $response = ['message' => 'Process updated'];
            $code = 200;
        } else {
            $response = ['message' => 'Error updating process'];
            $code = 500;
        }

        return $this->jsonResponse($response, $code);
    }

    public function show(int $id)
    {
        $process = Process::findOne($id);
        $code = 200;

        $response['data'] = $process;
        $code = 200;

        if (!$process) {
            $response['message'] = 'Process not found';
            $code = 404;
        }

        return $this->jsonResponse($response, $code);
    }

    public function update(int $id, array $params)
    {
        $process = Process::findOne($id);

        if (!$process) {
            return $this->jsonResponse(['message' => 'Process not found'], 404);
        }

        $process->setName($params['process_name']);

        if ($process->save()) {
            $response = ['message' => 'Process updated'];
            $code = 200;
        } else {
            $response = ['message' => 'Error updating process'];
            $code = 500;
        }

        return $this->jsonResponse($response, $code);
    }

    public function delete(int $id)
    {
        $process = Process::findOne($id);

        if (!$process) {
            return $this->jsonResponse(['message' => 'Process not found'], 404);
        }

        if ($process->delete()) {
            $response = ['message' => 'Process deleted'];
            $code = 200;
        } else {
            $response = ['message' => 'Error deleting process'];
            $code = 500;
        }

        return $this->jsonResponse($response, $code);
    }
}
