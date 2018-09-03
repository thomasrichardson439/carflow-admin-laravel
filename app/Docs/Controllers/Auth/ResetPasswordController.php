<?php

/**
*@OA\Post(
*  tags={"password"},
*  path="/api/password/change",
*  security={
*    {"api_key": {}}
*  },
*  summary="Change user password",
*  @OA\RequestBody(
*    required=true,
*    description="Email addres",
*    @OA\MediaType(
*      mediaType="multipart/form-data",
*      @OA\Schema(
*        @OA\Property(property="password", format="password", type="string", required={"true"}),
*        @OA\Property(property="new_password", format="password", type="string", required={"true"}),
*        @OA\Property(property="new_password_confirmation", format="password", type="string", required={"true"}),
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
*    response="400",
*    description="Invalid user current password",
*    @OA\JsonContent(@OA\Property(property="message", example="Invalid user password", type="string"))
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
*      @OA\Property(
*        property="errors",
*        type="array",
*        @OA\Items(
*          @OA\Property(
*            property="password",
*            type="array",
*            @OA\Items(type="string", example="Password is required.")
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
