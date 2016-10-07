<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTaggingTagBatchTable extends Migration {

	public function up()
	{
		Schema::create('tagging_tag_batch', function(Blueprint $table) {
			$table->increments('id');
            $table->integer('tid')->unsigned();
			$table->integer('added_by')->unsigned();
			$table->string('taggable_type', 255)->index();
			$table->string('slug', 255)->index();
			$table->string('name', 255);
			$table->text('options');

            $table->foreign('tid')->references('id')->on('teams');
            $table->unique(['tid','taggable_type','name']);

            $table->foreign('added_by')->references('id')->on('users');

		});

	}
	public function down()
	{
		Schema::drop('tagging_tag_batch');
	}

}
