<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMobilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mobiles', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('brand_id');
            $table->string('name');
            $table->boolean('is_top')->default(false);
            $table->integer('top_of_year')->nullable();
            $table->string("os");
            $table->string("availability");
            $table->string("ui")->nullable();
            $table->string("dimensions");
            $table->decimal("weight", 8, 2);
            $table->string("sim");
            $table->string("colors");
            $table->boolean("2g");
            $table->boolean("3g");
            $table->boolean("4g");
            $table->boolean("5g");
            $table->decimal("cpu", 8, 3);
            $table->integer("core");
            $table->string("cover");
            $table->string("gpu")->nullable();
            $table->string("display_technology")->nullable();
            $table->decimal("screen_size", 8, 3);
            $table->integer("resolution_width");
            $table->integer("resolution_height");
            $table->integer("ram");
            $table->integer("storage");
            $table->string("external_card");
            $table->integer("camera_main");
            $table->string("camera_main_string");
            $table->boolean("flash_main");
            $table->integer("camera_front");
            $table->string("camera_front_string");
            $table->boolean("flash_front");
            $table->integer("camera_main_video");
            $table->integer("camera_front_video");
            $table->boolean("wifi");
            $table->boolean("hotspot");
            $table->boolean("bluetooth");
            $table->boolean("gps");
            $table->string("usb");
            $table->string("mobile_data_connection");
            $table->boolean("fingerprint");
            $table->boolean("infrared");
            $table->boolean("gyro");
            $table->boolean("compass");
            $table->string("audio");
            $table->string("audio_format");
            $table->string("browser");
            $table->string("messaging");
            $table->string("games");
            $table->integer("battery_capacity");
            $table->string("fast_charging");
            $table->decimal("price", 18, 3);
            $table->text("description");
            $table->string("video_review")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mobiles');
    }
}