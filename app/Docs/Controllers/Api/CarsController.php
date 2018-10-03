<?php

/**
 * @OA\Get(
 *  tags={"cars"},
 *  path="/api/cars/available",
 *  summary="All cars which are available for booking",
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
 *  tags={"cars"},
 *  path="/api/cars/{id}/book",
 *  summary="Booking preview for a single car",
 *  security={
 *    {"api_key": {}}
 *  },
 *  @OA\Parameter(
 *    name="id",
 *    required=true,
 *    in="path",
 *    description="The car id",
 *    @OA\Schema(
 *      type="int"
 *    )
 *  ),
 *  @OA\Response(
 *    response=200,
 *    description="successfully get the car",
 *    @OA\JsonContent(
 *      ref="#/components/schemas/Car",
 *      @OA\Property(property="booked_slots", type="array", example="[1539446400, 1539446600]",
 *          @OA\Items(type="integer")
 *      ),
 *      @OA\Property(property="slots", type="array", example="[1539446400: 11:00 AM]",
 *          @OA\Items(type="string")
 *      )
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
 * @OA\Post(
 *  tags={"cars"},
 *  path="/api/cars/{id}/book",
 *  summary="Booking a car",
 *  security={
 *    {"api_key": {}}
 *  },
 *  @OA\Parameter(
 *    name="id",
 *    required=true,
 *    in="path",
 *    description="The car id",
 *    @OA\Schema(
 *      type="int"
 *    )
 *  ),
 *  @OA\RequestBody(
 *    required=true,
 *    description="Booking record",
 *    @OA\MediaType(
 *      mediaType="application/x-www-form-urlencoded",
 *      @OA\Schema(
 *        @OA\Property(property="slot_start_timestamp", example="1539464400", format="int64", type="integer"),
 *        @OA\Property(property="slot_end_timestamp", example="1539471600", format="int64", type="integer"),
 *      ),
 *    )
 *  ),
 *  @OA\Response(
 *    response=200,
 *    description="successfully booked the car",
 *    @OA\JsonContent(
 *      type="array",
 *      @OA\Items(ref="#/components/schemas/Booking")
 *    )
 *  ),
 *  @OA\Response(
 *    response="422",
 *    description="Validation failed",
 *    @OA\JsonContent(
 *      @OA\Property(
 *        property="errors",
 *        type="array",
 *        @OA\Items(
 *          @OA\Property(
 *            property="any",
 *            type="array",
 *            @OA\Items(type="string", example="Dummy error")
 *          )
 *        )
 *      ),
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