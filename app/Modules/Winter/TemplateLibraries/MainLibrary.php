<?php
namespace Modules\Winter\TemplateLibraries;

use Modules\Winter\Models\Attachment;
use Modules\Winter\Models\Media;
use Modules\Winter\Models\Post;
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
     * @name img
     * @kind function
     * @return string
     */
    public static function img($params)
    {
        if (!isset($params[0])) return null;
        $media = Media::objects()->filter(['code' => $params[0]])->get();
        if (!$media) return null;

        $size = getimagesize($media->image->getPath());
        return "<img src='{$media->image->url}' data-w='{$size[0]}' data-h='{$size[1]}' data-code='{$media->code}' />";
    }

    /**
     * @name file
     * @kind accessorFunction
     * @return object|boolean
     */
    public static function file($code)
    {
        return Attachment::objects()->filter(['code' => $code])->get();
    }

    /**
     * @name date
     * @kind modifier
     * @return string
     */
    public static function date($str)
    {
        return date('M j, Y', strtotime($str));
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

    /**
     * @name get_drafts_count
     * @kind accessorFunction
     * @return number
     */
    public static function getDraftsCount()
    {
        return Post::objects()->filter([
            'is_draft' => true
        ])->count();
    }

}
