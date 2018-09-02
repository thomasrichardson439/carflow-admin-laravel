<?php
/**
 * @OA\Post(
 *   tags={"password"},
 *   path="api/password/email",
 *   summary="Send reset email link",
 *     @OA\RequestBody(
 *         required=true,
 *         description="Email addres",
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 @OA\Property(property="email", format="email", type="string", required={"true"}),
 *            ),
 *         )
 *     ),
 *   @OA\Response(
 *       response=200,
 *       description="successfully sent",
 *       @OA\JsonContent(
 *           @OA\Property(
 *               property="message",
 *               type="string",
 *               example="Reset link was sent"
 *           )
 *      )
 *   ),
 *
 *   @OA\Response(
 *       response="401",
 *       description="Unauthorized",
 *       @OA\JsonContent(@OA\Property(property="message", example="Invalid login or password", type="string"))
 *   ),
 *
 *   @OA\Response(
 *       response="404",
 *       description="Unauthorized",
 *       @OA\JsonContent(@OA\Property(property="message", example="User with email not found", type="string"))
 *   ),
 *
 *   @OA\Response(
 *       response="422",
 *       description="Validation failed",
 *       @OA\JsonContent(
 *           @OA\Property(property="errors",
 *               type="array",
 *               @OA\Items(
 *                   @OA\Property(
 *                       property="email",
 *                       type="array",
 *                       @OA\Items(type="string", example="Email must be valid email address.")
 *                   )
 *               )
 *           ),
 *       )
 *   ),
 *   @OA\Response(
 *       response="500",
 *       description="Server error"
 *   )
 * )
 */
