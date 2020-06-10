<h1 align="center">Laravel 5 Boss System</h1>

<p align="center">:heart: This package helps you to add user based boss system to your model.</p>

<p align="center">
<a href="https://travis-ci.org/ricardosierra/laravel-boss"><img src="https://travis-ci.org/ricardosierra/laravel-boss.svg?branch=master" alt="Build Status"></a>
<a href="https://packagist.org/packages/ricardosierra/laravel-boss"><img src="https://poser.pugx.org/ricardosierra/laravel-boss/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/ricardosierra/laravel-boss"><img src="https://poser.pugx.org/ricardosierra/laravel-boss/v/unstable.svg" alt="Latest Unstable Version"></a>
<a href="https://scrutinizer-ci.com/g/ricardosierra/laravel-boss/build-status/master"><img src="https://scrutinizer-ci.com/g/ricardosierra/laravel-boss/badges/build.png?b=master" alt="Build Status"></a>
<a href="https://scrutinizer-ci.com/g/ricardosierra/laravel-boss/?branch=master"><img src="https://scrutinizer-ci.com/g/ricardosierra/laravel-boss/badges/quality-score.png?b=master" alt="Scrutinizer Code Quality"></a>
<a href="https://scrutinizer-ci.com/g/ricardosierra/laravel-boss/?branch=master"><img src="https://scrutinizer-ci.com/g/ricardosierra/laravel-boss/badges/coverage.png?b=master" alt="Code Coverage"></a>
<a href="https://packagist.org/packages/ricardosierra/laravel-boss"><img src="https://poser.pugx.org/ricardosierra/laravel-boss/downloads" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/ricardosierra/laravel-boss"><img src="https://poser.pugx.org/ricardosierra/laravel-boss/license" alt="License"></a>
</p>

## Features

- Support actions:
    - Boss
    - Like
    - Bookmark
    - Subscribe
    - Favorite
    - Vote (Upvote & Downvote)

## Installation

### Required

- PHP 7.0 +
- Laravel 5.5 +

You can install the package using composer

```sh
$ composer require ricardosierra/laravel-boss -vvv
```

Then add the service provider to `config/app.php`

```php
Boss\BossServiceProvider::class
```

Publish the migrations file:

```sh
$ php artisan vendor:publish --provider="Boss\BossServiceProvider" --tag="migrations"
```

As optional if you want to modify the default configuration, you can publish the configuration file:
 
```sh
$ php artisan vendor:publish --provider="Boss\BossServiceProvider" --tag="config"
```

And create tables:

```php
$ php artisan migrate
```

Finally, add feature trait into User model:

```php
use Boss\Traits\CanBoss;
use Boss\Traits\CanBeBossed;

class User extends Model
{
    use CanBoss, CanBeBossed;
}
```

## Usage

Add `CanXXX` Traits to User model.

```php
use Boss\Traits\CanBoss;
use Boss\Traits\CanLike;
use Boss\Traits\CanFavorite;
use Boss\Traits\CanSubscribe;
use Boss\Traits\CanVote;
use Boss\Traits\CanBookmark;

class User extends Model
{
    use CanBoss, CanBookmark, CanLike, CanFavorite, CanSubscribe, CanVote;
}
```

Add `CanBeXXX` Trait to target model, such as 'Post' or 'Music' ...:

```php
use Boss\Traits\CanBeLiked;
use Boss\Traits\CanBeFavorited;
use Boss\Traits\CanBeVoted;
use Boss\Traits\CanBeBookmarked;

class Post extends Model
{
    use CanBeLiked, CanBeFavorited, CanBeVoted, CanBeBookmarked;
}
```

All available APIs are listed below.

### Boss

#### `\Boss\Traits\CanBoss`

```php
$user->boss($targets)
$user->unboss($targets)
$user->toggleBoss($targets)
$user->bossings()->get() // App\User:class
$user->bossings(App\Post::class)->get()
$user->areBossingEachOther($anotherUser);
$user->isBossing($target)
```

#### `\Boss\Traits\CanBeBossed`

```php
$object->bossers()->get()
$object->isBossedBy($user)
```

### Bookmark

#### `\Boss\Traits\CanBookmark`

```php
$user->bookmark($targets)
$user->unbookmark($targets)
$user->toggleBookmark($targets)
$user->hasBookmarked($target)
$user->bookmarks()->get() // App\User:class
$user->bookmarks(App\Post::class)->get()
```

#### `\Boss\Traits\CanBeBookmarked`

```php
$object->bookmarkers()->get() // or $object->bookmarkers 
$object->isBookmarkedBy($user)
```

