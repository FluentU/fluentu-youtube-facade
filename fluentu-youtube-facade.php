<?php

/**
 * @link              https://www.fluentu.com
 * @since             0.0.1
 * @package           FluentuYoutubeFacade
 *
 * @wordpress-plugin
 * Plugin Name:       Fluentu Youtube Facade
 * Plugin URI:        https://github.com/FluentU/fluentu-youtube-facade
 * Description:       Simple plugin to replace Youtube iframes with placeholder.
 * Version:           0.0.2
 * Author:            Elco Brouwer von Gonzenbach
 * Author URI:        https://github.com/elcobvg
 * Text Domain:       fluentu-youtube-facade
 */

// If this file is called directly, abort.
if (! defined('WPINC')) {
    die;
}

/**
 * Main plugin class
 */
class FluentuYoutubeFacade
{
    /**
     * Constructor sets up all necessary action hooks and filters
     *
     * @return void
     */
    public function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'scripts']);
        add_filter('the_content', [$this, 'replaceIframes'], 9999);
    }

    /**
     * Enqueue CSS and JavaScript
     *
     * @return void
     */
    public function scripts()
    {
        $code_dir = plugin_dir_url(__FILE__) . 'lite-youtube-embed/src/';
        wp_enqueue_style('fluentu-youtube-facade', $code_dir . 'lite-yt-embed.css');
        wp_enqueue_script('fluentu-youtube-facade', $code_dir . 'lite-yt-embed.js', [], null, true);
    }

    /**
     * Replace the Youtube iframes with placeholder elements
     *
     * @param  string $content the post content
     * @return string          content with custom elements
     */
    public function replaceIframes(string $content): string
    {
        $pattern = '/<iframe[ \S]* src="[\S]+youtube+[\S]+embed\/([a-zA-Z0-9_-]+)[\S]*"[ \S]*><\/iframe>/';
        return preg_replace($pattern, '<lite-youtube videoid="$1"></lite-youtube>', $content);
    }
}

/**
 * Begins execution of the plugin.
 */
new FluentuYoutubeFacade();

