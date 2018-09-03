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
*   @OA\Property(property="step", type="integer", enum={1, 2, 3}),
*   @OA\Property(property="status", type="string", enum={"rejected", "pending", "approved"}),
*   @OA\Property(property="uber_approved", format="phone", type="boolean"),
* )
*/
