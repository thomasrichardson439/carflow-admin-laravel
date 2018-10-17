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
 *    description="success",
 *    @OA\JsonContent(
 *      @OA\Property(
 *          property="bookings", type="array",
 *          @OA\Items(ref="#/components/schemas/Booking")
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
 * @OA\Get(
 *  tags={"bookings"},
 *  path="/api/bookings/history",
 *  summary="All user bookings that has pass",
 *  security={
 *    {"api_key": {}}
 *  },
 *  @OA\Response(
 *    response=200,
 *    description="success",
 *    @OA\JsonContent(
 *      @OA\Property(
 *          property="bookings", type="array",
 *          @OA\Items(ref="#/components/schemas/Booking")*
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
 * @OA\Get(
 *  tags={"bookings"},
 *  path="/api/booking/{id}",
 *  summary="Booking preview",
 *  security={
 *    {"api_key": {}}
 *  },
 *  @OA\Parameter(
 *    name="id",
 *    required=true,
 *    in="path",
 *    description="The book id",
 *    @OA\Schema(
 *      type="int"
 *    )
 *  ),
 *  @OA\Response(
 *    response=200,
 *    description="success",
 *    @OA\JsonContent(ref="#/components/schemas/Booking")
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
 *  tags={"bookings"},
 *  path="/api/bookings/{id}/start",
 *  summary="Start ride",
 *  security={
 *    {"api_key": {}}
 *  },
 *  @OA\Parameter(
 *    name="id",
 *    required=true,
 *    in="path",
 *    description="The booking id",
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
 *        @OA\Property(property="license_plate_photo", format="file", type="file"),
 *      ),
 *    )
 *  ),
 *  @OA\Response(
 *    response=200,
 *    description="success",
 *    @OA\JsonContent(ref="#/components/schemas/Booking")
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
 *    response="409",
 *    description="Conflict"
 *  ),
 *  @OA\Response(
 *    response="500",
 *    description="Server error"
 *  )
 *)
 */

/**
 * @OA\Post(
 *  tags={"bookings"},
 *  path="/api/bookings/{id}/end",
 *  summary="End ride",
 *  security={
 *    {"api_key": {}}
 *  },
 *  @OA\Parameter(
 *    name="id",
 *    required=true,
 *    in="path",
 *    description="The booking id",
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
 *        @OA\Property(property="license_plate_photo", format="file", type="file"),
 *        @OA\Property(property="car_front_photo", format="file", type="file"),
 *        @OA\Property(property="car_back_photo", format="file", type="file"),
 *        @OA\Property(property="car_left_photo", format="file", type="file"),
 *        @OA\Property(property="car_right_photo", format="file", type="file"),
 *        @OA\Property(property="gas_tank_photo", format="file", type="file"),
 *      ),
 *    )
 *  ),
 *  @OA\Response(
 *    response=200,
 *    description="success",
 *    @OA\JsonContent(ref="#/components/schemas/Booking")
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
 *    response="409",
 *    description="Conflict"
 *  ),
 *  @OA\Response(
 *    response="500",
 *    description="Server error"
 *  )
 *)
 */

/**
 * @OA\Post(
 *  tags={"bookings"},
 *  path="/api/bookings/{id}/cancel",
 *  summary="Cancel ride",
 *  security={
 *    {"api_key": {}}
 *  },
 *  @OA\Parameter(
 *    name="id",
 *    required=true,
 *    in="path",
 *    description="The booking id",
 *    @OA\Schema(
 *      type="int"
 *    )
 *  ),
 *  @OA\Response(
 *    response=200,
 *    description="success",
 *    @OA\JsonContent(ref="#/components/schemas/Booking")
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
 *    response="409",
 *    description="Conflict"
 *  ),
 *  @OA\Response(
 *    response="500",
 *    description="Server error"
 *  )
 *)
 */


/**
 * @OA\Post(
 *  tags={"bookings"},
 *  path="/api/bookings/{id}/receipt",
 *  summary="Send expensive receipt",
 *  security={
 *    {"api_key": {}}
 *  },
 *  @OA\Parameter(
 *    name="id",
 *    required=true,
 *    in="path",
 *    description="The booking id",
 *    @OA\Schema(
 *      type="int"
 *    )
 *  ),
 *  @OA\RequestBody(
 *    required=true,
 *    description="Booking record",
 *    @OA\MediaType(
 *      mediaType="multipart/form-data",
 *      @OA\Schema(
 *        @OA\Property(property="title", format="string", type="string"),
 *        @OA\Property(property="description", format="string", type="string"),
 *        @OA\Property(property="price", format="int64", type="int"),
 *        @OA\Property(property="receipt_date", format="date:Y-m-d", type="string"),
 *        @OA\Property(property="photo", format="file", type="file"),
 *      ),
 *    )
 *  ),
 *  @OA\Response(
 *    response=200,
 *    description="success",
 *    @OA\JsonContent(ref="#/components/schemas/Booking")
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
 *    response="409",
 *    description="Conflict"
 *  ),
 *  @OA\Response(
 *    response="500",
 *    description="Server error"
 *  )
 *)
 */