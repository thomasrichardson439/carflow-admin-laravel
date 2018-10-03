<?php

/**
 * @OA\Schema(
 *   schema="ApiDate",
 *   @OA\Property(property="object", type="array",
 *      @OA\Items(
 *          @OA\Property(property="date", type="string"),
 *          @OA\Property(property="timezone_type", type="integer"),
 *          @OA\Property(property="timezone", type="string")
 *      )
 *   ),
 *   @OA\Property(property="formatted", type="string")
 * )
 */
