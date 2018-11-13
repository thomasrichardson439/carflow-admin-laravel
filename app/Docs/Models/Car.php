<?php

/**
 * @OA\Schema(
 *   schema="Car",
 *   @OA\Property(property="id", format="int64", type="integer"),
 *   @OA\Property(property="image_s3_url", format="string", type="string"),
 *   @OA\Property(property="manufacturer", ref="#/components/schemas/CarManufacturer"),
 *   @OA\Property(property="model", format="string", type="string"),
 *   @OA\Property(property="color", format="string", type="string"),
 *   @OA\Property(property="year", format="int", type="int"),
 *   @OA\Property(property="plate", format="string", type="string"),
 *   @OA\Property(property="full_pickup_location", format="string", type="string"),
 *   @OA\Property(property="full_return_location", format="string", type="string"),
 *   @OA\Property(property="pickup_borough", ref="#/components/schemas/Borough"),
 *   @OA\Property(property="return_borough", ref="#/components/schemas/Borough"),
 *   @OA\Property(property="pickup_location_lat", format="float", type="float"),
 *   @OA\Property(property="pickup_location_lon", format="float", type="float"),
 *   @OA\Property(property="return_location_lat", format="float", type="float"),
 *   @OA\Property(property="return_location_lon", format="float", type="float"),
 *   @OA\Property(property="seats", format="int64", type="integer"),
 *   @OA\Property(property="allowed_recurring", format="boolean", type="boolean"),
 *   @OA\Property(property="booking_starting_at", ref="#/components/schemas/ApiDate"),
 *   @OA\Property(property="booking_ending_at", ref="#/components/schemas/ApiDate"),
 *   @OA\Property(property="category", ref="#/components/schemas/CarCategory"),
 *   @OA\Property(property="availabilitySlots", type="array", @OA\Items(ref="#/components/schemas/CarAvailabilitySlot")),
 * )
 */
