<?php 
namespace Boravel\Http\Controllers\Modules\Midia;

use Boravel\Models\Digital\Midia\Photo;
use Boravel\Models\Digital\Midia\PhotoAlbum;

class PhotoController extends Controller {

    public function show($id)
	{
        $photo_album = PhotoAlbum::find($id);
        $photos = Photo::where('photo_album_id', $id)->get();

        return view('photo.view_album',compact('photos','photo_album'));
	}

}
