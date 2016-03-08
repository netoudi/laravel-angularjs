<?php

namespace CodeProject\Services;


use CodeProject\Events\TaskWasIncluded;
use CodeProject\Repositories\ProjectTaskRepository;
use CodeProject\Validators\ProjectTaskValidator;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;
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

            $result = $this->repository->create($data);

            event(new TaskWasIncluded($result));

            return $result;
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

            $result = $this->repository->update($data, $noteId);

            event(new TaskWasIncluded($result));

            return $result;
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

    public function all($id = null, $limit = 6)
    {
        $this->setPresenter();
        if (!is_null($id)) {
            return $this->repository->findWhere(['project_id' => $id]);
        }

        return $this->repository->recentTasks(Authorizer::getResourceOwnerId(), $limit);
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