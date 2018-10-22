<?php

/**
 * @OA\Schema(
 *   schema="Receipt",
 *   @OA\Property(property="id", format="int64", type="integer"),
 *   @OA\Property(property="title", format="string", type="string"),
 *   @OA\Property(property="location", format="string", type="string"),
 *   @OA\Property(property="price", format="float", type="float"),
 *   @OA\Property(property="receipt_date", ref="#/components/schemas/ApiDate"),
 *   @OA\Property(property="photo_s3_link", format="url", type="string"),
 *   @OA\Property(property="created_at", ref="#/components/schemas/ApiDate"),
 * )
 */