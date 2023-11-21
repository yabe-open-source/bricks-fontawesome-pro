<?php

/**
 * @wordpress-plugin
 * Plugin Name:         Yabe Ko-fi - Bricks Font Awesome Pro
 * Plugin URI:          https://ko-fi.yabe.land
 * Description:         Bricks builder: Font Awesome 6 Pro integration
 * Version:             1.0.0-DEV
 * Requires at least:   6.0
 * Requires PHP:        7.4
 * Author:              Rosua
 * Author URI:          https://rosua.org
 * Donate link:         https://ko-fi.com/Q5Q75XSF7
 * Text Domain:         yabe-ko-fi-brx-fontawesome-pro
 * Domain Path:         /languages
 *
 * @package             Yabe Ko-fi
 * @author              Joshua Gugun Siagian <suabahasa@gmail.com>
 */

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

define('YKF_BRX_FONTAWESOME_PRO_FILE', __FILE__);

if (!class_exists('\ZipArchive')) {
    add_action('admin_notices', function () {
        echo '<div class="notice notice-error"><p><b>Yabe Ko-fi - Bricks Font Awesome Pro</b>: The <code>ZipArchive</code> class is not available. Please contact your hosting provider to install and enable the <code>zip</code> PHP extension.</p></div>';
    });
    return;
}

require_once __DIR__ . '/api.php';

if (is_admin()) {
    require_once __DIR__ . '/admin.php';
}

require_once __DIR__ . '/builder.php';
