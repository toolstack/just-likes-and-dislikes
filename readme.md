# Just Likes and Dislikes #
**Contributors:** [gregross](https://profiles.wordpress.org/gregross/)  
**Tags:** like, dislike, posts, pages, comments  
**Requires at least:** 5.0  
**Tested up to:** 6.0  
**Stable tag:** 2.0  
**License:** GPLv2 or later  
**License URI:** http://www.gnu.org/licenses/gpl-2.0.html  

Like and dislike feature for WordPress.

## Description ##
**Just Likes and Dislikes is a fork of the excellent [Post Like Dislike](https://wordpress.org/plugins/posts-like-dislike/) and [Comment Like and Dislike](https://wordpress.org/plugins/comments-like-dislike/) by [WP Happy Coders](http://wphappycoders.com/)**

Just Likes and Dislikes enables like and dislike icons for posts, pages and comments. Choose Thumbs Up or Thumbs Down, Smiley or Frown, Right or Wrong icons or your own custom like dislike icons, the choice is yours.

Just Likes and Dislikes increases the interaction with the WordPress by enabling likes and dislikes buttons along with the count.

### See full features list below: ###
* Status
    - Enable or Disable Just Likes and Dislikes for posts/page or any other post types
* Like Dislike Position
    - After Post
    - Before Post
* Like Dislike Display
    - Display Both Like and Dislike
    - Display Like Only
    - Display Dislike Only
* Like Dislike Restriction
    - Cookie Restriction
    - IP Restriction
    - No Restriction
* Like Dislike Order
    - Like Dislike
    - Dislike Like
* 4 Pre Available Icon Templates
    - Thumbs Up Thumbs Down
    - Heart or Heart Beat
    - Right or Wrong
    - Smiley or Frown
* Custom Like Dislike Icon Upload feature
* Icon Color Configuration
* Count Color Configuration

### Shortcode ###
[just_like_and_dislike id=post_id]
Please replace post_id with the id of the post or remove id parameter for considering the post id as the id of global $post object

### Custom Function ###
`<?php echo do_shortcode('[just_like_and_dislike id=post_id]');?>`
Please replace post_id with the id of the post or remove id parameter for considering the post id as the id of global $post object

## Installation ##

1. Upload the plugin files to the `/wp-content/plugins/just-like-and-dislike` directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the 'Plugins' screen in WordPress
1. Use the Just Likes and Dislikes settings page inside the Posts Menu to configure the plugin

## Frequently Asked Questions ##
### What does this plugin do ? ###
This plugin provides the ability to add the like and dislike buttons for WordPress native posts.

### I have enabled the plugin but like and dislike icons are not being displayed. What may be the reason ? ###
Our plugin uses the_content filter to append like and dislike icons . So if your active theme's posts template doesn't use the_content filter to display posts content then our plugin won't be able to display like and dislike icons.

### Is there any hooks available to extend the plugin ? ###
Our plugin does contains many actions and filters which are described inside the Help Section

### I want to display in the post detail template. Do you have a custom function? ###
We do have a shortcode [posts_like_dislike] which can also be used as custom function through `<?php echo do_shortcode('[posts_like_dislike]');?>`

## Screenshots ##

### 1. Like Dislike Icon Template 1 ###
![Like Dislike Icon Template 1](assets/screenshot-1.png)

### 2. Like Dislike Icon Template 2 ###
![Like Dislike Icon Template 2](assets/screenshot-2.png)

### 3. Like Dislike Icon Template 3 ###
![Like Dislike Icon Template 3](assets/screenshot-3.png)

### 4. Like Dislike Icon Template 4 ###
![Like Dislike Icon Template 4](assets/screenshot-4.png)

### 5. Like Dislike Basic Settings ###
![Like Dislike Basic Settings](assets/screenshot-5.png)

### 6. Like Dislike Design Settings ###
![Like Dislike Design Settings](assets/screenshot-6.png)


## Changelog ##
### 2.0 ###
* Release date: TBD
* Add sortable columns to the admin posts list
* Add filter for Yoast Duplicate Posts so the like/dislike count is reset
* Add proper meta data registration
* Removed like/dislike counts from excerpts and embeds
* Remove old internationalization code
* Fix widget width for Gutenberg
* Update font awesome to v6.2.1

### 1.0.8 ###
* Release date: 21/7/2022
* WP 6.0 compatibility checked

### 1.0.7 ###
* Release date: 13/2/2021
* Added post id to shortcode

### 1.0.6 ###
* Release date: 20/7/2021
* WP 5.7 compatibility checked

### 1.0.5 ###
* Release date: 6/6/2021
* Fixed login restriction mode issue
* Fixed ajax load issue
* Fixed some security issues

### 1.0.4 ###
* Release date: 11/12/2020
* WP 5.6 compatibility checked

### 1.0.3 ###
* Release date: 7/9/2020
* Added Post Like Dislike Count Info Metabox
* Added an option to display 0 by default
* Added alt tag in the custom image
* Removed default post type select
* Added [posts_like_dislike] shortcode

### 1.0.2 ###
* Release date: 4/4/2020
* WP 5.4 compatibility checked

### 1.0.1 ###
* Release date: 8/5/2019
* Added custom post type support
* Updated the backend settings save mechanism
* Added array sanitization functions

### 1.0.0 ###
* Release date: 8/5/2019
* Initial plugin commit to wordpress.org repository

## Upgrade Notice ##
There is a new update. Please update to the latest version to get the new features and bug fixes.