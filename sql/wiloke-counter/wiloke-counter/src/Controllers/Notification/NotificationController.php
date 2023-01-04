<?php

namespace WilokeCounter\Controllers\Notification;


class NotificationController
{
	private $topBarId = "wil-plugins-notification";

	public function __construct()
	{
		add_action("admin_enqueue_scripts", [$this, "adminEnqueueScripts"]);
		add_action("wp_ajax_wil_update_total_items", [$this, "updateTotalItems"]);
	}

	public function updateTotalItems()
	{
		if (!current_user_can("administrator")) {
			wp_send_json_error();
		}

		$total = absint($_REQUEST["total"]);
		update_option("wil_plugins_total", $total, false);
		wp_send_json_success();
	}

	public function adminEnqueueScripts()
	{
	    if (!defined("WILOKE_NOTIFICATION_ADDED_SCRIPT")) {
	      define("WILOKE_NOTIFICATION_ADDED_SCRIPT", true);

			wp_register_script(
				$this->topBarId . "-global",
				plugin_dir_url(__FILE__) . "Source/Js/global.js",
				["jquery"],
				WILOKE_WILOKECOUNTER_VERSION,
				true
			);

			$total = get_option("wil_plugins_total");
			wp_localize_script(
				$this->topBarId . "-global",
				"WIL_PLUGINS_INFO",
				[
					"total" => empty($total) ? 0 : absint($total)
				]
			);
			wp_enqueue_script($this->topBarId . "-global");
		}
	}
}