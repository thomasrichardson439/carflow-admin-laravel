<?php

/**
 * @OA\Schema(
 *   schema="CarAvailabilitySlot",
 *   @OA\Property(property="availability_type", format="string", type="string"),
 *   @OA\Property(property="available_at", format="string", type="string"),
 *   @OA\Property(property="available_at_recurring", format="enum(monday, ..., sunday)", type="string"),
 *   @OA\Property(property="available_hour_from", format="string", type="string"),
 *   @OA\Property(property="available_hour_to", format="string", type="string"),
 * )
 */
