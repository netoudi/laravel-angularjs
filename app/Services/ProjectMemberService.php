<?php

namespace CodeProject\Services;


use CodeProject\Repositories\ProjectMemberRepository;
use CodeProject\Validators\ProjectMemberValidator;
use Prettus\Validator\Exceptions\ValidatorException;

class ProjectMemberService
{
    /**
     * @var ProjectMemberRepository
     */
    private $repository;
    /**
     * @var ProjectMemberValidator
     */
    private $validator;

    /**
     * @param ProjectMemberRepository $repository
     * @param ProjectMemberValidator $validator
     */
    public function __construct(ProjectMemberRepository $repository, ProjectMemberValidator $validator)
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

    public function all($id)
    {
        $this->setPresenter();
        return $this->repository->findWhere(['project_id' => $id]);
    }

    public function find($id, $memberId)
    {
        try {
            $this->setPresenter();
            return $this->repository->findWhere(['project_id' => $id, 'member_id' => $memberId]);
        } catch (\Exception $e) {
            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }
    }

    public function delete($id, $memberId)
    {
        try {
            $this->repository->findWhere(['project_id' => $id, 'member_id' => $memberId])[0]->delete();
        } catch (\Exception $e) {
            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }
    }

    private function setPresenter()
    {
        $this->repository->setPresenter('CodeProject\\Presenters\\ProjectMemberPresenter');
    }
}