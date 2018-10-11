<?php

/**
 * @OA\Schema(
 *   schema="ValidationErrorResponse",
 *   @OA\Property(property="data", type="array", @OA\Items(type="mixed")),
 *   @OA\Property(property="status", type="string"),
 *   @OA\Property(property="error", type="array", @OA\Items(
 *      @OA\Property(property="type", type="string"),
 *      @OA\Property(property="message", type="string"),
 *      @OA\Property(property="errors", type="array", @OA\Items(type="array", @OA\Items(type="string"))),
 *   )),
 * )
 */