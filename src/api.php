<?php

/**
 * @SWG\Swagger(
 *     basePath="/src",
 *     host="127.0.0.1",
 *     schemes={"http"},
 *     @SWG\Info(
 *         version="1.0.0",
 *         title="Project-X",
 *         @SWG\Contact(name="project X team", url="http://developer.projectX.com"),
 *         @SWG\License(name="Creative Commons 4.0 International", url="http://creativecommons.org/licenses/by/4.0/")
 *     ),
 *     @SWG\Definition(
 *         definition="Error",
 *         required={"code", "message"},
 *         @SWG\Property(
 *             property="code",
 *             type="integer",
 *             format="int32"
 *         ),
 *         @SWG\Property(
 *             property="message",
 *             type="string"
 *         )
 *     ),
 *     @SWG\Definition(
 *         definition="User",
 *         @SWG\Property(property="email", type="string"),
 *         @SWG\Property(property="username", type="string"),
 *         @SWG\Property(property="password",  type="string"),
 *         @SWG\Property(property="trusted", type="boolean"),
 *         @SWG\Property(property="icon",  type="string"),
 *         @SWG\Property(property="coins", type="integer"),
 *         @SWG\Property(property="createdAt", type="string")
 *     ),
 *     @SWG\Definition(
 *         definition="Bet",
 *         @SWG\Property(property="userid", type="integer"),
 *         @SWG\Property(property="lobbyid", type="integer"),
 *         @SWG\Property(property="amount",  type="integer"),
 *         @SWG\Property(property="team", type="boolean")
 *     ),
 *     @SWG\Definition(
 *         definition="Game",
 *         @SWG\Property(property="name", type="string"),
 *         @SWG\Property(property="typ", type="string"),
 *         @SWG\Property(property="icon",  type="string"),
 *         @SWG\Property(property="rules", type="string"),
 *         @SWG\Property(property="genre",  type="string"),
 *         @SWG\Property(property="timelimit", type="integer")
 *     ),
 *     @SWG\Definition(
 *         definition="GameAccount",
 *         @SWG\Property(property="useridentifier", type="string"),
 *         @SWG\Property(property="gameaccounttypeid", type="integer")
 *     ),
 *     @SWG\Definition(
 *         definition="GameAccountType",
 *         @SWG\Property(property="name", type="string"),
 *         @SWG\Property(property="icon", type="string")
 *     ),
 *     @SWG\Definition(
 *         definition="Lobby",
 *         @SWG\Property(property="ownerId", type="string"),
 *         @SWG\Property(property="gameId", type="string"),
 *         @SWG\Property(property="winnerteam",  type="string"),
 *         @SWG\Property(property="createdAt", type="boolean"),
 *         @SWG\Property(property="starttime",  type="string"),
 *         @SWG\Property(property="endtime", type="integer")
 *     )
 * )
 *
 * @SWG\Parameter(name="gameId", in="path", type="integer", description="")
 * @SWG\Parameter(name="lobbyId", in="path", type="integer", description="")
 * @SWG\Parameter(name="userId", in="path", type="integer", description="")
 * @SWG\Parameter(name="gameAccId", in="path", type="integer", description="")
 * @SWG\Parameter(name="gameAccountTypeId", in="path", type="integer", description="")
 * @SWG\Parameter(name="gameAccount", in="path", type="integer", format="int32")
 * @SWG\Parameter(name="betId", type="integer", format="int32", in="path")
 *
 * @SWG\Parameter(name="type", in="path", type="string", description="")
 * @SWG\Parameter(name="genre", in="path", type="string", description="")
 */