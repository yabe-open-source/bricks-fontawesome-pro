<?php

/*
 * This file is part of the Yabe Open Source package.
 *
 * (c) Joshua <suabahasa@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

defined('ABSPATH') || exit;

// add row action on the plugin list page
add_filter('plugin_action_links_' . plugin_basename(YOS_BRX_FONTAWESOME_PRO_FILE), 'yos_brx_fontawesome_pro_plugin_action_links');
function yos_brx_fontawesome_pro_plugin_action_links($links)
{
    // add upload link that has id `yos-brx-fontawesome-pro-upload` that will be used to trigger js script
    $links['yos-brx-fontawesome-pro-upload'] = '<a id="yos-brx-fontawesome-pro-admin-upload-link" style="cursor:pointer;">Upload</a>';
    return $links;
}

// include admin.js file on the `Plugins` page
add_action('admin_enqueue_scripts', 'yos_brx_fontawesome_pro_admin_enqueue_scripts');
function yos_brx_fontawesome_pro_admin_enqueue_scripts($hook)
{
    if ($hook !== 'plugins.php') {
        return;
    }

    // defer and type=module
    add_filter('script_loader_tag', function ($tag, $handle) {
        if ('yos-brx-fontawesome-pro-admin' !== $handle) {
            return $tag;
        }

        return str_replace(' src', ' type="module" defer src', $tag);
    }, 1_000_001, 2);

    wp_enqueue_style(
        'yos-brx-fontawesome-pro-admin',
        plugins_url('admin.css', __FILE__),
        [],
        (string) filemtime(__DIR__ . '/admin.css')
    );

    wp_enqueue_script(
        'yos-brx-fontawesome-pro-admin',
        plugins_url('admin.js', __FILE__),
        [],
        (string) filemtime(__DIR__ . '/admin.js'),
        true
    );

    wp_localize_script(
        'yos-brx-fontawesome-pro-admin',
        'yos_brx_fontawesome_pro_admin',
        [
            'iframe_src' => file_get_contents(__DIR__ . '/upload.html'),
            'rest_api' => [
                'nonce' => wp_create_nonce('wp_rest'),
                'root' => esc_url_raw(rest_url()),
                'namespace' => 'yos-brx-fontawesome-pro/v1',
                'url' => esc_url_raw(rest_url('yos-brx-fontawesome-pro/v1')),
            ],
        ]
    );
}
