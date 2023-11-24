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

// add wp-json/yos-brx-fontawesome-pro/v1/upload endpoint
add_action('rest_api_init', 'yos_brx_fontawesome_pro_rest_api_init');
function yos_brx_fontawesome_pro_rest_api_init()
{
    register_rest_route(
        'yos-brx-fontawesome-pro/v1',
        '/upload',
        [
            'methods' => 'POST',
            'callback' => 'yos_brx_fontawesome_pro_rest_api_upload',
            'permission_callback' => function ($wprestRequest) {
                return wp_verify_nonce($wprestRequest->get_header('X-WP-Nonce'), 'wp_rest') && current_user_can('manage_options');
            },
        ]
    );
}

// handle upload
function yos_brx_fontawesome_pro_rest_api_upload(WP_REST_Request $request)
{
    $response = [
        'success' => false,
        'message' => '',
    ];

    $file = $request->get_file_params();
    if (empty($file)) {
        $response['message'] = 'No file uploaded.';
        return new WP_REST_Response($response, 400);
    }

    $file = $file['file'];
    if (!is_array($file)) {
        $response['message'] = 'Invalid file.';
        return new WP_REST_Response($response, 400);
    }


    if ($file['type'] !== 'application/zip') {
        $response['message'] = 'Invalid file type.';
        return new WP_REST_Response($response, 400);
    }

    $zip = new ZipArchive();
    $zip->open($file['tmp_name']);
    $zip->extractTo(WP_CONTENT_DIR . '/uploads/yos-brx-fontawesome-pro');

    $zip->close();

    $response['success'] = true;
    $response['message'] = 'Upload success.';
    return new WP_REST_Response($response);
}
