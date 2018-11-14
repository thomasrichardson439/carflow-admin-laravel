<?php

/**
 * @OA\Post(
 *  tags={"cars"},
 *  path="/api/cars/available",
 *  summary="All cars which are available for booking",
 *  security={
 *    {"api_key": {}}
 *  },
 *  @OA\RequestBody(
 *    required=true,
 *    description="Available cars",
 *    @OA\MediaType(
 *      mediaType="application/x-www-form-urlencoded",
 *      @OA\Schema(
 *        @OA\Property(property="available_from", example="2018-10-11 11:00", format="string", type="string"),
 *        @OA\Property(property="available_to", example="2018-10-11 12:59", format="string", type="string"),
 *        @OA\Property(property="categories", format="array", type="array", @OA\Items(
 *          type="int"
 *        )),
 *        @OA\Property(property="allowed_recurring", example="true", format="boolean", type="boolean"),
 *        @OA\Property(property="pickup_location_lat", format="double", type="double"),
 *        @OA\Property(property="pickup_location_lon", format="double", type="double"),
 *        @OA\Property(property="allowed_range_miles", format="int64", type="integer"),
 *      ),
 *    )
 *  ),
 *  @OA\Response(
 *    response=200,
 *    description="successfully get all cars",
 *    @OA\JsonContent(type="array", @OA\Items(
 *      @OA\Property(property="car", ref="#/components/schemas/Car"),
 *      @OA\Property(property="distance_miles", type="double"),
 *      @OA\Property(property="availability", type="string"),
 *    ))
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
 *  path="/api/cars/{id}/book-preview",
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
 *  @OA\RequestBody(
 *    required=true,
 *    description="Preview",
 *    @OA\MediaType(
 *      mediaType="application/x-www-form-urlencoded",
 *      @OA\Schema(
 *        @OA\Property(property="calendar_date_from", example="2018-10-11", format="string", type="string"),
 *        @OA\Property(property="calendar_date_to", example="2018-10-11", format="string", type="string")
 *      ),
 *    )
 *  ),
 *  @OA\Response(
 *    response=200,
 *    description="successfully get the car",
 *    @OA\JsonContent(type="array", @OA\Items(
 *      @OA\Property(property="car", ref="#/components/schemas/Car"),
 *      @OA\Property(property="calendar", type="array", @OA\Items(
 *          @OA\Property(property="2018-01-01", type="array", @OA\Items(format="int64", type="integer"))
 *      )),
 *    ))
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
 *        @OA\Property(property="booking_starting_at", example="2018-10-11 11:00", format="string", type="string"),
 *        @OA\Property(property="booking_ending_at", example="2018-10-11 12:59", format="string", type="string"),
 *        @OA\Property(property="is_recurring", example="1", format="boolean", type="boolean"),
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
 *    @OA\JsonContent(ref="#/components/schemas/ValidationErrorResponse")
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
 *  path="/api/cars/categories",
 *  summary="List of car categories",
 *  security={
 *    {"api_key": {}}
 *  },
 *  @OA\Response(
 *    response=200,
 *    description="successfully get the list",
 *    @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/CarCategory")),
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
 *  path="/api/cars/manufacturers",
 *  summary="List of car manufacturers",
 *  security={
 *    {"api_key": {}}
 *  },
 *  @OA\Response(
 *    response=200,
 *    description="successfully get the list",
 *    @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/CarManufacturer")),
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