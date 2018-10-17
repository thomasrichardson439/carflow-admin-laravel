<?php

/**
 * @OA\Post(
 *  tags={"bookings_help"},
 *  path="/api/bookings/{id}/help/damage",
 *  summary="Send damage report",
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
 *        @OA\Property(property="car_photos", type="array", format="file", @OA\Items(
 *          @OA\Property(format="file", type="file"),
 *        )),
 *        @OA\Property(property="description", format="string")
 *      ),
 *    )
 *  ),
 *  @OA\Response(
 *    response=200,
 *    description="success",
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
 * @OA\Post(
 *  tags={"bookings_help"},
 *  path="/api/bookings/{id}/help/malfunction",
 *  summary="Send malfunction report",
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
 *        @OA\Property(property="car_photos", type="array", format="file", @OA\Items(
 *          @OA\Property(format="file", type="file"),
 *        )),
 *        @OA\Property(property="description", format="string"),
 *        @OA\Property(property="license_plate", format="string"),
 *      ),
 *    )
 *  ),
 *  @OA\Response(
 *    response=200,
 *    description="success",
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
 * @OA\Post(
 *  tags={"bookings_help"},
 *  path="/api/bookings/{id}/help/late",
 *  summary="Send late report",
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
 *        @OA\Property(property="delay_minutes", format="int64", type="int"),
 *        @OA\Property(property="photo", format="file", type="file"),
 *        @OA\Property(property="reason", format="string", type="string"),
 *      ),
 *    )
 *  ),
 *  @OA\Response(
 *    response=200,
 *    description="success",
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
 *    response="409",
 *    description="Conflict"
 *  ),
 *  @OA\Response(
 *    response="500",
 *    description="Server error"
 *  )
 *)
 */

