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
 * @OA\Post(
 *  tags={"user"},
 *  path="users/check-status/{id}",
 *  summary="Check user status",
 *  security={
 *    {"api_key": {}}
 *  },
 *  @OA\Parameter(
 *    name="id",
 *    required=true,
 *    in="path",
 *    description="The user id",
 *    @OA\Schema(
 *      type="int"
 *    )
 *  ),
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
 *            @OA\Items(type="string", example="Invalid type.")
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
