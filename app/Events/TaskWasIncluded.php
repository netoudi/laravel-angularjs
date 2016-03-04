<?php

namespace CodeProject\Events;

use CodeProject\Entities\ProjectTask;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class TaskWasIncluded extends Event implements ShouldBroadcast
{
    use SerializesModels;
    /**
     * @var ProjectTask
     */
    public $projectTask;

    /**
     * Create a new event instance.
     *
     * @param ProjectTask $projectTask
     */
    public function __construct(ProjectTask $projectTask)
    {
        $this->projectTask = $projectTask;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['user.' . \Authorizer::getResourceOwnerId()];
    }
}
