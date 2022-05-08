<?php

const SECRET = '#F&55reeTh#4T2$2';
const DEVEL = true;
const SITE_NAME = 'Ejemplo';
const UPLOAD_DIR = './public/files';
const TMP_DIR = __DIR__ . '/tmp';

if(DEVEL) {
	ini_set('upload_tmp_dir', __DIR__ .'/tmp/files');
	ini_set('session.auto_start', false);
	ini_set('session.use_strict_mode', true);
	ini_set('session.save_path', __DIR__ .'/tmp/sessions');
	ini_set('session.name', '_SSID');
	ini_set('session.cookie_lifetime', 0);
	ini_set('session.use_only_cookies', true);
	ini_set('session.cookie_httponly', true);
	ini_set('session.cookie_samesite', 'Lax');
	ini_set('session.lazy_write', true);
}
