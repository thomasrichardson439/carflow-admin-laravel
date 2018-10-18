<?php

/**
 * @OA\Schema(
 *   schema="IssueReport",
 *   @OA\Property(property="id", format="int64", type="integer"),
 *   @OA\Property(property="report_type", format="enum(damage,malfunction)", type="string"),
 *   @OA\Property(property="photo_1_s3_link", format="url", type="string"),
 *   @OA\Property(property="photo_2_s3_link", format="url", type="string"),
 *   @OA\Property(property="photo_3_s3_link", format="url", type="string"),
 *   @OA\Property(property="photo_4_s3_link", format="url", type="string"),
 *   @OA\Property(property="description", format="string", type="string"),
 *   @OA\Property(property="license_plate", format="string", type="string"),
 *   @OA\Property(property="created_at", ref="#/components/schemas/ApiDate"),
 * )
 */