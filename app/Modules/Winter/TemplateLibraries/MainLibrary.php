<?php
namespace Modules\Winter\TemplateLibraries;

use Phact\Main\Phact;
use Phact\Template\TemplateLibrary;

class MainLibrary extends TemplateLibrary
{
	/**
	 * Insert svg icon
	 *
	 * @name svg
	 * @kind function
	 * @return string
	 */
	public static function svg($params)
	{
		$name = isset($params[0]) ? $params[0] : '';

		$icon = "static/images/svg/{$name}.svg";
		$isrc = "../static/images/svg/{$name}.svg";
		
		if (file_exists($icon)) {
    		return preg_replace('/<\?.*?\?>/', '', file_get_contents($icon));
        }
		if (file_exists($isrc)) {
    		return preg_replace('/<\?.*?\?>/', '', file_get_contents($isrc));
        }
        
        return "<!-- svg not found: [$icon] -->";
	}

	/**
	 * @name settings
	 * @kind function
	 * @return string
	 */
	public static function settings($params)
	{
		if (!isset($params[0])) return null;
		return Phact::app()->settings->get("Winter.{$params[0]}");
	}

	/**
	 * @name get_settings
	 * @kind accessorFunction
	 * @return string
	 */
	public static function getSettings($name)
	{
		return self::settings([$name]);
	}
}
