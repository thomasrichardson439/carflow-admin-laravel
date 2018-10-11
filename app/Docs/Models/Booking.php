<?php

/**
 * @OA\Schema(
 *   schema="Booking",
 *   @OA\Property(property="id", format="int64", type="integer"),
 *   @OA\Property(property="car_id", format="int64", type="integer"),
 *   @OA\Property(property="booking_starting_at", ref="#/components/schemas/ApiDate"),
 *   @OA\Property(property="booking_ending_at", ref="#/components/schemas/ApiDate"),
 * )
 */
