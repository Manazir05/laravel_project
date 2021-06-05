<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;

use App\Post;
use App\User;
use App\Country;
use App\Photo;
use App\Tag;

use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/admin', function () {
        return view('admin.index');
    });


// Route::get('/news', function () {
//     return view('news');
//     //return "Beluga rules.";
// });

// Route::get('/param/{id}/{name}', function ($id, $name) {
//     return "New ID is: ". $id. " ". $name;
//     //return "Beluga rules.";
// });

// Route::get('/add/post/ref', array( 'as' => 'admin.lte' , function() {

// 	$uri = route('admin.lte');

// 	return " ".$uri;

// }));

// //Route::get('/post/{id}' , 'PostController@index');

// Route::resource('/post' , 'PostController');

// Route::get('/postit/{id}/{name}/{pass}', 'PostController@show_post');

// Route::get('/cache', function () {
//     return 1;
// });


// // my test files

// Route::get('/gen_form', function () {
//     return view('genForm');
// });


// // Laravel RAW Sql
// Route::get('/rawsql', function(){

//     //$insert = DB::insert( 'Insert INTO posts(title , content) values(? ,?)' , ['PHP OOP', 'Learn with Edwin'] );
//     $read   = DB::Select('SELECT * FROM posts where id=?', [3]);
//     //$update = DB::update('Update posts set title = "Python & PHP" where id=? ', [2]);    
//     //$delete = DB::delete('Delete FROM posts where id=?', [1]);

//     return $read;
// });


/*
------------------------------------------------------
        *** Laravel Eloquent ORM *** 
------------------------------------------------------ 
*/


// Route::get('/eloquent', function(){

//     $find = Post::findOrFail(2);

//     return $find;
// });

// Route::get('/ormSave', function(){

//     // //insert with save()
//     // $post = new Post;
//     // $post->title = 'Boiler plates';
//     // $post->content = 'Helpful process'; 

//     //update with save()
//     $post = Post::findOrFail(3);
//     //$post->title = 'Blades';
//     $post->is_admin = 0;

//     $post->save();
    
// });

// Route::get('/ormCreate', function(){

//     //mass assignment
//     Post::create(['title'=>'Save laravel', 'content'=> 'Help glow with PhP!']);
    
// });

// Route::get('/ormUpdate', function(){

//     //update method
//     Post::where('id',3)->where('is_admin',0)->update(['title'=>'Awesome laravel', 'content'=> 'Really good codes!']);
    
// });

// // one delete method
// Route::get('/ormDelete', function(){

//     //delete method
//     $post = Post::find(2);
//     $post->delete();

// });


// // one delete method
// Route::get('/ormDelete', function(){

//     // //delete method
//     // $post = Post::find(2);
//     // $post->delete();

// });

// // another delete method
// Route::get('/ormDelete2', function(){

//     //destroy method single
//     //Post::destroy(2);

//     //destroy method multiple
//     Post::destroy([1,3]);

// });


// // soft delete method
// Route::get('/ormSoftDelete', function(){

//     //destroy method multiple
//     Post::find(4)->delete();

// });


// // read soft deleted records
// Route::get('/ormreadTrashRecords', function(){

//     //read trash data
//     //$post = Post::withTrashed()->where('is_admin',1)->get();

//     $post = Post::onlyTrashed()->where('is_admin',1)->get();

//     return $post;

// });


// // restore soft deleted records
// Route::get('/restore', function(){

//     //destroy method multiple
//     Post::withTrashed()->where('is_admin',1)->restore();

// });


// // permanently delete records
// Route::get('/permanentDelete', function(){

//     //destroy method multiple
//     //Post::onlyTrashed()->where('is_admin',1)->forceDelete();

//     Post::withTrashed()->whereNotNull('deleted_at')->forceDelete();

    

// });


/*
------------------------------------------------------
        *** Laravel Eloquent Relationships *** 
------------------------------------------------------ 
*/

// one - to - one
// Route::get('/user/{id}/post', function($id){
//     return User::find($id)->post->title;
// });

// // Inverse one - to - one
// Route::get('/post/{id}/user', function($id){
//     return Post::find($id)->user->name;
// });

// // one - to - many
// Route::get('/posts/{id}', function($id){
    
//     $user = User::find($id);

//     foreach($user->posts as $post)
//     {
//         echo $post->title. "<br>";
//     }
// });


// // many - to - many
// Route::get('/roles/{id}', function($id){
    
//     $user = User::find($id);

//     foreach($user->roles as $role)
//     {
//         echo $role->name. "<br>";
//     }
// });


// // many - to - many [access pivot table]
// Route::get('/user/pivot', function(){
    
//     $user = User::find(2);

//     foreach($user->roles as $role)
//     {
//         echo $role->pivot->created_at. "<br>";
//     }
// });


// // has - many - through
// Route::get('/user/country', function(){
    
//     $country = Country::find(5);

//     foreach($country->posts as $post)
//     {
//         echo $post->title. "<br>";
//     }

// });


// // polymorphic relations
// Route::get('/post/{id}/photos', function($id){
    
//     $posts = Post::find($id);

//     foreach($posts->photos as $photo)
//     {
//         echo $photo->path. "<br>";
//     }

// });


// // polymorphic relations inverse
// Route::get('/photos/{id}/post', function($id){
    
//     $photo = Photo::findOrFail($id);

//     return $photo->imageable;

// });


// // polymorphic many - to - many
// Route::get('/post_tag/tags', function(){
    
//     $posts = Post::find(6);

//     foreach($posts->tags as $tag)
//     {
//         echo $tag->name. "<br>";
//     }

// });


// // polymorphic retrieve owner
// Route::get('/tag/post', function(){
    
//     $tags = Tag::find(2);

//     foreach($tags->posts as $post)
//     {
//         echo $post->title. "<br>";
//     }

// });




/*
------------------------------------------------------
        *** Laravel CRUD Application *** 
------------------------------------------------------ 
*/


Route::group(['middleware'=> 'web'], function(){
        
        Route::resource('/posts', 'PostController');
});


Route::get('/dates', function(){

        $date = new dateTime('+1 week');

        echo $date->format('d-m-Y');

        echo "<br>";

        echo Carbon::now()->addDays(7)->diffForHumans();

        echo "<br>";

        echo Carbon::now()->addMonth(3)->diffForHumans();

        echo "<br>";

        echo Carbon::now()->subMonth(7)->diffForHumans();


});


Route::get('/getname', function(){

        $user = User::find(1);
        echo $user->name;
});


Route::get('/setname', function(){
        
        $user = User::find(1);
        $user->name = "william shatner";
        $user->save();
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
