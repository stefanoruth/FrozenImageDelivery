<?php

namespace App;

use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ImageController
{
	public function __invoke(ImageManager $manager, Request $request, $filename)
	{
		$path = storage_path("app/{$filename}");

		if (!file_exists($path)) {
			abort_if(404, 'Image not found');
		}

		$file = $manager->make($path);

		if ($request->has('size')) {
			list($width, $height) = explode('x', $request->get('size'));

			$file->resize($width, $height);
		}
		
		$file->encode('jpg');

		
		// dd($file);
		return response($file)->header('Content-Type', $file->mime);
	}
}