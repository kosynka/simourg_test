<?php

declare(strict_types=1);

namespace App\Controller;

use App\Enum\FieldType;
use App\Presenter\ProcessPresenter;
use App\Repository\ProcessRepository;

class ProcessController extends Controller
{
    private ProcessRepository $processRepository;

    public function __construct()
    {
        $this->processRepository = new ProcessRepository();
    }

    public function index(array $params = []): bool|string
    {
        $processes = $this->processRepository->fetchAll($params);

        return $this->jsonResponse([
            'message' => 'Success',
            'data' => ProcessPresenter::collection($processes),
        ], 200);
    }

    public function store(array $data): bool|string
    {
        // TODO: validate $data for Process creation
        $process = $this->processRepository->create($data['name']);

        if ($process !== null) {
            $response['message'] = 'Success';
            $response['data'] = ProcessPresenter::item($process);
            $code = 200;
        } else {
            $response['message'] = 'Error';
            $response['data'] = null;
            $code = 500;
        }

        return $this->jsonResponse($response, $code);
    }

    public function show(int $id): bool|string
    {
        $process = $this->processRepository->findOne($id);

        if (!$process) {
            return $this->jsonResponse(['message' => 'Not found'], 404);
        }

        return $this->jsonResponse([
            'message' => 'Success',
            'data' => ProcessPresenter::item($process),
        ], 200);
    }

    public function addFields(int $id, array $data): bool|string
    {
        if (!$this->validateFields($data)) {
            return $this->jsonResponse(['message' => 'Invalid data'], 400);
        }

        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['type'] === FieldType::NUMBER->value && isset($data[$i]['format'])) {
                $data[$i]['number_format'] = $data[$i]['format'];
                $data[$i]['date_format'] = null;
                unset($data[$i]['format']);
            } elseif ($data[$i]['type'] === FieldType::DATE->value && isset($data[$i]['format'])) {
                $data[$i]['date_format'] = $data[$i]['format'];
                $data[$i]['number_format'] = null;
                unset($data[$i]['format']);
            } else {
                $data[$i]['date_format'] = null;
                $data[$i]['number_format'] = null;
            }
        }

        $process = $this->processRepository->findOne($id);

        if (!$process) {
            return $this->jsonResponse(['message' => 'Not found'], 404);
        }

        $data = $this->processRepository->addFields($id, $data);

        return $this->jsonResponse([
            'message' => 'Success',
            'data' => ProcessPresenter::item($process),
        ], 200);
    }

    public function validateFields(array &$fields): bool
    {
        foreach ($fields as $field) {
            if (!isset($field['name']) || !is_string($field['name'])) {
                return false;
            }

            if (!isset($field['type']) || !is_string($field['type'])) {
                return false;
            }

            if (!isset($field['value'])) {
                return false;
            }
        }

        return true;
    }
}
