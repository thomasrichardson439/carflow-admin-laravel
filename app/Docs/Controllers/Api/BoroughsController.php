<?php

/**
 * @OA\Get(
 *  tags={"boroughs"},
 *  path="/api/boroughs",
 *  summary="List of boroughs",
 *  security={
 *    {"api_key": {}}
 *  },
 *  @OA\Response(
 *    response=200,
 *    description="successfully get the list",
 *    @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Borough")),
 *  ),
 *  @OA\Response(
 *    response="401",
 *    description="Unauthorized",
 *    @OA\JsonContent(@OA\Property(property="message", example="Unauthorized.", type="string"))
 *  ),
 *  @OA\Response(
 *    response="500",
 *    description="Server error"
 *  )
 *)
 */