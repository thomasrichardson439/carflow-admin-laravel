<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGeoFunction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
            CREATE FUNCTION `geoDiffBetweenDotsInMeters`(`phiA` DOUBLE, `lamA` DOUBLE, `phiB` DOUBLE, `lamB` DOUBLE) RETURNS double
            BEGIN
            DECLARE lat1 double;
                declare lat2 double;
                declare long1 double;
                declare long2 double;

            declare EARTH_RADIUS int;

            declare cl1 double;
                declare cl2 double;
                declare sl1 double;
                declare sl2 double;
                declare delta double;
                declare cdelta double;
                declare sdelta double;

            declare y double;
                declare x double;
                declare dist double;
                declare ad double;

            set EARTH_RADIUS = 6372795;

                set lat1 = phiA * PI() / 180;
                set lat2 = phiB * PI() / 180;
                set long1 = lamA * PI() / 180;
                set long2 = lamB * PI() / 180;

                set cl1 = cos(lat1);
                set cl2 = cos(lat2);
                set sl1 = sin(lat1);
                set sl2 = sin(lat2);
                set delta = long2 - long1;
                set cdelta = cos(delta);
                set sdelta = sin(delta);

                set y = sqrt(pow(cl2 * sdelta, 2) + pow(cl1 * sl2 - sl1 * cl2 * cdelta, 2));
                set x = sl1 * sl2 + cl1 * cl2 * cdelta;

                set ad = atan2(y, x);
                set dist = ad * EARTH_RADIUS;

                return dist;
            END
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP FUNCTION geoDiffBetweenDotsInMeters');
    }
}
