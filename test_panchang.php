<?php
define('WP_USE_THEMES', false);
require('wp-load.php');
\ = new WP_REST_Request('GET', '/pm/v1/tools/panchang');
\ = rest_do_request(\);
echo json_encode(\->get_data(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
