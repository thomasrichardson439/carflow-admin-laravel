<?php
/**
*@OA\Post(
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
*      @OA\Property(
*        property="auth_token",
*        type="string"
*      )
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
*@OA\Post(
*  tags={"auth"},
*  path="/api/register/step-1",
*  summary="Create user",
*  security={
*    {"api_key": {}}
*  },
*  @OA\RequestBody(
*    required=true,
*    description="Email and password",
*    @OA\MediaType(
*      mediaType="multipart/form-data",
*      @OA\Schema(
*        @OA\Property(property="email", format="email", type="string", required={"true"}),
*        @OA\Property(property="password", format="password", type="string", required={"true"}),
*        @OA\Property(property="password_confirmation", format="password", type="string", required={"true"}),
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

/**
*@OA\Post(
*  tags={"auth"},
*  path="/api/register/step-2",
*  summary="Storing user additional details",
*  security={
*    {"api_key": {}}
*  },
*  @OA\RequestBody(
*    required=true,
*    description="Updated user object",
*    @OA\MediaType(
*      mediaType="multipart/form-data",
*      @OA\Schema(
*        @OA\Property(property="full_name", format="string", type="string", required={"true"}),
*        @OA\Property(property="street", format="string", type="string", required={"true"}),
*        @OA\Property(property="city", format="string", type="string", required={"true"}),
*        @OA\Property(property="zip_code", format="string", type="string", required={"true"}),
*        @OA\Property(property="state", format="string", type="string", required={"true"}),
*        @OA\Property(property="phone", format="string", type="string", required={"true"}),
*      ),
*    )
*  ),
*
*  @OA\Response(
*    response=200,
*    description="successfully created",
*    @OA\JsonContent(ref="#/components/schemas/User"),
*  ),
*  @OA\Response(
*    response="401",
*    description="Unauthorized",
*    @OA\JsonContent(@OA\Property(property="message", example="Unauthorized.", type="string"))
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
*          property="city",
*          type="array",
*          @OA\Items(type="string", example="City must be at least 5 characters.")
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
*@OA\Post(
*  tags={"auth"},
*  path="/api/register/step-3",
*  summary="Storing user driving information",
*  security={
*    {"api_key": {}}
*  },
*  @OA\RequestBody(
*    required=true,
*    description="Updated user object",
*    @OA\MediaType(
*      mediaType="multipart/form-data",
*      @OA\Schema(
*        @OA\Property(property="uber_approved", type="boolean", example="1", format="int64", required={"true"}),
*        @OA\Property(property="documents[front_license]", type="file", format="image"),
*        @OA\Property(property="documents[back_licence]", type="file", format="image"),
*        @OA\Property(property="documents[tlc_licence]", type="file", format="image"),
*      )
*    )
*  ),
*
*  @OA\Response(
*    response=200,
*    description="successfully created",
*    @OA\JsonContent(ref="#/components/schemas/User")
*  ),
*  @OA\Response(
*    response="401",
*    description="Unauthorized",
*    @OA\JsonContent(@OA\Property(property="message", example="Unauthorized.", type="string"))
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
*          property="uber_approved",
*          type="array",
*       @OA\Items(type="string", example="Uber approved field is required.")
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
