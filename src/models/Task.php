<?php


namespace app\models;

use app\models\actions\CancelAction;
use app\models\actions\CompleteAction;
use app\models\actions\NewAction;
use app\models\actions\RefuseAction;
use app\models\actions\StartAction;

class Task
{
    const STATUS_NEW = 'new';
    const STATUS_EXECUTION = 'execution';
    const STATUS_CANCELED = 'cancel';
    const STATUS_FAILED = 'fail';
    const STATUS_DONE = 'done';

    public $initiatorId;
    private $customer;
    private $executor;
    private $status;
    private $createDate;
    private $expirationDate;


    public function __construct()
    {
        $this->createDate = time();
        $this->status = self::STATUS_NEW;
    }

    public function getCustomer()
    {
        return $this->customer;
    }

    public function getExecutor()
    {
        return $this->executor;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setCustomer($user)
    {
        $this->customer = $user;
    }

    public function setExecutor($user)
    {
        $this->executor = $user;
    }

    public function setInitiator($user)
    {
        $this->initiatorId = $user;
    }


    public function listAllAction(): array
    {
        return $actions = [
            NewAction::getActionName(),
            StartAction::getActionName(),
            CancelAction::getActionName(),
            RefuseAction::getActionName(),
            CompleteAction::getActionName()
        ];
    }

    public function listAllStatus(): array
    {
        return $statuses = [
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
        if (NewAction::verifyAction($this)) {
            $result[] = NewAction::getActionName();
        }
        if (StartAction::verifyAction($this)) {
            $result[] = StartAction::getActionName();
        }
        if (CancelAction::verifyAction($this)) {
            $result[] = CancelAction::getActionName();
        }
        if (RefuseAction::verifyAction($this)) {
            $result[] = RefuseAction::getActionName();
        }
        if (CompleteAction::verifyAction($this)) {
            $result[] = CompleteAction::getActionName();
        }
        return $result;
    }

    public function start()
    {
        if (StartAction::verifyAction($this)) {
            return $this->status = self::STATUS_EXECUTION;
        }
        return null;
    }

    public function cancel()
    {
        if (CancelAction::verifyAction($this)) {
            return $this->status = self::STATUS_CANCELED;
        }
        return null;
    }

    public function refuse()
    {
        if (RefuseAction::verifyAction($this)) {
            return $this->status = self::STATUS_FAILED;
        }
        return null;
    }

    public function complete()
    {
        if (CompleteAction::verifyAction($this)) {
            return $this->status = self::STATUS_DONE;
        }
        return null;
    }

}
