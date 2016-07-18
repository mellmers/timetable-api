<?php

namespace projectx\api\bet;

use Doctrine\DBAL\Connection;
use projectx\api\entity\Bet;
use projectx\api\lobby\LobbyRepository;
use projectx\api\user\UserRepository;

/**
 * Class BetRepository
 * @package projectx\api\bet
 */
class BetRepository
{
    /** @var  Connection */
    private $connection;
    /** @var  UserRepository */
    private $userRepo;
    /** @var  LobbyRepository */
    private $lobbyRepo;

    /**
     * BetRepository constructor.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
        $this->userRepo = new UserRepository($this->connection);
        $this->lobbyRepo = new LobbyRepository($this->connection);
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

        $bets = $this->connection->fetchAll($sql);

        $result = [];
//        print_r($bets);

        foreach ($bets as $bet) {
            $bet = $this->loadUser($bet);
            $bet = $this->loadLobby($bet);
            $result[] = Bet::createFromArray($bet);
        }

        return $result;
    }

    /**
     * @return string
     */
    public function getTableName()
    {
        return 'bet';
    }

    /**
     * @param array $bet
     * @return array
     */
    private function loadUser(array $bet)
    {
        $userResult = $this->userRepo->getById($bet['user_id']);
        $bet['user'] = $userResult;
        return $bet;
    }

    /**
     * @param array $bet
     * @return array
     */
    private function loadLobby(array $bet)
    {
        $lobbyResult = $this->lobbyRepo->getById($bet['lobby_id']);
        $bet['lobby'] = $lobbyResult;
        return $bet;
    }

    /**
     * @param $userId
     * @param $lobbyId
     * @return Bet
     * @throws DatabaseException
     */
    public function getByIds($userId, $lobbyId)
    {
        $sql = <<<EOS
SELECT b.*
FROM `{$this->getTableName()}` b
WHERE b.user_id = :userId AND lobby_id = :lobbyId
EOS;

        $bets = $this->connection->fetchAll($sql, ['userId' => $userId, 'lobbyId' => $lobbyId]);
        if (count($bets) === 0) {
            throw new DatabaseException(
                sprintf('Bet with id "%d" does not exists!', $userId)
            );
        }
        $result = [];
        $bets[0] = $this->loadUser($bets[0]);
        $bets[0] = $this->loadLobby($bets[0]);
        $result[] = Bet::createFromArray($bets[0]);
        return $result;
    }

    /**
     * @param Bet $bet
     */
    public function create(Bet $bet)
    {
        $data = $bet->jsonSerialize();
        $this->connection->insert("`{$this->getTableName()}`", $data);
        $bet->setId($this->connection->lastInsertId());
    }
}