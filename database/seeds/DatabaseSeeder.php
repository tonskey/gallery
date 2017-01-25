<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use Orchestra\Imagine\Facade as Imagine;
use Illuminate\Support\Facades\Storage;
function create_thumbnail($path,$filename,$ext)
{
	$width=150;
	$height=150;
	$mode=ImageInterface::THUMBNAIL_OUTBOUND;
	$size=new Box($width,$height);
	$thumb=Imagine::open("{$path}/${filename}.{$ext}")->thumbnail($size,$mode);
	$destination="{$filename}.thumb.{$ext}";
	$thumb->save("{$path}/{$destination}");
	return "{$path}/{$destination}";
}
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$photos=File::files('public/img');
		$faker=Faker\Factory::create();
		for($i=0;$i<12*5;$i++)
		{
			$photo=$photos[rand(0,count($photos)-1)];
			// $photo=str_replace('public/',"", $photo);
			$t=create_thumbnail(
					pathinfo($photo)['dirname'],
					pathinfo($photo)['filename'],
					pathinfo($photo)['extension']
			);
			DB::table('pictures')->insert([
				'title'=>$faker->sentence,
				'description'=>$faker->paragraph.$faker->paragraph.$faker->paragraph,
				'views'=>rand(0,1000),
				'picture'=>str_replace("public","", $photo),
				'thumb'=>str_replace("public","", $t),
				'created_at'=>$faker->dateTime
			]);
		}
    }
}
