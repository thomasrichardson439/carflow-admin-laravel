<?php

/**
 * @OA\Schema(
 *   schema="ProfileUpdateRequest",
 *   @OA\Property(property="id", format="int64", type="integer"),
 *   @OA\Property(property="full_name", format="string", type="string"),
 *   @OA\Property(property="email", format="string", type="string"),
 *   @OA\Property(property="phone", format="string", type="string"),
 *   @OA\Property(property="address", format="string", type="string"),
 *   @OA\Property(property="status", format="enum(pending,approved,rejected)", type="string"),
 *   @OA\Property(property="created_at", ref="#/components/schemas/ApiDate"),
 * )
 */