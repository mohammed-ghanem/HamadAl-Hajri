<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLessonsTable extends Migration {

public function up()
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
			$table->longText('content')->nullable()->index();
			$table->integer('category_id')->unsigned();
			$table->string('pdf_file'); 
			$table->boolean('status')->default(0);
			$table->integer('view_count')->default(0);
			$table->integer('download_count')->default(0);
			$table->date('publish_date');
			$table->string('slug')->unique();
			$table->string('keywords');
			$table->longtext('description');
			$table->foreign('category_id')->references('id')->on('categories')
									->onDelete('cascade')
									->onUpdate('cascade'); 
		    $table->timestamps();
        });

       // DB::unprepared('ALTER TABLE lessons ADD UNIQUE key u_name_and_content (name,content(577))' );
    }

	public function down()
	{
		//DB::unprepared('ALTER TABLE lessons drop index `u_title_and_description`');
		Schema::dropIfExists('lessons');
	}
}