<?php

namespace projectx\api\game;

use Doctrine\DBAL\Connection;
use projectx\api\Application;
use projectx\api\entity\Game;

/**
 * Class GameRepository
 * @package projectx\api\game
 */
class GameRepository
{
    /** @var  Application */
    private $app;

    /** @var  Connection */
    private $connection;

    /**
     * GameRepository constructor.
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

        $games = $this->connection->fetchAll($sql);

        $result = [];

        foreach ($games as $game) {
            $result[] = Game::createFromArray($game);
        }

        return $result;
    }

    /**
     * @return string
     */
    public function getTableName()
    {
        return 'game';
    }

    /**
     * @param $genre
     * @return array
     */
    public function getByGenre($genre)
    {
        $sql = <<<EOS
SELECT g.*
FROM `{$this->getTableName()}` g
WHERE g.genre = :genre
EOS;

        $games = $this->connection->fetchAll($sql, ['genre' => $genre]);
        if (count($games) === 0) {
            $this->app->abort(400, 'No games with the genre: ' . $genre);
        }
        $result = [];
        foreach ($games as $game) {
            $result[] = Game::createFromArray($game);
        }
        return $result;
    }

    /**
     * @param Game $game
     */
    public function create(Game $game)
    {
        if (!isset($game->getName())) {
            $this->app->abort(400, 'A game need a name');
        } else if(!isset($game->getTyp())) {
            $this->app->abort(400, 'A game need a type');
        } else if(!isset($game->getRules())) {
            $this->app->abort(400, 'A game need rules');
        }  else if(!isset($game->getGenre())) {
            $this->app->abort(400, 'A game need a genre');
        }  else if(!isset($game->getTimelimit())) {
            $this->app->abort(400, 'A game need a timelimit');
        }

        $game->setId(Application::generateGUIDv4());
        $data = $game->jsonSerialize();
        foreach ($data as $key => $value) {
            if (empty($value)) {
                unset($data[$key]);
            }
        }

        $this->connection->insert("`{$this->getTableName()}`", $data);

        return $this->getById($game->getId());
    }

    /**
     * @param $gameId
     * @return array
     */
    public function getById($id)
    {
        $sql = <<<EOS
SELECT g.*
FROM `{$this->getTableName()}` g
WHERE g.id = :id
EOS;

        $games = $this->connection->fetchAll($sql, ['id' => $id]);
        if (count($games) === 0) {
            $this->app->abort(400, "Game with id $id does not exist!");
        }
        $result[] = Game::createFromArray($games[0]);
        return $result;
    }
}