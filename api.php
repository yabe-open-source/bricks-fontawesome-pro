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

// add wp-json/ykf-brx-fontawesome-pro/v1/upload endpoint
add_action('rest_api_init', 'ykf_brx_fontawesome_pro_rest_api_init');
function ykf_brx_fontawesome_pro_rest_api_init()
{
    register_rest_route(
        'ykf-brx-fontawesome-pro/v1',
        '/upload',
        [
            'methods' => 'POST',
            'callback' => 'ykf_brx_fontawesome_pro_rest_api_upload',
            'permission_callback' => function ($wprestRequest) {
                return wp_verify_nonce($wprestRequest->get_header('X-WP-Nonce'), 'wp_rest') && current_user_can('manage_options');
            },
        ]
    );
}

// handle upload
function ykf_brx_fontawesome_pro_rest_api_upload(WP_REST_Request $request)
{
    $response = [
        'success' => false,
        'message' => '',
    ];

    $file = $request->get_file_params();
    if (empty($file)) {
        $response['message'] = esc_html__('No file uploaded.', 'ykf-brx-fontawesome-pro');
        return new WP_REST_Response($response, 400);
    }

    $file = $file['file'];
    if (!is_array($file)) {
        $response['message'] = esc_html__('Invalid file.', 'ykf-brx-fontawesome-pro');
        return new WP_REST_Response($response, 400);
    }


    if ($file['type'] !== 'application/zip') {
        $response['message'] = esc_html__('Invalid file type.', 'ykf-brx-fontawesome-pro');
        return new WP_REST_Response($response, 400);
    }

    $zip = new ZipArchive();
    $zip->open($file['tmp_name']);
    $zip->extractTo(WP_CONTENT_DIR . '/uploads/ykf-brx-fontawesome-pro');

    $zip->close();

    $response['success'] = true;
    $response['message'] = esc_html__('Upload success.', 'ykf-brx-fontawesome-pro');
    return new WP_REST_Response($response);
}
