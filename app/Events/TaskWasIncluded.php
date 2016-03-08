<?php

namespace CodeProject\Events;

use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class TaskWasIncluded extends Event implements ShouldBroadcast
{
    use SerializesModels;

    /**
     * @var array
     */
    public $projectTask;

    public function __construct(array $projectTask)
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
