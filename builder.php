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

use Bricks\Database;
use Bricks\Helpers;
use Bricks\Theme_Styles;

add_action('wp_enqueue_scripts', 'ykf_brx_fontawesome_pro', 1_000_001);

function ykf_brx_fontawesome_pro()
{
    if (!defined('BRICKS_VERSION')) {
        return;
    }

    if (!is_dir(wp_upload_dir()['basedir'] . '/ykf-brx-fontawesome-pro')) {
        return;
    }

    // remove Bricks built-in
    wp_dequeue_style('bricks-font-awesome-6-brands');
    wp_dequeue_style('bricks-font-awesome-6');

    /** @see \Bricks\Assets::enqueue_setting_specific_scripts() */
    $bricks_settings_string  = wp_json_encode(Database::get_template_data('header'));
    $bricks_settings_string .= wp_json_encode(Database::get_template_data('content'));
    $bricks_settings_string .= wp_json_encode(Database::get_template_data('footer'));

    // Loop over popup template data to enqueue 'bricks-animate' for popups too (@since 1.6)
    $popup_template_ids = Database::$active_templates['popup'];

    foreach ($popup_template_ids as $popup_template_id) {
        $bricks_settings_string .= wp_json_encode(Database::get_data($popup_template_id));

        // Get popup template settings (contain animation from popup interactions)
        $bricks_settings_string .= wp_json_encode(Helpers::get_template_settings($popup_template_id));
    }

    $theme_style_settings_string = wp_json_encode(Theme_Styles::$active_settings);

    // Add settings of used global element to Bricks settings string
    if (strpos($bricks_settings_string, '"global"')) {
        $global_elements = Database::$global_data['elements'] ? Database::$global_data['elements'] : [];

        foreach ($global_elements as $global_element) {
            $global_element_id = !empty($global_element['global']) ? $global_element['global'] : false;

            if (!$global_element_id) {
                $global_element_id = !empty($global_element['id']) ? $global_element['id'] : false;
            }

            if ($global_element_id) {
                if (strpos($bricks_settings_string, $global_element_id)) {
                    $bricks_settings_string .= wp_json_encode($global_element);
                }
            }
        }
    }

    $cache_base_dir = wp_upload_dir()['basedir'] . '/ykf-brx-fontawesome-pro/';
    $cache_base_url = wp_upload_dir()['baseurl'] . '/ykf-brx-fontawesome-pro/';

    // core styling file
    if (
        bricks_is_builder() ||
        strpos($bricks_settings_string, '"library":"fontawesomeBrands') ||
        strpos($theme_style_settings_string, '"library":"fontawesomeBrands') ||
        strpos($bricks_settings_string, '"library":"fontawesomeRegular') ||
        strpos($theme_style_settings_string, '"library":"fontawesomeRegular') ||
        strpos($bricks_settings_string, '"library":"fontawesomeSolid') ||
        strpos($theme_style_settings_string, '"library":"fontawesomeSolid') ||
        strpos($bricks_settings_string, '"library":"fontawesomeLight') ||
        strpos($theme_style_settings_string, '"library":"fontawesomeLight') ||
        strpos($bricks_settings_string, '"library":"fontawesomeThin') ||
        strpos($theme_style_settings_string, '"library":"fontawesomeThin') ||
        strpos($bricks_settings_string, '"library":"fontawesomeDuotone') ||
        strpos($theme_style_settings_string, '"library":"fontawesomeDuotone') ||
        strpos($bricks_settings_string, '"library":"fontawesomeSharpSolid') ||
        strpos($theme_style_settings_string, '"library":"fontawesomeSharpSolid') ||
        strpos($bricks_settings_string, '"library":"fontawesomeSharpRegular') ||
        strpos($theme_style_settings_string, '"library":"fontawesomeSharpRegular') ||
        strpos($bricks_settings_string, '"library":"fontawesomeSharpLight') ||
        strpos($theme_style_settings_string, '"library":"fontawesomeSharpLight')
    ) {
        wp_enqueue_style(
            'ykf-brx-fontawesome-6-pro',
            $cache_base_url . 'css/fontawesome.min.css',
            ['bricks-frontend'],
            (string) filemtime($cache_base_dir . 'css/fontawesome.min.css')
        );
    }

    // brands
    if (
        bricks_is_builder() ||
        strpos($bricks_settings_string, '"library":"fontawesomeBrands') ||
        strpos($theme_style_settings_string, '"library":"fontawesomeBrands')
    ) {
        wp_enqueue_style(
            'ykf-brx-fontawesome-6-pro-brands',
            $cache_base_url . 'css/brands.min.css',
            ['bricks-frontend'],
            (string) filemtime($cache_base_dir . 'css/brands.min.css')
        );
    }

    // regular
    if (
        bricks_is_builder() ||
        strpos($bricks_settings_string, '"library":"fontawesomeRegular') ||
        strpos($theme_style_settings_string, '"library":"fontawesomeRegular')
    ) {
        wp_enqueue_style(
            'ykf-brx-fontawesome-6-pro-regular',
            $cache_base_url . 'css/regular.min.css',
            ['bricks-frontend'],
            (string) filemtime($cache_base_dir . 'css/regular.min.css')
        );
    }

    // solid
    if (
        bricks_is_builder() ||
        strpos($bricks_settings_string, '"library":"fontawesomeSolid') ||
        strpos($theme_style_settings_string, '"library":"fontawesomeSolid')
    ) {
        wp_enqueue_style(
            'ykf-brx-fontawesome-6-pro-solid',
            $cache_base_url . 'css/solid.min.css',
            ['bricks-frontend'],
            (string) filemtime($cache_base_dir . 'css/solid.min.css')
        );
    }

    // light
    if (
        bricks_is_builder() ||
        strpos($bricks_settings_string, '"library":"fontawesomeLight') ||
        strpos($theme_style_settings_string, '"library":"fontawesomeLight')
    ) {
        wp_enqueue_style(
            'ykf-brx-fontawesome-6-pro-light',
            $cache_base_url . 'css/light.min.css',
            ['bricks-frontend'],
            (string) filemtime($cache_base_dir . 'css/light.min.css')
        );
    }

    // thin
    if (
        bricks_is_builder() ||
        strpos($bricks_settings_string, '"library":"fontawesomeThin') ||
        strpos($theme_style_settings_string, '"library":"fontawesomeThin')
    ) {
        wp_enqueue_style(
            'ykf-brx-fontawesome-6-pro-thin',
            $cache_base_url . 'css/thin.min.css',
            ['bricks-frontend'],
            (string) filemtime($cache_base_dir . 'css/thin.min.css')
        );
    }

    // duotone
    if (
        bricks_is_builder() ||
        strpos($bricks_settings_string, '"library":"fontawesomeDuotone') ||
        strpos($theme_style_settings_string, '"library":"fontawesomeDuotone')
    ) {
        wp_enqueue_style(
            'ykf-brx-fontawesome-6-pro-duotone',
            $cache_base_url . 'css/duotone.min.css',
            ['bricks-frontend'],
            (string) filemtime($cache_base_dir . 'css/duotone.min.css')
        );
    }

    // sharp-solid
    if (
        bricks_is_builder() ||
        strpos($bricks_settings_string, '"library":"fontawesomeSharpSolid') ||
        strpos($theme_style_settings_string, '"library":"fontawesomeSharpSolid')
    ) {
        wp_enqueue_style(
            'ykf-brx-fontawesome-6-pro-sharp-solid',
            $cache_base_url . 'css/sharp-solid.min.css',
            ['bricks-frontend'],
            (string) filemtime($cache_base_dir . 'css/sharp-solid.min.css')
        );
    }

    // sharp-regular
    if (
        bricks_is_builder() ||
        strpos($bricks_settings_string, '"library":"fontawesomeSharpRegular') ||
        strpos($theme_style_settings_string, '"library":"fontawesomeSharpRegular')
    ) {
        wp_enqueue_style(
            'ykf-brx-fontawesome-6-pro-sharp-regular',
            $cache_base_url . 'css/sharp-regular.min.css',
            ['bricks-frontend'],
            (string) filemtime($cache_base_dir . 'css/sharp-regular.min.css')
        );
    }

    // sharp-light
    if (
        bricks_is_builder() ||
        strpos($bricks_settings_string, '"library":"fontawesomeSharpLight') ||
        strpos($theme_style_settings_string, '"library":"fontawesomeSharpLight')
    ) {
        wp_enqueue_style(
            'ykf-brx-fontawesome-6-pro-sharp-light',
            $cache_base_url . 'css/sharp-light.min.css',
            ['bricks-frontend'],
            (string) filemtime($cache_base_dir . 'css/sharp-light.min.css')
        );
    }

    // only enqueue if builder is active
    if (!bricks_is_builder_main()) {
        return;
    }

    // get icon list from cache file 'icons.json'
    $icons = json_decode(file_get_contents($cache_base_dir . 'icons.json'), true);

    wp_enqueue_script(
        'ykf-brx-fontawesome-pro-builder',
        plugins_url('builder.js', __FILE__),
        ['wp-hooks', 'bricks-builder',],
        (string) filemtime(__DIR__ . '/builder.js'),
        true
    );

    wp_localize_script(
        'ykf-brx-fontawesome-pro-builder',
        'ykf_brx_fontawesome_pro',
        [
            'icons' => $icons,
        ]
    );
}
