<?php
wp_enqueue_script( 'wd-generator', WOODMART_ASSETS . '/js/css-generator.js', array(), WOODMART_VERSION, true );

XTS\Registry::getInstance()->wpbcssgenerator->form();
