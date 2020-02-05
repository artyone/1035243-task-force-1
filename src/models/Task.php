<?php


namespace app\models;

use app\models\actions\CancelAction;
use app\models\actions\CompleteAction;
use app\models\actions\NewAction;
use app\models\actions\RefuseAction;
use app\models\actions\StartAction;
use app\exception\StatusException;
use app\exception\RoleException;
use app\exception\ActionException;

class Task
{
    const STATUS_NEW = 'new';
    const STATUS_EXECUTION = 'execution';
    const STATUS_CANCELED = 'cancel';
    const STATUS_FAILED = 'fail';
    const STATUS_DONE = 'done';

    private $creation_time;
    private $name;
    private $category_id;
    private $location_id;
    private $address_comments;
    private $description;
    private $price;
    private $customer_id;
    private $executor_id;
    private $deadline_time;
    private $status;
    private $initiatorId;

    public function __construct()
    {
        $this->creation_time = time();
        $this->status = self::STATUS_NEW;
    }

    public function getCustomerId(): int
    {
        return $this->customer_id;
    }

    public function getExecutorId(): int
    {
        return $this->executor_id;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getDeadlineTime(): string
    {
        return $this->deadline_time;
    }

    public function setCustomerId(int $user)
    {
        $this->customer_id = $user;
    }

    public function setExecutorId(int $user)
    {
        $this->executor_id = $user;
    }

    public function setDeadlineTime(string $time)
    {
        $this->deadline_time = $time;
    }

    public function setInitiatorId(int $user)
    {
        $this->initiatorId = $user;
    }


    public function listAllAction(): array
    {
        return [
            NewAction::getActionName(),
            StartAction::getActionName(),
            CancelAction::getActionName(),
            RefuseAction::getActionName(),
            CompleteAction::getActionName()
        ];
    }

    public function listAllStatus(): array
    {
        return [
            self::STATUS_NEW,
            self::STATUS_EXECUTION,
            self::STATUS_DONE,
            self::STATUS_FAILED,
            self::STATUS_CANCELED
        ];
    }

    public function getNewStatus(string $action): ?string
    {
        switch ($action) {
            case NewAction::getActionName():
                return $this->status = self::STATUS_NEW;
            case StartAction::getActionName():
                return $this->status = self::STATUS_EXECUTION;
            case CancelAction::getActionName():
                return $this->status = self::STATUS_CANCELED;
            case RefuseAction::getActionName():
                return $this->status = self::STATUS_FAILED;
            case CompleteAction::getActionName():
                return $this->status = self::STATUS_DONE;
        }
        return null;
    }

    public function getAvailableActions(): array
    {
        $result = [];
        if (NewAction::verifyAction($this, $this->initiatorId)) {
            $result[] = NewAction::getActionName();
        }
        if (StartAction::verifyAction($this, $this->initiatorId)) {
            $result[] = StartAction::getActionName();
        }
        if (CancelAction::verifyAction($this, $this->initiatorId)) {
            $result[] = CancelAction::getActionName();
        }
        if (RefuseAction::verifyAction($this, $this->initiatorId)) {
            $result[] = RefuseAction::getActionName();
        }
        if (CompleteAction::verifyAction($this, $this->initiatorId)) {
            $result[] = CompleteAction::getActionName();
        }
        return $result;
    }

    public function start(): ?string
    {
        if (!StartAction::verifyAction($this, $this->initiatorId)) {
            throw new StatusException('Ошибка при установке статуса '. self::STATUS_EXECUTION);
        }
        return $this->status = self::STATUS_EXECUTION;
    }

    public function cancel(): ?string
    {
        if (!CancelAction::verifyAction($this, $this->initiatorId)) {
            throw new StatusException('Ошибка при установке статуса ' . self::STATUS_CANCELED);
        }
        return $this->status = self::STATUS_CANCELED;
    }

    public function refuse(): ?string
    {
        if (!RefuseAction::verifyAction($this, $this->initiatorId)) {
            throw new StatusException('Ошибка при установке статуса ' . self::STATUS_FAILED);
        }
        return $this->status = self::STATUS_FAILED;
    }

    public function complete(): ?string
    {
        if (!CompleteAction::verifyAction($this, $this->initiatorId)) {
            throw new StatusException('Ошибка при установке статуса ' . self::STATUS_DONE);
        }
        return $this->status = self::STATUS_DONE;
    }

}
