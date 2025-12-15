<?php
/**
 * Plugin Name:                     Heartbeat Controller 
 * Plugin URI:                      https://github.com/devabdurrahman/heartbeat-controller
 * Description:                     Control WordPress Heartbeat API behavior for Dashboard, Post Editor, and Frontend.
 * Version:                         1.0
 * Requires at Least:               5.2
 * Requires PHP:                    7.2
 * Author:                          Abdur Rahman
 * Author URI:                      https://devabdurrahman.com/
 * License:                         GPL2
 * License URI:                     https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:                     heartbeat-controller
 * Domain Path:                     /languages
 */

// Prevent direct access to the file
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// Add a "Settings" link under the plugin name on the Plugins page
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'hccwh_settings_link');
function hccwh_settings_link($links) {
    $settings_link = '<a href="' . admin_url('options-general.php?page=heartbeat-control') . '">' . esc_html__('Settings', 'heartbeat-controller') . '</a>';
    array_unshift($links, $settings_link);
    return $links;
}

class HCCWH_Heartbeat_Controller {

    public function __construct() {
        add_action('admin_menu', [$this, 'hccwh_add_settings_page']);
        add_action('admin_init', [$this, 'hccwh_register_settings']);
        add_action('admin_enqueue_scripts', [$this, 'hccwh_enqueue_admin_styles']);
        add_filter('heartbeat_settings', [$this, 'hccwh_modify_heartbeat_frequency']);
        add_filter('heartbeat_send', [$this, 'hccwh_maybe_disable_heartbeat']);
    }

    public function hccwh_enqueue_admin_styles($hook){
        if ($hook !== 'settings_page_heartbeat-control') {
            return;
        }

        wp_enqueue_style(
            'hccwh-admin-style',
            plugin_dir_url(__FILE__) . 'assets/css/admin.css',
            array(),
            '1.0.0'
        );
    }

    public function hccwh_add_settings_page() {
        add_options_page(
            __('Heartbeat Control', 'heartbeat-controller'),
            __('Heartbeat Control', 'heartbeat-controller'),
            'manage_options',
            'heartbeat-control',
            [$this, 'hccwh_render_settings_page']
        );
    }

    public function hccwh_render_settings_page() {
        ?>
        <div class="wrap">
            <form method="post" action="options.php">
                <?php
                settings_fields('heartbeat_control_group');
                do_settings_sections('heartbeat-control');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    public function hccwh_register_settings() {
        register_setting('heartbeat_control_group', 'heartbeat_control_settings', [$this, 'hccwh_sanitize_settings']);

        add_settings_section(
            'heartbeat_section',
            __('Heartbeat Control Options', 'heartbeat-controller'),
            null,
            'heartbeat-control'
        );

        $contexts = [
            'dashboard'    => __('Dashboard', 'heartbeat-controller'),
            'post_editor'  => __('Post Editor', 'heartbeat-controller'),
            'frontend'     => __('Frontend', 'heartbeat-controller'),
        ];

        foreach ($contexts as $context => $label) {
            add_settings_field(
                "heartbeat_{$context}",
                "$label Heartbeat",
                [$this, 'hccwh_render_heartbeat_option'],
                'heartbeat-control',
                'heartbeat_section',
                ['context' => $context, 'label' => $label]
            );
        }
    }

    public function hccwh_sanitize_settings($input) {
        $contexts = ['dashboard', 'post_editor', 'frontend'];
        $sanitized = [];

        foreach ($contexts as $context) {
            $mode = isset($input[$context]['mode']) ? sanitize_text_field($input[$context]['mode']) : 'allow';

            // Only accept expected values
            if (!in_array($mode, ['allow', 'disallow', 'modify'], true)) {
                $mode = 'allow';
            }

            $frequency = isset($input[$context]['frequency']) ? intval($input[$context]['frequency']) : 15;
            $frequency = max(15, min(300, $frequency)); // enforce valid range

            $sanitized[$context] = [
                'mode' => $mode,
                'frequency' => $frequency
            ];
        }

        return $sanitized;
    }

    public function hccwh_render_heartbeat_option($args) {
        $options = get_option('heartbeat_control_settings');
        $context = $args['context'];
        $current = isset($options[$context]['mode']) ? $options[$context]['mode'] : 'allow';
        $frequency = isset($options[$context]['frequency']) ? intval($options[$context]['frequency']) : 15;
        ?>
        <div class="hccwh-heartbeat-group">

            <label>
                <input type="radio" name="heartbeat_control_settings[<?php echo esc_attr($context); ?>][mode]" value="allow" <?php checked($current, 'allow'); ?>>
                <?php echo esc_html__('Allow', 'heartbeat-controller'); ?>
            </label>

            <label>
                <input type="radio" name="heartbeat_control_settings[<?php echo esc_attr($context); ?>][mode]" value="disallow" <?php checked($current, 'disallow'); ?>>
                <?php echo esc_html__('Disallow', 'heartbeat-controller'); ?>
            </label>

            <label>
                <input type="radio" name="heartbeat_control_settings[<?php echo esc_attr($context); ?>][mode]" value="modify" <?php checked($current, 'modify'); ?>>
                <?php echo esc_html__('Modify Frequency', 'heartbeat-controller'); ?>
            </label>

            &nbsp;
            <input type="number" name="heartbeat_control_settings[<?php echo esc_attr($context); ?>][frequency]" value="<?php echo esc_attr($frequency); ?>" min="15" max="300">
            <?php echo esc_html__('seconds', 'heartbeat-controller'); ?>

        </div>
        <?php
    }

    public function hccwh_maybe_disable_heartbeat($response) {
        if (is_admin()) {
            global $pagenow;

            if ($pagenow === 'index.php') {
                $mode = $this->hccwh_get_mode('dashboard');
            } elseif ($pagenow === 'post.php' || $pagenow === 'post-new.php') {
                $mode = $this->hccwh_get_mode('post_editor');
            } else {
                $mode = 'allow';
            }
        } else {
            $mode = $this->hccwh_get_mode('frontend');
        }

        if ($mode === 'disallow') {
            return false;
        }

        return $response;
    }

    public function hccwh_modify_heartbeat_frequency($settings) {
        if (is_admin()) {
            global $pagenow;

            if ($pagenow === 'index.php') {
                $mode = $this->hccwh_get_mode('dashboard');
                $freq = $this->hccwh_get_frequency('dashboard');
            } elseif ($pagenow === 'post.php' || $pagenow === 'post-new.php') {
                $mode = $this->hccwh_get_mode('post_editor');
                $freq = $this->hccwh_get_frequency('post_editor');
            } else {
                $mode = 'allow';
            }
        } else {
            $mode = $this->hccwh_get_mode('frontend');
            $freq = $this->hccwh_get_frequency('frontend');
        }

        if ($mode === 'modify') {
            $settings['interval'] = max(15, intval($freq));
        }

        return $settings;
    }

    private function hccwh_get_mode($context) {
        $options = get_option('heartbeat_control_settings');
        return isset($options[$context]['mode']) ? $options[$context]['mode'] : 'allow';
    }

    private function hccwh_get_frequency($context) {
        $options = get_option('heartbeat_control_settings');
        return isset($options[$context]['frequency']) ? intval($options[$context]['frequency']) : 15;
    }
}

new HCCWH_Heartbeat_Controller();