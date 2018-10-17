<?php

/**
 * @OA\Schema(
 *   schema="Booking",
 *   @OA\Property(property="id", format="int64", type="integer"),
 *   @OA\Property(property="booking_starting_at", ref="#/components/schemas/ApiDate"),
 *   @OA\Property(property="booking_ending_at", ref="#/components/schemas/ApiDate"),
 *   @OA\Property(property="status", format="string", type="string"),
 *   @OA\Property(property="car", ref="#/components/schemas/Car"),
 *   @OA\Property(property="ended_report", ref="#/components/schemas/EndedReport"),
 *   @OA\Property(property="issue_reports", type="array", @OA\Items(ref="#/components/schemas/IssueReport")),
 *   @OA\Property(property="receipts", type="array", @OA\Items(ref="#/components/schemas/Receipt")),
 *   @OA\Property(property="late_notifications", type="array", @OA\Items(ref="#/components/schemas/LateNotification")),
 * )
 */
