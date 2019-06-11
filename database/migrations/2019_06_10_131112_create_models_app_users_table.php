<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModelsAppUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        echo "creating Assets table...";
        $this->createAssetsTable();
        echo "    DONE", PHP_EOL;
        echo "creating AppUsers table...";
        $this->createAppUsersTable();
        echo "    DONE", PHP_EOL;
        echo "creating Radios table...";
        $this->createRadiosTable();
        echo "    DONE", PHP_EOL;
        echo "creating Genres table...";
        $this->createGenresTable();
        echo "    DONE", PHP_EOL;
        echo "creating CreateRadioGenres table...";
        $this->createCreateRadioGenresTable();
        echo "    DONE", PHP_EOL;
        echo "creating CreateContents table...";
        $this->createCreateContentsTable();
        echo "    DONE", PHP_EOL;
        echo "creating ContentParticipation table...";
        $this->createContentParticipationTable();
        echo "    DONE", PHP_EOL;
        echo "creating Advertiser table...";
        $this->createAdvertiserTable();
        echo "    DONE", PHP_EOL;
        echo "creating ContentAdvertiser table...";
        $this->createContentAdvertiserTable();
        echo "    DONE", PHP_EOL;
    }

    private function createAssetsTable()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('origin_asset_id')->nullable();
            $table->string('path');
            $table->string('disk')->default('');
            $table->string('md5sum')->nullable();
            $table->string('shasum')->nullable();
            $table->unsignedInteger('size')->nullable();
            $table->string('mime_type')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('origin_asset_id')
                ->references('id')->on('assets')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

    private function createAppUsersTable()
    {
        Schema::create('app_users', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('facebook_id')->unique();
            $table->string('name')->nullable();
            $table->string('phone_number');
            $table->enum('gender', ['male', 'female', 'trans', 'other', 'secret'])->nullable();
            $table->dateTime('birthday')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->primary('id');
        });
    }

    private function createRadiosTable()
    {
        Schema::create('radios', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('name');
            $table->string('description');
            $table->string('city');
            $table->string('estate');
            $table->unsignedBigInteger('avatar_asset_id')->nullable();
            $table->text('data_array');
            $table->softDeletes();

            $table->primary('id');

            $table->foreign('avatar_asset_id')
                ->references('id')->on('assets')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

    private function createGenresTable()
    {
        Schema::create('genres', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description', 100);
            $table->timestamps();
        });
    }

    private function createCreateRadioGenresTable()
    {
        Schema::create('radio_genres', function (Blueprint $table) {
            $table->uuid('radio_id');
            $table->unsignedInteger('genre_id');
            $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));

            $table->primary(['radio_id', 'genre_id']);

            $table->index(["radio_id"]);
            $table->index(["genre_id"]);
            $table->index(["radio_id", "genre_id"]);

            $table->foreign('genre_id')
                ->references('id')->on('genres')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('radio_id')
                ->references('id')->on('radios')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    private function createCreateContentsTable()
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('radio_id');
            $table->string('text')->nullable();
            $table->unsignedBigInteger('image_asset_id')->nullable();
            $table->string('action_label')->nullable();
            $table->string('action_url')->nullable();
            $table->text('promotion_array');
            $table->timestamps();
            $table->softDeletes();

            $table->primary('id');

            $table->foreign('radio_id')
                ->references('id')->on('radios')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('image_asset_id')
                ->references('id')->on('assets')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

    private function createContentParticipationTable()
    {
        Schema::create('content_participations', function (Blueprint $table) {
            $table->uuid('app_user_id');
            $table->uuid('content_id');
            $table->boolean('is_winner')->default(false);
            $table->text('promotion_answer_array');
            $table->timestamps();
            $table->softDeletes();

            $table->primary(['app_user_id', 'content_id']);

            $table->foreign('content_id')
                ->references('id')->on('contents')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('app_user_id')
                ->references('id')->on('app_users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    private function createAdvertiserTable()
    {
        Schema::create('advertisers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->unsignedBigInteger('avatar_asset_id')->nullable();
            $table->string('url')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('avatar_asset_id')
                ->references('id')->on('assets')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

    private function createContentAdvertiserTable()
    {
        Schema::create('content_advertisers', function (Blueprint $table) {
            $table->uuid('content_id');
            $table->unsignedBigInteger('advertiser_id');
            $table->string('url')->nullable();
            $table->unsignedBigInteger('image_asset_id')->nullable();
            $table->timestamps();

            $table->primary(['content_id', 'advertiser_id']);

            $table->foreign('content_id')
                ->references('id')->on('contents')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('advertiser_id')
                ->references('id')->on('advertisers')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('image_asset_id')
                ->references('id')->on('assets')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('content_advertisers');
        Schema::dropIfExists('advertisers');
        Schema::dropIfExists('content_participations');
        Schema::dropIfExists('contents');
        Schema::dropIfExists('radio_genres');
        Schema::dropIfExists('genres');
        Schema::dropIfExists('radios');
        Schema::dropIfExists('app_users');
        Schema::dropIfExists('assets');
    }
}
