<?php
/**
 * Created by PhpStorm.
 * User: Jonas
 * Date: 08/06/2016
 * Time: 14:26
 */

namespace projectx\api\entity;


class GameAccount implements \JsonSerializable
{
    /**
     * @var int
     * @SWG\Property(type="integer", format="int32")
     */
    private $userId;
    /**
     * @var String
     * @SWG\Property(type="string")
     */
    private $userPath;
    /**
     * @var User
     * @SWG\Property(type="User")
     */
    private $user;
    /**
     * @var string
     * @SWG\Property(type="string")
     */
    private $gameAccountTypeId;
    /**
     * @var String
     * @SWG\Property(type="string")
     */
    private $gameAccountTypePath;
    /**
     * @var GameAccount
     * @SWG\Property(type="User")
     */
    private $gameAccountType;
    /**
     * @var string
     * @SWG\Property(type="string")
     */
    private $userIdendtifier;

    public static function createFromArray(array $row)
    {
        $gameAccountType = new self();
        if (array_key_exists('user_id', $row)) {
            $gameAccountType->setUserId($row['user_id']);
            $gameAccountType->setUserPath("/user/" . $row['user_id']);
        }
        if (array_key_exists('user', $row)) {
            $gameAccountType->setUser($row['user']);
        }
        if (array_key_exists('gameaccount_type_id', $row)) {
            $gameAccountType->setGameAccountTypeId($row['gameaccount_type_id']);
            $gameAccountType->setGameAccountTypePath("/gameAccountType/" . $row['gameaccount_type_id']);
        }
        if (array_key_exists('gameaccount_type', $row)) {
            $gameAccountType->setGameAccountType($row['gameaccount_type']);
        }
        if (array_key_exists('userIdentifier', $row)) {
            $gameAccountType->setUserIdendtifier($row['userIdentifier']);
        }
        return $gameAccountType;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'userId' => $this->userId,
            'user_path' => $this->userPath,
            'user' => $this->user,
            'gameaccount_type_id' => $this->gameAccountTypeId,
            'gameaccount_type_path' => $this->gameAccountTypePath,
            'gameaccount_type' => $this->gameAccountType,
            'userIdentifier' => $this->userIdendtifier,
        ];
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return String
     */
    public function getUserPath()
    {
        return $this->userPath;
    }

    /**
     * @param String $userPath
     */
    public function setUserPath($userPath)
    {
        $this->userPath = $userPath;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getGameAccountTypeId()
    {
        return $this->gameAccountTypeId;
    }

    /**
     * @param string $gameAccountTypeId
     */
    public function setGameAccountTypeId($gameAccountTypeId)
    {
        $this->gameAccountTypeId = $gameAccountTypeId;
    }

    /**
     * @return String
     */
    public function getGameAccountTypePath()
    {
        return $this->gameAccountTypePath;
    }

    /**
     * @param String $gameAccountTypePath
     */
    public function setGameAccountTypePath($gameAccountTypePath)
    {
        $this->gameAccountTypePath = $gameAccountTypePath;
    }

    /**
     * @return GameAccount
     */
    public function getGameAccountType()
    {
        return $this->gameAccountType;
    }

    /**
     * @param GameAccount $gameAccountType
     */
    public function setGameAccountType($gameAccountType)
    {
        $this->gameAccountType = $gameAccountType;
    }

    /**
     * @return string
     */
    public function getUserIdendtifier()
    {
        return $this->userIdendtifier;
    }

    /**
     * @param string $userIdendtifier
     */
    public function setUserIdendtifier($userIdendtifier)
    {
        $this->userIdendtifier = $userIdendtifier;
    }

}