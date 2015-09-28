<?php

namespace CodeProject\Services;

use CodeProject\Repositories\ProjectFileRepository;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Validators\ProjectFileValidator;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Contracts\Filesystem\Factory as Storage;
use Illuminate\Filesystem\Filesystem;

class ProjectFileService
{
    /**
     * @var ProjectRepository
     */
    private $projectRepository;
    /**
     * @var ProjectFileRepository
     */
    private $repository;
    /**
     * @var ProjectFileValidator
     */
    private $validator;
    /**
     * @var Filesystem
     */
    private $filesystem;
    /**
     * @var Storage
     */
    private $storage;

    /**
     * @param ProjectRepository $projectRepository
     * @param ProjectFileRepository $repository
     * @param ProjectFileValidator $validator
     * @param Filesystem $filesystem
     * @param Storage $storage
     */
    public function __construct(ProjectRepository $projectRepository, ProjectFileRepository $repository, ProjectFileValidator $validator, Filesystem $filesystem, Storage $storage)
    {
        $this->projectRepository = $projectRepository;
        $this->repository = $repository;
        $this->validator = $validator;
        $this->filesystem = $filesystem;
        $this->storage = $storage;
    }

    public function create($projectId, $file, array $data)
    {
        try {
            $this->validator->with($data)->passesOrFail();

            $data['extension'] = $file->getClientOriginalExtension();
            $data['file'] = md5(date('Y-m-d H:i:s')) . "." . $data['extension'];

            $this->storage->put($data['file'], $this->filesystem->get($file));

            $project = $this->projectRepository->find($projectId);
            $file = $project->files()->create($data);

            return $this->find($projectId, $file->id);
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

    public function update($projectId, $fileId, $file, array $data)
    {
        try {
            if (is_null($file)) {
                $this->validator->setRules(['name' => 'required|max:255', 'description' => 'required']);
                $this->validator->with($data)->passesOrFail();

                $fileUpdate = $this->repository->findWhere(['project_id' => $projectId, 'id' => $fileId])->first();
                $fileUpdate->update($data, $fileId);

                return $this->find($projectId, $fileUpdate->id);
            }

            $this->validator->with($data)->passesOrFail();

            $fileUpdate = $this->repository->findWhere(['project_id' => $projectId, 'id' => $fileId])->first();

            $data['extension'] = $file->getClientOriginalExtension();
            $data['file'] = md5(date('Y-m-d H:i:s')) . "." . $data['extension'];

            $this->storage->put($data['file'], $this->filesystem->get($file));

            if ($this->storage->exists($fileUpdate->file)) {
                $this->storage->delete($fileUpdate->file);
            }

            $fileUpdate->update($data, $fileId);

            return $this->find($projectId, $fileUpdate->id);
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

    public function all($projectId)
    {
        $this->setPresenter();
        return $this->repository->findWhere(['project_id' => $projectId]);
    }

    public function find($projectId, $fileId)
    {
        try {
            $this->setPresenter();
            return $this->repository->findWhere(['project_id' => $projectId, 'id' => $fileId]);
        } catch (\Exception $e) {
            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }
    }

    public function delete($projectId, $fileId)
    {
        try {
            $file = $this->repository->findWhere(['project_id' => $projectId, 'id' => $fileId])->first();

            if (is_null($file)) {
                throw new \Exception('File not found.');
            }

            $this->storage->delete($file->file);

            $this->repository->findWhere(['project_id' => $projectId, 'id' => $fileId])[0]->delete();
        } catch (\Exception $e) {
            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }
    }

    private function setPresenter()
    {
        $this->repository->setPresenter('CodeProject\\Presenters\\ProjectFilePresenter');
    }
}