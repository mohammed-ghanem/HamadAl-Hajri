<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration {

	public function up()
	{
		Schema::create('articles', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name')->index();
			$table->integer('category_id')->unsigned();
			// $table->string('image')->nullable();
			$table->string('pdf_file')->nullable();
			$table->longText('content')->index();
			$table->integer('view_count')->default(0);
			$table->integer('download_count')->default(0);
			$table->date('publish_date');
			$table->string('slug')->unique();
			$table->boolean('status')->default(1);
			$table->string('keywords');
			$table->longtext('description');
			$table->foreign('category_id')->references('id')->on('categories')
						->onDelete('cascade')
						->onUpdate('cascade');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('articles');
	}
}