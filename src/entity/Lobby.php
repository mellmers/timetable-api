<?php
/**
 * Created by PhpStorm.
 * User: Jonas
 * Date: 08/06/2016
 * Time: 14:26
 */

namespace projectx\api\entity;


class Lobby implements \JsonSerializable
{
    /**
     * @var int
     * @SWG\Property(type="integer", format="int32")
     */
    private $id;

    /**
     * @var int
     * @SWG\Property(type="integer", format="int32")
     */
    private $ownerId;

    /**
     * @var int
     * @SWG\Property(type="integer", format="int32")
     */
    private $gameId;

    /**
     * @var int
     * @SWG\Property(type="integer", format="int32")
     */
    private $winnerTeam;

    /**
     * @var int
     * @SWG\Property(type="integer", format="int32")
     */
    private $createdAt;

    /**
     * @var int
     * @SWG\Property(type="integer", format="int32")
     */
    private $starttime;

    /**
     * @var int
     * @SWG\Property(type="integer", format="int32")
     */
    private $endtime;
    

    public static function createFromArray(array $row)
    {
        $gameAccountType = new self();
        if (array_key_exists('id', $row)) {
            $gameAccountType->setId($row['id']);
        }
        if (array_key_exists('owner_id', $row)) {
            $gameAccountType->setOwnerId($row['owner_id']);
        }
        if (array_key_exists('game_id', $row)) {
            $gameAccountType->setGameId($row['game_id']);
        }
        if (array_key_exists('winnerTeam', $row)) {
            $gameAccountType->setWinnerTeam($row['winnerTeam']);
        }
        if (array_key_exists('createdAt', $row)) {
            $gameAccountType->setCreatedAt($row['createdAt']);
        }
        if (array_key_exists('starttime', $row)) {
            $gameAccountType->setStarttime($row['starttime']);
        }
        if (array_key_exists('endtime', $row)) {
            $gameAccountType->setEndtime($row['endtime']);
        }

        return $gameAccountType;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'owner_id' => $this->ownerId,
            'game_id' => $this->gameId,
            'winnerTeam' => $this->winnerTeam,
            'createdAt' => $this->createdAt,
            'starttime' => $this->starttime,
            'endtime' => $this->endtime,
        ];
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getOwnerId()
    {
        return $this->ownerId;
    }

    /**
     * @param int $ownerId
     */
    public function setOwnerId($ownerId)
    {
        $this->ownerId = $ownerId;
    }

    /**
     * @return int
     */
    public function getGameId()
    {
        return $this->gameId;
    }

    /**
     * @param int $gameId
     */
    public function setGameId($gameId)
    {
        $this->gameId = $gameId;
    }

    /**
     * @return int
     */
    public function getWinnerTeam()
    {
        return $this->winnerTeam;
    }

    /**
     * @param int $winnerTeam
     */
    public function setWinnerTeam($winnerTeam)
    {
        $this->winnerTeam = $winnerTeam;
    }

    /**
     * @return int
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param int $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return int
     */
    public function getStarttime()
    {
        return $this->starttime;
    }

    /**
     * @param int $starttime
     */
    public function setStarttime($starttime)
    {
        $this->starttime = $starttime;
    }

    /**
     * @return int
     */
    public function getEndtime()
    {
        return $this->endtime;
    }

    /**
     * @param int $endtime
     */
    public function setEndtime($endtime)
    {
        $this->endtime = $endtime;
    }    
}