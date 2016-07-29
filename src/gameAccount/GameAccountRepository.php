<?php

namespace projectx\api\gameAccount;

use Doctrine\DBAL\Connection;
use projectx\api\entity\GameAccount;
use projectx\api\gameAccountType\GameAccountTypeRepository;
use projectx\api\user\UserRepository;
use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class GameAccountRepository
 * @package projectx\api\gameAccount
 */
class GameAccountRepository
{
    /** @var  Application\ */
    private $app;

    /** @var  Connection */
    private $connection;

    /**
     * GameAccountRepository constructor.
     *
     * @param Application $app
     * @param Connection $connection
     */
    public function __construct(Application $app, Connection $connection)
    {
        $this->app = $app;
        $this->connection = $connection;
    }

    /**
     * @return array
     */
    public function getAll()
    {
        $sql = <<<EOS
SELECT *
FROM `{$this->getTableName()}`
EOS;

        $gameAccounts = $this->connection->fetchAll($sql);

        $result = [];
//        print_r($gameAccounts);

        foreach ($gameAccounts as $gameAccount) {
            $gameAccount = $this->loadUser($gameAccount);
            $gameAccount = $this->loadGameAccountType($gameAccount);
            $result[] = GameAccount::createFromArray($gameAccount);
        }
        return $result;
    }

    /**
     * @return string
     */
    public function getTableName()
    {
        return 'gameaccount';
    }

    /**
     * @param array $gameAccount
     * @return array
     */
    private function loadUser(array $gameAccount)
    {
        $userRepo = new UserRepository($this->app, $this->connection);
        $userResult = $userRepo->getById($gameAccount['userId']);
        $gameAccount['user'] = $userResult;
        return $gameAccount;
    }

    /**
     * @param array $gameAccount
     * @return array
     */
    private function loadGameAccountType(array $gameAccount)
    {
        $gATRepo = new GameAccountTypeRepository($this->app, $this->connection);
        $gATResult = $gATRepo->getById($gameAccount['gameaccountTypeId']);
        $gameAccount['gameaccountType'] = $gATResult;
        return $gameAccount;
    }

    /**
     * @param $userId
     * @return array
     */
    public function getByUserId($userId)
    {
        $sql = <<<EOS
SELECT ga.*
FROM `{$this->getTableName()}` ga
WHERE ga.userId = :userId
EOS;

        $gameAccounts = $this->connection->fetchAll($sql, ['userId' => $userId]);
        if (count($gameAccounts) === 0) {
            $this->app->abort(400, "User with id $userId has no GameAccounts.");
        }
        $result = [];
        foreach ($gameAccounts as $gameAccount) {
            $gameAccount = $this->loadUser($gameAccount);
            $gameAccount = $this->loadGameAccountType($gameAccount);
            $result[] = GameAccount::createFromArray($gameAccount);
        }
        return $result;
    }

    /**
     * @param $gameAccountTypeId
     * @return array
     */
    public function getByTypeId($gameAccountTypeId)
    {
        $sql = <<<EOS
SELECT ga.*
FROM `{$this->getTableName()}` ga
WHERE ga.gameAccountTypeId = :gameAccountTypeId
EOS;

        $gameAccounts = $this->connection->fetchAll($sql, ['gameAccountTypeId' => $gameAccountTypeId]);
        if (count($gameAccounts) === 0) {
            $this->app->abort(400, "GameAccounts type id $gameAccountTypeId has no GameAccounts.");
        }
        $result = [];
        foreach ($gameAccounts as $gameAccount) {
            $gameAccount = $this->loadUser($gameAccount);
            $gameAccount = $this->loadGameAccountType($gameAccount);
            $result[] = GameAccount::createFromArray($gameAccount);
        }
        return $result;
    }

    /**
     * @param GameAccount $gameAccount
     */
    public function create(GameAccount $gameAccount)
    {
        $userId = $gameAccount->getUserId();
        $typeId = $gameAccount->getGameAccountTypeId();
        if (isset($userId) && isset($typeId)) {

        } else {
            $this->app->abort(400, 'A gameaccount needs a user and a accounttye');
        }

        $data = $gameAccount->jsonSerialize();
        unset($data['user_path'], $data['user'], $data['gameaccountType_path'], $data['gameaccountType']);
        foreach ($data as $key => $value) {
            if (empty($value)) {
                unset($data[$key]);
            }
        }

        $this->connection->insert("`{$this->getTableName()}`", $data);

        return $this->getByIdAndType($userId, $typeId);
    }

    /**
     * @param $userId
     * @param $gameAccountTypeId
     *
     * @return JsonResponse
     */
    public function getByIdAndType($userId, $gameaccountTypeId)
    {
        $sql = <<<EOS
SELECT ga.*
FROM `{$this->getTableName()}` ga
WHERE ga.userId = :userId AND ga.gameaccountTypeId = :gameaccountTypeId
EOS;

        $gameAccounts = $this->connection->fetchAll($sql, ['userId' => $userId, 'gameaccountTypeId' => $gameaccountTypeId]);
        if (count($gameAccounts) === 0) {
            $this->app->abort(400, "GameAccount with id $userId and type $gameaccountTypeId does not exist.");
        }
        $gameAccounts[0] = $this->loadUser($gameAccounts[0]);
        $gameAccounts[0] = $this->loadGameAccountType($gameAccounts[0]);
        return GameAccount::createFromArray($gameAccounts[0]);
    }

    /**
     * @param $userId
     * @param $gameaccountTypeId
     *
     * @return GameAccount
     */
    public function deleteGameAccountType($userId, $gameaccountTypeId)
    {
        $gameAccount = $this->getByIdAndType($userId, $gameaccountTypeId);
        $sql = <<<EOS
DELETE
FROM `{$this->getTableName()}`
WHERE userId = :userId AND gameaccountTypeId = :gameaccountTypeId
EOS;
        try {
            $this->connection->executeQuery($sql, ['userId' => $userId, 'gameaccountTypeId' => $gameaccountTypeId]);
        } catch (\Doctrine\DBAL\DBALException $e) {
            $this->app->abort(400, "GameAccount with id $gameaccountTypeId does not exist.");
        }
        return $gameAccount;
    }

}