<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->enum("visibility",["Public","Private"])->default("Public");
            $table->enum("status",["Pending","Approved","Rejected"])->default("Pending")->comment("Approved or Pending");
            $table->string("access_code")->unique()->nullable();
            $table->bigInteger("user_id");
            $table->bigInteger("cat_id");
            $table->bigInteger("sub_id");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
