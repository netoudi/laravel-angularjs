<?php

namespace CodeProject\Services;


use CodeProject\Repositories\ProjectTaskRepository;
use CodeProject\Validators\ProjectTaskValidator;
use Prettus\Validator\Exceptions\ValidatorException;

class ProjectTaskService
{
    /**
     * @var ProjectTaskRepository
     */
    private $repository;
    /**
     * @var ProjectTaskValidator
     */
    private $validator;

    /**
     * @param ProjectTaskRepository $repository
     * @param ProjectTaskValidator $validator
     */
    public function __construct(ProjectTaskRepository $repository, ProjectTaskValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function create(array $data)
    {
        try {
            $this->validator->with($data)->passesOrFail();
            $this->setPresenter();
            return $this->repository->create($data);
        } catch (ValidatorException $e) {
            return [
                'error' => true,
                'message' => $e->getMessageBag()
            ];
        } catch (\Exception $e) {
            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }
    }

    public function update(array $data, $noteId)
    {
        try {
            $this->validator->with($data)->passesOrFail();
            $this->setPresenter();
            return $this->repository->update($data, $noteId);
        } catch (ValidatorException $e) {
            return [
                'error' => true,
                'message' => $e->getMessageBag()
            ];
        } catch (\Exception $e) {
            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }
    }

    public function all($id)
    {
        $this->setPresenter();
        return $this->repository->findWhere(['project_id' => $id]);
    }

    public function find($id, $noteId)
    {
        try {
            $this->setPresenter();
            $result = $this->repository->findWhere(['project_id' => $id, 'id' => $noteId]);
            if (isset($result['data']) && count($result['data'] == 1)) {
                $result = [
                    'data' => $result['data'][0]
                ];
            }
            return $result;
        } catch (\Exception $e) {
            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }
    }

    public function delete($noteId)
    {
        try {
            $this->repository->find($noteId)->delete();
        } catch (\Exception $e) {
            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }
    }

    private function setPresenter()
    {
        $this->repository->setPresenter('CodeProject\\Presenters\\ProjectTaskPresenter');
    }
}