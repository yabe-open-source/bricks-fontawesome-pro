<?php

/*
 * This file is part of the Yabe Ko-fi package.
 *
 * (c) Joshua <suabahasa@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

defined('ABSPATH') || exit;

// add row action on the plugin list page
add_filter('plugin_action_links_' . plugin_basename(YKF_BRX_FONTAWESOME_PRO_FILE), 'ykf_brx_fontawesome_pro_plugin_action_links');
function ykf_brx_fontawesome_pro_plugin_action_links($links)
{
    // add upload link that has id `ykf-brx-fontawesome-pro-upload` that will be used to trigger js script
    $links['ykf-brx-fontawesome-pro-upload'] = '<a id="ykf-brx-fontawesome-pro-admin-upload-link" style="cursor:pointer;">Upload</a>';
    return $links;
}

// include admin.js file on the `Plugins` page
add_action('admin_enqueue_scripts', 'ykf_brx_fontawesome_pro_admin_enqueue_scripts');
function ykf_brx_fontawesome_pro_admin_enqueue_scripts($hook)
{
    if ($hook !== 'plugins.php') {
        return;
    }

    // defer and type=module
    add_filter('script_loader_tag', function ($tag, $handle) {
        if ('ykf-brx-fontawesome-pro-admin' !== $handle) {
            return $tag;
        }

        return str_replace(' src', ' type="module" defer src', $tag);
    }, 1_000_001, 2);

    wp_enqueue_style(
        'ykf-brx-fontawesome-pro-admin',
        plugins_url('admin.css', __FILE__),
        [],
        (string) filemtime(__DIR__ . '/admin.css')
    );

    wp_enqueue_script(
        'ykf-brx-fontawesome-pro-admin',
        plugins_url('admin.js', __FILE__),
        ['jquery'],
        (string) filemtime(__DIR__ . '/admin.js'),
        true
    );

    wp_localize_script(
        'ykf-brx-fontawesome-pro-admin',
        'ykf_brx_fontawesome_pro_admin',
        [
            'iframe_src' => file_get_contents(__DIR__ . '/upload.html'),
            'rest_api' => [
                'nonce' => wp_create_nonce('wp_rest'),
                'root' => esc_url_raw(rest_url()),
                'namespace' => 'ykf-brx-fontawesome-pro/v1',
                'url' => esc_url_raw(rest_url('ykf-brx-fontawesome-pro/v1')),
            ],
        ]
    );
}
