<?php

/**
 * @OA\Schema(
 *   schema="EndedReport",
 *   @OA\Property(property="booking_id", format="int64", type="integer"),
 *   @OA\Property(property="photo_front_s3_link", format="url", type="string"),
 *   @OA\Property(property="photo_back_s3_link", format="url", type="string"),
 *   @OA\Property(property="photo_left_s3_link", format="url", type="string"),
 *   @OA\Property(property="photo_right_s3_link", format="url", type="string"),
 *   @OA\Property(property="photo_gas_tank_s3_link", format="url", type="string"),
 *   @OA\Property(property="notes", format="string", type="string"),
 *   @OA\Property(property="created_at", ref="#/components/schemas/ApiDate"),
 * )
 */