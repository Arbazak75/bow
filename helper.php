<?php


use Bow\Database\Database as DB;
use Bow\Support\Util;
use Bow\Support\Logger;
use Bow\Support\Resource;
use Bow\Support\Security;


if (file_exists("vendor/Bow/framework/src/ApplicationAutoload.php")):

require "vendor/Bow/framework/src/ApplicationAutoload.php";
\Bow\ApplicationAutoload::register();

define("SELECT", DB::SELECT);
define("INSERT", DB::INSERT);
define("UPDATE", DB::UPDATE);
define("DELETE", DB::DELETE);

$appconfig = require "app/app.php";

global $response;
global $request;

$response = \Bow\Http\Response::load($appconfig["app"]);
$request = \Bow\Http\Request::load($appconfig["app"]);

DB::configure($appconfig["config"]->database);
Resource::configure($appconfig["config"]->resource);


if (!function_exists("db")) {
	function db() {
		return DB::class;
	}
}

if (!function_exists("view")) {
	function view($template, $data = [], $code = 200) {
		global $response;
		$response->view($template, $data, $code);
	}
}

if (!function_exists("table")) {
	function table($tableName) {
		return DB::table($tableName);
	}
}

if (!function_exists("query_maker")) {
	function query_maker($sql, $data, $method) {

		$db = db();

		if (method_exists($db, $method)) {
			return $db::$method($sql, $data);
		}

		return null;
	}
}

if (!function_exists("last_insert_id")) {
	function last_insert_id() {

		$db = db();

		return $db::lastInsertId();
	}
}

if (!function_exists("query_response")) {
	function query_response($method, $param) {

		global $response;
		$param = array_slice(func_get_args(), 1);

		if (method_exists($response, $method)) {
			return call_user_func_array([$response, $method], $param);
		}

		return null;
	}
}

if (!function_exists("show_last_db_error")) {
	function show_last_db_error() {
		return DB::getLastErreur();
	}
}

if (!function_exists("select")) {
	function select($sql, array $data = []) {
		return query_maker($sql, $data, "select");
	}
}

if (!function_exists("insert")) {
	function insert($sql, array $data = []) {
		return query_maker($sql, $data, "insert");
	}
}

if (!function_exists("delete")) {
	function delete($sql, array $data = []) {
		return query_maker($sql, $data, "delete");
	}
}

if (!function_exists("update")) {
	function update($sql, array $data = []) {
		return query_maker($sql, $data, "update");
	}
}

if (!function_exists("statement")) {
	function statement($sql, array $data = []) {
		return query_maker($sql, $data, "statement");
	}
}

if (!function_exists("kill")) {
	function kill($message = null, $log = false, $code = 200) {

		if ($log === true) {
			log($message, $log=0);
		}
		statuscode($code);
		die($message);
	}
}

if (!function_exists("body")) {
	function body() {
        global $request;
        return $request->body();
	}
}

if (!function_exists("files")) {
	function files() {
        global $request;
        return $request->files();
	}
}

if (!function_exists("query")) {
	function query() {
        global $request;
        return $request->query();
	}
}

if (!function_exists("debug")) {
	function debug() {
		Util::debug(func_get_args());
	}
}

if (!function_exists("c_csrf")) {
	function c_csrf() {
		return Security::generateTokenCsrf();
	}
}

if (!function_exists("store")) {
	function store(array $file, $filename = null, $dirname = null) {
		if (!is_null($filename) && is_string($filename)) {
			Resource::setUploadFileName($filename);
		}
		if (!is_null($dirname)) {
			Resource::setUploadDir($dirname);
		}
		Resource::store($file);
	}
}

if (!function_exists("json")) {
	function json($data, $code = 200) {
		query_response("json", $data, $code);
	}
}

if (!function_exists("statuscode")) {
	function statuscode($code) {
		query_response("setCode", (int) $code);
	}
}

if (!function_exists("sanitaze")) {
	function sanitaze($data) {
		if (is_int($data) || is_string($data)) {
			return $data;
		} else {
			return Security::sanitaze($data);
		}
	}
}

if (!function_exists("secure")) {
	function secure($data) {
		if (is_int($data) || is_string($data)) {
			return $data;
		} else {
			return Security::sanitaze($data, true);
		}
	}
}

if (!function_exists("response")) {
	function response($template = null, $code = 200, $type = "text/html") {
		
		global $response;
		
		if (is_null($template)) {
			return $response;
		}
		
		setHeader("Content-Type", $type);
		statuscode($code);
		query_response("send", $template);

		return $response;
	}
}

if (!function_exists("setheader")) {
	function setheader($key, $value) {
		query_response("setHeader", $key, $value);
	}
}

if (!function_exists("send")) {
	function send($data) {
		query_response("send", $data);
	}
}

if (!function_exists("my_query")) {
	function my_query(array $option) {
		return DB::query($option);
	}
}

if (!function_exists("switch_to")) {
	function switch_to($name, $cb = null) {
		DB::switchTo($name, $cb);
	}
}

if (!function_exists("curljson")) {
	function curljson($url, $code = 200) {
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$data = curl_exec($ch);
		curl_close($ch);
		$data = json_decode($data);
		json($data, $code);
	}
}

endif;
