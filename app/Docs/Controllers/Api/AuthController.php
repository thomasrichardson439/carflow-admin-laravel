<?php
/**
 * @OA\Post(
 *  tags={"auth"},
 *  path="/api/login",
 *  summary="Login user",
 *  @OA\RequestBody(
 *    required=true,
 *    description="Email and password",
 *    @OA\MediaType(
 *       mediaType="multipart/form-data",
 *       @OA\Schema(
 *         @OA\Property(property="email", format="email", type="string", required={"true"}),
 *         @OA\Property(property="password", format="password", type="string", required={"true"}),
 *      ),
 *    )
 *  ),
 *  @OA\Response(
 *    response=200,
 *    description="successfully login",
 *    @OA\JsonContent(
 *      @OA\Property(property="auth_token",type="string"),
 *      @OA\Property(property="user", ref="#/components/schemas/User"),
 *    )
 *  ),
 *  @OA\Response(
 *    response="401",
 *    description="Unauthorized",
 *    @OA\JsonContent(@OA\Property(property="message", example="Invalid login or password", type="string"))
 *  ),
 *  @OA\Response(
 *    response="500",
 *    description="Server error"
 *  )
 *)
 */


/**
 * @OA\Post(
 *  tags={"auth"},
 *  path="/api/register/create",
 *  summary="Create user",
 *  @OA\RequestBody(
 *    required=true,
 *    description="Email and password",
 *    @OA\MediaType(
 *      mediaType="multipart/form-data",
 *      @OA\Schema(
 *        @OA\Property(property="email", format="email", type="string", required={"true"}),
 *        @OA\Property(property="password", format="password", type="string", required={"true"}),
 *        @OA\Property(property="password_confirmation", format="password", type="string", required={"true"}),
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
 *    description="successfully created",
 *    @OA\JsonContent(
 *      @OA\Property(property="auth_token",type="string"),
 *      @OA\Property(property="user", ref="#/components/schemas/User"),
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
 * @OA\Post(
 *  tags={"auth"},
 *  path="/api/validate-email",
 *  summary="Validates if email is taken",
 *  @OA\RequestBody(
 *    required=true,
 *    description="Updated user object",
 *    @OA\MediaType(
 *      mediaType="application/x-www-form-urlencoded",
 *      @OA\Schema(
 *        @OA\Property(property="email", format="email", type="string", required={"true"}),
 *      )
 *    )
 *  ),
 *
 *  @OA\Response(
 *    response=200,
 *    description="email is free to take",
 *    @OA\JsonContent(
 *      @OA\Property(property="email", example="free", type="string"),
 *    )
 *  ),
 *  @OA\Response(
 *    response=406,
 *    description="email is already taken",
 *    @OA\JsonContent(
 *      @OA\Property(property="email", example="taken", type="string"),
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