### Like

#### `\Boss\Traits\CanLike`

```php
$user->like($targets)
$user->unlike($targets)
$user->toggleLike($targets)
$user->hasLiked($target)
$user->likes()->get() // default object: App\User:class
$user->likes(App\Post::class)->get()
```

#### `\Boss\Traits\CanBeLiked`

```php
$object->likers()->get() // or $object->likers
$object->fans()->get() // or $object->fans
$object->isLikedBy($user)
```

### Favorite

#### `\Boss\Traits\CanFavorite`

```php
$user->favorite($targets)
$user->unfavorite($targets)
$user->toggleFavorite($targets)
$user->hasFavorited($target)
$user->favorites()->get() // App\User:class
$user->favorites(App\Post::class)->get()
```

#### `\Boss\Traits\CanBeFavorited`

```php
$object->favoriters()->get() // or $object->favoriters 
$object->isFavoritedBy($user)
```

### Subscribe

#### `\Boss\Traits\CanSubscribe`

```php
$user->subscribe($targets)
$user->unsubscribe($targets)
$user->toggleSubscribe($targets)
$user->hasSubscribed($target)
$user->subscriptions()->get() // default object: App\User:class
$user->subscriptions(App\Post::class)->get()
```

#### `Boss\Traits\CanBeSubscribed`

```php
$object->subscribers() // or $object->subscribers 
$object->isSubscribedBy($user)
```

### Vote

#### `\Boss\Traits\CanVote`

```php
$user->vote($target) // Vote with 'upvote' for default
$user->upvote($target)
$user->downvote($target)
$user->cancelVote($target)
$user->hasUpvoted($target)
$user->hasDownvoted($target)
$user->votes(App\Post::class)->get()
$user->upvotes(App\Post::class)->get()
$user->downvotes(App\Post::class)->get()
```

#### `\Boss\Traits\CanBeVoted`

```php
$object->voters()->get()
$object->upvoters()->get()
$object->downvoters()->get()
$object->isVotedBy($user)
$object->isUpvotedBy($user)
$object->isDownvotedBy($user)
```

### Parameters

All of the above mentioned methods of creating relationships, such as 'boss', 'like', 'unboss', 'unlike', their syntax is as bosss:

```php
boss(array|int|\Illuminate\Database\Eloquent\Model $targets, $class = __CLASS__)
```

So you can call them like this:

```php
// Id / Id array
$user->boss(1); // targets: 1, $class = App\User
$user->boss(1, App\Post::class); // targets: 1, $class = App\Post
$user->boss([1, 2, 3]); // targets: [1, 2, 3], $class = App\User

// Model
$post = App\Post::find(7);
$user->boss($post); // targets: $post->id, $class = App\Post

// Model array
$posts = App\Post::popular()->get();
$user->boss($posts); // targets: [1, 2, ...], $class = App\Post
```

### Query relations

```php
$bossers = $user->bossers
$bossers = $user->bossers()->where('id', '>', 10)->get()
$bossers = $user->bossers()->orderByDesc('id')->get()
```

The other is the same usage.

### Working with model.

```php
use Boss\BossRelation;

// get most popular object

// all types
$relations = BossRelation::popular()->get();

// bossable_type = App\Post
$relations = BossRelation::popular(App\Post::class)->get(); 

// bossable_type = App\User
$relations = BossRelation::popular('user')->get();
 
// bossable_type = App\Post
$relations = BossRelation::popular('post')->get();

// Pagination
$relations = BossRelation::popular(App\Post::class)->paginate(15); 

```

### Events

 - `Boss\RelationAttaching`
 - `Boss\RelationAttached`
 - `Boss\RelationDetaching`
 - `Boss\RelationDetached`
 - `Boss\RelationToggling`
 - `Boss\RelationToggled`


```php
Event::listen(\Boss\RelationAttached::class, function($event) {
    // $event->causer; 
    // $event->getTargetsCollection(); 
    // $event->getRelationType();
});
```

# About toggled event.

There has a extra properties for `Boss\RelationToggled` event.

```php
$event->results; // ['attached' => [1, 2, 3], 'detached' => [5, 6]]
$event->attached; // [1, 2, 3]
$event->detached; // [5, 6]
```

## PHP 扩展包开发

> 想知道如何从零开始构建 PHP 扩展包？
>
> 请关注我的实战课程，我会在此课程中分享一些扩展开发经验 —— [《PHP 扩展包实战教程 - 从入门到发布》](https://learnku.com/courses/creating-package)

## License

MIT
# laravel-boss
