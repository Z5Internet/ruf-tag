<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateTaggingTagsTable extends Migration {

	public function up() {

		Schema::table('tagging_tags', function(Blueprint $table) {

			$table->integer('tag_batch_id')->unsigned()->nullable()->after('id');
            $table->foreign('tag_batch_id')->references('id')->on('tagging_tag_batch');

		});

	}

	public function down() {

		Schema::table('tagging_tags', function ($table) {
			$table->dropForeign('tagging_tags_tag_batch_id_foreign');
			$table->dropColumn('tag_batch_id');
		});

	}
}
