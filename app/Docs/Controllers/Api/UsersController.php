<?php

/**
 * @OA\Get(
 *  tags={"user"},
 *  path="/api/users/me",
 *  summary="Authenticated user info",
 *  security={
 *    {"api_key": {}}
 *  },
 *  @OA\Response(
 *    response=200,
 *    description="successfully get info",
 *    @OA\JsonContent(
 *      type="array",
 *      @OA\Items(ref="#/components/schemas/User")
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
 *  tags={"user"},
 *  path="/api/users/update",
 *  summary="Update authenticated user",
 *  security={
 *    {"api_key": {}}
 *  },
 *  @OA\RequestBody(
 *    required=true,
 *    description="Updated user object",
 *    @OA\MediaType(
 *      mediaType="multipart/form-data",
 *      @OA\Schema(
 *        @OA\Property(property="full_name", example="Albert Einstein", format="string", type="string"),
 *        @OA\Property(property="email", example="albert@example.com", format="string", type="string"),
 *        @OA\Property(property="address", example="Bronx", format="string", type="string"),
 *        @OA\Property(property="phone", example="411 555 1234", format="string", type="string"),
 *        @OA\Property(property="photo", format="image", type="file"),
 *      ),
 *    )
 *  ),
 *  @OA\Response(
 *    response=200,
 *    description="successfully updated",
 *    @OA\JsonContent(ref="#/components/schemas/User")
 *  ),
 *  @OA\Response(
 *    response="401",
 *    description="Unauthorized",
 *    @OA\JsonContent(
 *      @OA\Property(
 *        property="message",
 *        example="Unauthorized.",
 *        type="string"
 *      )
 *    )
 *  ),
 *  @OA\Response(
 *    response="404",
 *    description="Not found",
 *    @OA\JsonContent(
 *      @OA\Property(property="message", example="User not found", type="string")
 *    )
 *  ),
 *  @OA\Response(
 *    response="422",
 *    description="Validation failed",
 *    @OA\JsonContent(ref="#/components/schemas/ValidationErrorResponse")
 *  ),
 *  @OA\Response(
 *    response="500",
 *    description="Server error"
 *  )
 *)
 */


/**
 * @OA\Get(
 *  tags={"user"},
 *  path="/api/users/status",
 *  summary="Check authenticated user status",
 *  security={
 *    {"api_key": {}}
 *  },
 *  @OA\Response(
 *    response=201,
 *    description="returns user current status",
 *    @OA\JsonContent(ref="#/components/schemas/User")
 *  ),
 *  @OA\Response(
 *    response="401",
 *    description="Unauthorized",
 *    @OA\JsonContent(
 *      @OA\Property(
 *        property="message",
 *        example="Unauthorized.",
 *        type="string"
 *      )
 *    )
 *  ),
 *  @OA\Response(
 *    response="500",
 *    description="Server error"
 *  )
 *)
 */

/**
 * @OA\Post(
 *  tags={"user"},
 *  path="/api/users/resubmit",
 *  summary="Resubmit user data if account was rejected",
 *  security={
 *    {"api_key": {}}
 *  },
 *  @OA\RequestBody(
 *    required=true,
 *    description="New acount details",
 *    @OA\MediaType(
 *      mediaType="multipart/form-data",
 *      @OA\Schema(
 *        @OA\Property(property="full_name", example="John Dane", format="string", type="string", required={"true"}),
 *        @OA\Property(property="address", example="Park Avenue", format="string", type="string", required={"true"}),
 *        @OA\Property(property="phone", example="411 555 1234", format="string", type="string", required={"true"}),
 *        @OA\Property(property="ridesharing_approved", type="boolean", example="1", format="int64", required={"true"}),
 *        @OA\Property(property="ridesharing_apps", type="string", example="uber, lyft", format="string", required={"true"}),
 *        @OA\Property(property="tlc_license_front", type="file", format="image", required={"true"}),
 *        @OA\Property(property="tlc_license_back", type="file", format="image", required={"true"}),
 *        @OA\Property(property="driving_license_front", type="file", format="image", required={"true"}),
 *        @OA\Property(property="driving_license_back", type="file", format="image", required={"true"}),
 *      ),
 *    )
 *  ),
 *  @OA\Response(
 *    response=201,
 *    description="successfully resubmitted",
 *    @OA\JsonContent(
 *      @OA\Property(ref="#/components/schemas/User"),
 *    )
 *  ),
 *  @OA\Response(
 *    response="422",
 *    description="Validation failed",
 *    @OA\JsonContent(ref="#/components/schemas/ValidationErrorResponse")
 *  ),
 *  @OA\Response(
 *    response="500",
 *    description="Server error"
 *  )
 *)
 */
