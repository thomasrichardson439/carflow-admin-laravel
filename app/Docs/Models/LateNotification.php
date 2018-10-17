<?php

/**
 * @OA\Schema(
 *   schema="LateNotification",
 *   @OA\Property(property="id", format="int64", type="integer"),
 *   @OA\Property(property="booking_id", format="int64", type="integer"),
 *   @OA\Property(property="title", format="string", type="string"),
 *   @OA\Property(property="delay_minutes", format="int64", type="integer"),
 *   @OA\Property(property="photo_s3_link", format="string", type="string"),
 *   @OA\Property(property="reason", format="string", type="string"),
 *   @OA\Property(property="created_at", ref="#/components/schemas/ApiDate"),
 * )
 */