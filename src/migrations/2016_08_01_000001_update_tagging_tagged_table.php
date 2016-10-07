<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateTaggingTaggedTable extends Migration {

	public function up() {

		Schema::table('tagging_tagged', function(Blueprint $table) {

			$table->integer('tid')->unsigned()->after('id');
            $table->foreign('tid')->references('id')->on('teams');

			$table->integer('added_by')->unsigned();
            $table->foreign('added_by')->references('id')->on('users');

			$table->integer('tag_batch_id')->unsigned()->nullable()->after('id');
            $table->foreign('tag_batch_id')->references('id')->on('tagging_tag_batch');

		});

	}

	public function down() {

		Schema::table('tagging_tagged', function ($table) {

			$table->dropForeign('tagging_tagged_tag_batch_id_foreign');
			$table->dropColumn('tag_batch_id');

            $table->dropForeign('tagging_tagged_added_by_foreign');
			$table->dropColumn('added_by')->unsigned();

			$table->dropForeign('tagging_tagged_tid_foreign');
			$table->dropColumn('tid');

		});

	}
}
