<?php

/**
 * @OA\Schema(
 *   schema="User",
 *   @OA\Property(property="id", format="int64", type="integer"),
 *   @OA\Property(property="full_name", format="string", type="string"),
 *   @OA\Property(property="email", format="email", type="string"),
 *   @OA\Property(property="address", format="string", type="string"),
 *   @OA\Property(property="phone", format="phone", type="string"),
 *   @OA\Property(property="photo", format="url", type="string"),
 *   @OA\Property(property="status", type="string", enum={"rejected", "pending", "approved"}),
 *   @OA\Property(property="ridesharing_approved", format="integer", type="boolean"),
 *   @OA\Property(property="documents_uploaded", format="integer", type="boolean"),
 *   @OA\Property(property="ridesharing_apps", format="string", example="uber, lyft", type="string"),
 *   @OA\Property(
 *     property="tlc_license",
 *     type="object",
 *     @OA\Property(property="front", format="url", type="string"),
 *     @OA\Property(property="back", format="url", type="string"),
 *   ),
 *   @OA\Property(
 *     property="driving_license",
 *     type="object",
 *     @OA\Property(property="front", format="url", type="string"),
 *     @OA\Property(property="back", format="url", type="string"),
 *   ),
 *   @OA\Property(property="profile_update_request", ref="#/components/schemas/ProfileUpdateRequest")
 * )
 */
