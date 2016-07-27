<?php

namespace projectx\api\gameAccountType;

use Doctrine\DBAL\Connection;
use projectx\api\entity\GameAccountType;
use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class GameAccountTypeRepository
 * @package projectx\api\gameAccountType
 */
class GameAccountTypeRepository
{
    /** @var  Application */
    private $app;

    /** @var  Connection */
    private $connection;

    /**
     * GameAccountTypeRepository constructor.
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

        $gameAccountTypes = $this->connection->fetchAll($sql);

        $result = [];

        foreach ($gameAccountTypes as $gameAccountType) {
            $result[] = GameAccountType::createFromArray($gameAccountType);
        }

        return $result;
    }

    /**
     * @return string
     */
    public function getTableName()
    {
        return 'gameaccounttype';
    }

    /**
     * @param JsonResponse
     */
    public function create(GameAccountType $gameAccountType)
    {//TODO Check if id gen is ok
        $name = $gameAccountType->getName();
        if (isset($name)) {
            $gameAccountType->setId(md5($name));
        } else {
            $this->app->abort(400, 'A gameaccounttype need a name');
        }

        $data = $gameAccountType->jsonSerialize();
        //unset($data['owner_path']);
        foreach ($data as $key => $value) {
            if (empty($value)) {
                unset($data[$key]);
            }
        }

        $this->connection->insert("`{$this->getTableName()}`", $data);

        return $this->getById($gameAccountType->getId());
    }

    /**
     * @param $gameAccountTypeId"
     *
     * @return JsonResponse
     */
    public function getById($id)
    {
        $sql = <<<EOS
SELECT gat.*
FROM `{$this->getTableName()}` gat
WHERE gat.id = :id
EOS;

        $gameAccountTypes = $this->connection->fetchAll($sql, ['id' => $id]);
        if (count($gameAccountTypes) === 0) {
            $this->app->abort(400, "GameAccountType with id $id does not exist!");
        }
        return GameAccountType::createFromArray($gameAccountTypes[0]);
    }
}