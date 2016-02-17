<?php

namespace CodeProject\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface ProjectRepository
 * @package namespace CodeProject\Repositories;
 */
interface ProjectRepository extends RepositoryInterface
{
    public function isOwner($projectId, $userId);

    public function hasMember($projectId, $memberId);

    public function findOwner($userId, $limit = null, $columns = array());

    public function findWithOwnerAndMember($userId);
}
