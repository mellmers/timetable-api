<?php

namespace projectx\api\game;

use Doctrine\DBAL\Schema\Schema;
use projectx\api\entity\Game;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class GameService
 * @package projectx\api\game
 */
class GameService
{
    /** @var  GameRepository */
    private $gameRepository;

    /**
     * GameService constructor.
     *
     * @param GameRepository $gameRepository
     * @param
     */
    public function __construct(GameRepository $gameRepository)
    {
        $this->gameRepository = $gameRepository;
    }

    /**
     * GET /game
     *
     * @return JsonResponse
     */
    public function getList()
    {
        $result['data'] = $this->gameRepository->getAll();
        return new JsonResponse($result);
    }

    /**
     * GET /game/{gameId}
     *
     * @param $gameId
     *
     * @return JsonResponse
     */
    public function getById($gameId)
    {
        $result['data'] = $this->gameRepository->getById($gameId);
        return new JsonResponse($result);
    }

    /**
     * GET /game/byGenre/{genre}
     *
     * @param $genre
     *
     * @return JsonResponse
     */
    public function getByGenre($genre)
    {
        $result['data'] = $this->gameRepository->getByGenre($genre);
        return new JsonResponse($result);
    }

    /**
     * POST /game
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        $postData = $request->request->all();

        $game['data'] = Game::createFromArray($postData);

        $this->gameRepository->create($game);

        return new JsonResponse($game, 201);

    }
}