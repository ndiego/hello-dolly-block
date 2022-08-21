<?php
/**
 * Plugin Name:       Hello Dolly Block
 * Description:       The original Hello Dolly plugin, but in block form.
 * Requires at least: 5.9
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            Nick Diego
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       hello-dolly-block
 *
 * @package           create-block
 */

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function create_block_hello_dolly_block_block_init() {
	register_block_type( 
		__DIR__ . '/build',
		array( 'render_callback' => 'render_hello_dolly_block' )
	);
}
add_action( 'init', 'create_block_hello_dolly_block_block_init' );

/**
 * Renders the Holl Dolly Block on the frontend.
 *
 * @param array $attributes All attributes associated with the block.
 */
function render_hello_dolly_block( $attributes ) {
	$text_align         = $attributes[ 'textAlign' ];
    $wrapper_attributes = get_block_wrapper_attributes();

	if ( $text_align ) {
		$wrapper_attributes = get_block_wrapper_attributes( 
			array( 'class' => 'has-text-align-' . $text_align ) 
		);
	}

	$hello_dolly_lyric = hello_dolly();

    return sprintf( '<div %1$s>%2$s</div>', $wrapper_attributes, $hello_dolly_lyric );
}

/**
 * The original lyric function from Hello Dolly by Matt Mullenweg.
 *
 * @see https://plugins.trac.wordpress.org/browser/hello-dolly/trunk/hello.php
 */
function hello_dolly_get_lyric() {
	/** These are the lyrics to Hello Dolly */
	$lyrics = "Hello, Dolly
Well, hello, Dolly
It's so nice to have you back where you belong
You're lookin' swell, Dolly
I can tell, Dolly
You're still glowin', you're still crowin'
You're still goin' strong
I feel the room swayin'
While the band's playin'
One of our old favorite songs from way back when
So, take her wrap, fellas
Dolly, never go away again
Hello, Dolly
Well, hello, Dolly
It's so nice to have you back where you belong
You're lookin' swell, Dolly
I can tell, Dolly
You're still glowin', you're still crowin'
You're still goin' strong
I feel the room swayin'
While the band's playin'
One of our old favorite songs from way back when
So, golly, gee, fellas
Have a little faith in me, fellas
Dolly, never go away
Promise, you'll never go away
Dolly'll never go away again";

	// Here we split it into lines.
	$lyrics = explode( "\n", $lyrics );

	// And then randomly choose a line.
	return wptexturize( $lyrics[ mt_rand( 0, count( $lyrics ) - 1 ) ] );
}

/**
 * The original function from Hello Dolly by Matt Mullenweg. To work within a 
 * block context, printf was changed to sprintf.
 *
 * @see https://plugins.trac.wordpress.org/browser/hello-dolly/trunk/hello.php
 */
function hello_dolly() {
	$chosen = hello_dolly_get_lyric();
	$lang   = '';
	if ( 'en_' !== substr( get_user_locale(), 0, 3 ) ) {
		$lang = ' lang="en"';
	}

	return sprintf(
		'<p id="dolly"><span class="screen-reader-text">%s </span><span dir="ltr"%s>%s</span></p>',
		__( 'Quote from Hello Dolly song, by Jerry Herman:', 'hello-dolly' ),
		$lang,
		$chosen
	);
}
