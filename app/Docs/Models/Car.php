<?php

/**
 * @OA\Schema(
 *   schema="Car",
 *   @OA\Property(property="id", format="int64", type="integer"),
 *   @OA\Property(property="image_s3_url", format="string", type="string"),
 *   @OA\Property(property="manufacturer", format="string", type="string"),
 *   @OA\Property(property="model", format="string", type="string"),
 *   @OA\Property(property="color", format="string", type="string"),
 *   @OA\Property(property="year", format="int", type="int"),
 *   @OA\Property(property="plate", format="string", type="string"),
 *   @OA\Property(property="full_pickup_location", format="string", type="string"),
 *   @OA\Property(property="full_return_location", format="string", type="string"),
 *   @OA\Property(property="short_pickup_location", format="string", type="string"),
 *   @OA\Property(property="short_return_location", format="string", type="string"),
 *   @OA\Property(property="pickup_location_lat", format="float", type="float"),
 *   @OA\Property(property="pickup_location_lon", format="float", type="float"),
 *   @OA\Property(property="return_location_lat", format="float", type="float"),
 *   @OA\Property(property="return_location_lon", format="float", type="float"),
 *   @OA\Property(property="booking_starting_at", ref="#/components/schemas/ApiDate"),
 *   @OA\Property(property="booking_ending_at", ref="#/components/schemas/ApiDate")
 * )
 */
