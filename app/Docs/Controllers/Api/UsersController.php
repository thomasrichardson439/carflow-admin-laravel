<?php

/**
 * @OA\Get(
 *  tags={"user"},
 *  path="/api/users",
 *  summary="All users",
 *  security={
 *    {"api_key": {}}
 *  },
 *  @OA\Response(
 *    response=200,
 *    description="successfully get all users",
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
 * @OA\Get(
 *  tags={"user"},
 *  path="/api/users/{id}",
 *  summary="User details",
 *  security={
 *    {"api_key": {}}
 *  },
 *  @OA\Parameter(
 *    name="id",
 *    required=true,
 *    in="path",
 *    description="The user id",
 *    @OA\Schema(
 *      type="string"
 *    )
 *  ),
 *  @OA\Response(
 *    response=200,
 *    description="successfully find user",
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
 *    response="500",
 *    description="Server error"
 *  )
 *)
 */

/**
 * @OA\Post(
 *  tags={"user"},
 *  path="/api/users/{id}",
 *  summary="Update user",
 *  security={
 *    {"api_key": {}}
 *  },
 *  @OA\Parameter(
 *    name="id",
 *    required=true,
 *    in="path",
 *    description="The user id",
 *    @OA\Schema(
 *      type="string"
 *    )
 *  ),
 *  @OA\RequestBody(
 *    required=true,
 *    description="Updated user object",
 *    @OA\MediaType(
 *      mediaType="multipart/form-data",
 *      @OA\Schema(
 *        @OA\Property(property="address", example="100001", format="string", type="string"),
 *        @OA\Property(property="phone", example="411 555 1234", format="string", type="string"),
 *        @OA\Property(property="photo", format="image", type="file"),
 *        @OA\Property(property="_method", type="string", example="PATCH"),
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
 *    @OA\JsonContent(
 *      @OA\Property(
 *        property="errors",
 *        type="array",
 *        @OA\Items(
 *          @OA\Property(
 *            property="city",
 *            type="array",
 *            @OA\Items(type="string", example="Zip must be at least 5 characters.")
 *          )
 *        )
 *      ),
 *    )
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
 * @OA\Delete(
 *  tags={"user"},
 *  path="/api/users/{id}",
 *  summary="Delete user",
 *  security={
 *    {"api_key": {}}
 *  },
 *  @OA\Parameter(
 *    name="id",
 *    required=true,
 *    in="path",
 *    description="The user id",
 *    @OA\Schema(
 *      type="string"
 *    )
 *  ),
 *  @OA\Response(
 *    response=200,
 *    description="successfully deleted",
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
 *        @OA\Property(property="tlc_license_front", type="string", format="image", required={"true"}),
 *        @OA\Property(property="tlc_license_back", type="string", format="image", required={"true"}),
 *        @OA\Property(property="driving_license_front", type="string", format="image", required={"true"}),
 *        @OA\Property(property="driving_license_back", type="string", format="image", required={"true"}),
 *      ),
 *    )
 *  ),
 *  @OA\Response(
 *    response=201,
 *    description="successfully resubmitted",
 *    @OA\JsonContent(
 *      @OA\Property(property="user", ref="#/components/schemas/User"),
 *    )
 *  ),
 *  @OA\Response(
 *    response="422",
 *    description="Validation failed",
 *    @OA\JsonContent(
 *      @OA\Property(property="message", example="The given data was invalid.", type="string"),
 *      @OA\Property(
 *        property="errors",
 *        type="object",
 *        @OA\Property(
 *          property="email",
 *          type="array",
 *          @OA\Items(type="string", example="Email field is required.")
 *        )
 *      ),
 *    )
 *  ),
 *  @OA\Response(
 *    response="500",
 *    description="Server error"
 *  )
 *)
 */
