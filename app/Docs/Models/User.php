<?php

/**
* @OA\Schema(
*   schema="User",
*   @OA\Property(property="id", format="int64", type="integer"),
*   @OA\Property(property="full_name", format="string", type="string"),
*   @OA\Property(property="email", format="email", type="string"),
*   @OA\Property(property="admin", format="int64", type="boolean"),
*   @OA\Property(property="street", format="string", type="string"),
*   @OA\Property(property="city", format="string", type="string"),
*   @OA\Property(property="zip_code", format="string", type="string"),
*   @OA\Property(property="state", format="state", type="string"),
*   @OA\Property(property="phone", format="phone", type="string"),
*   @OA\Property(property="photo", format="url", type="string"),
*   @OA\Property(property="status", type="string", enum={"rejected", "pending", "approved"}),
*   @OA\Property(property="ridesharing_approved", format="integer", type="boolean"),
*   @OA\Property(property="documents_uploaded", format="integer", type="boolean"),
*   @OA\Property(property="ridesharing_apps", format="string", example="uber, lyft", type="string"),
*      @OA\Property(
*        property="tlcLicense",
*        type="object",
*        @OA\Property(property="front", format="url", type="string"),
*        @OA\Property(property="back", format="url", type="string"),
*      ),
*      @OA\Property(
*        property="drivingLicense",
*        type="object",
*        @OA\Property(property="front", format="url", type="string"),
*        @OA\Property(property="back", format="url", type="string"),
*      ),
* )
*/
