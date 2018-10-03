<?php

/**
 * @OA\Get(
 *  tags={"bookings"},
 *  path="/api/bookings/upcoming",
 *  summary="All cars which are upcoming in user's booking",
 *  security={
 *    {"api_key": {}}
 *  },
 *  @OA\Response(
 *    response=200,
 *    description="successfully get all cars",
 *    @OA\JsonContent(
 *      type="array",
 *      @OA\Items(ref="#/components/schemas/Car")
 *    )
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

/**
 * @OA\Get(
 *  tags={"bookings"},
 *  path="/api/bookings/history",
 *  summary="All cars which were booked by user",
 *  security={
 *    {"api_key": {}}
 *  },
 *  @OA\Response(
 *    response=200,
 *    description="successfully get all cars",
 *    @OA\JsonContent(
 *      type="array",
 *      @OA\Items(ref="#/components/schemas/Car")
 *    )
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