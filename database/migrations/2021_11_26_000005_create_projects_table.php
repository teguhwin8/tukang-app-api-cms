<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('owner');
            $table->longText('address')->nullable();
            $table->string('whatsapp')->nullable();
            $table->date('start_date');
            $table->date('due_date');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
