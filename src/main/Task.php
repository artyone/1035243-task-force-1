<?php


namespace app\main;


interface iTask
{
    public function listAllAction();
    public function listAllStatus();
    public function getNewStatus($newStatus);

}

class Task implements iTask
{
    const ACTION_NEW = 'newTask';
    const ACTION_START = 'startTask';
    const ACTION_CANCEL = 'cancelTask';
    const ACTION_REFUSE = 'refuseTask';
    const ACTION_COMPLETE = 'completeTask';

    const STATUS_NEW = 'new';
    const STATUS_EXECUTION = 'execution';
    const STATUS_CANCELED = 'cancel';
    const STATUS_FAILED = 'fail';
    const STATUS_DONE = 'done';

    public $userId;
    public $consumerId;
    public $status;
    public $createDate;
    public $expirationDate;

    public function __construct($userId = null, $createDate = null)
    {
        $this->userId = $userId;
        $this->createDate = $createDate;
    }

    public function listAllAction()
    {
        return $actions = [
            self::ACTION_NEW,
            self::ACTION_START,
            self::ACTION_CANCEL,
            self::ACTION_REFUSE,
            self::ACTION_COMPLETE
        ];
    }

    public function listAllStatus()
    {
        return $statuses = [
            self::STATUS_NEW,
            self::STATUS_EXECUTION,
            self::STATUS_DONE,
            self::STATUS_FAILED,
            self::STATUS_CANCELED
        ];
    }

    public function getNewStatus($newStatus)
    {
        switch ($newStatus) {

            case self::ACTION_NEW:
                return $this->status = self::STATUS_NEW;
            case self::ACTION_START:
                return $this->status = self::STATUS_EXECUTION;
            case self::ACTION_CANCEL:
                return $this->status = self::STATUS_CANCELED;
            case self::ACTION_REFUSE:
                return $this->status = self::STATUS_FAILED;
            case self::ACTION_COMPLETE:
                return $this->status = self::STATUS_DONE;
        }

        return null;
    }
}

