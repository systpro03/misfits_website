<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Returns a public URL to an uploaded image, or a placeholder
 * if the record has no image on file yet.
 */
if ( ! function_exists('upload_url'))
{
	function upload_url($folder, $filename, $placeholder = 'default.svg')
	{
		$ci =& get_instance();
		if (empty($filename))
		{
			$filename = $placeholder;
			$folder = 'placeholders';
		}
		return base_url('assets/uploads/' . $folder . '/' . $filename);
	}
}

/**
 * Friendly date format used across the public site, e.g. "Sat, Nov 14 2026"
 */
if ( ! function_exists('friendly_date'))
{
	function friendly_date($date)
	{
		if (empty($date) || $date === '0000-00-00')
		{
			return '';
		}
		return date('D, M j Y', strtotime($date));
	}
}

/**
 * Sets a one-time flash message that flash_message() will render.
 */
if ( ! function_exists('set_flash'))
{
	function set_flash($type, $message)
	{
		$ci =& get_instance();
		$ci->session->set_flashdata('flash_type', $type);
		$ci->session->set_flashdata('flash_message', $message);
	}
}

/**
 * Renders (and consumes) the flash message banner, if one is queued.
 */
if ( ! function_exists('flash_message'))
{
	function flash_message()
	{
		$ci =& get_instance();
		$type = $ci->session->flashdata('flash_type');
		$msg  = $ci->session->flashdata('flash_message');

		if (empty($msg))
		{
			return '';
		}

		$styles = array(
			'success' => 'bg-ember-50 border-ember-500 text-ember-800',
			'error'   => 'bg-red-50 border-red-500 text-red-800',
			'info'    => 'bg-slate-100 border-slate-400 text-slate-800',
		);
		$style = isset($styles[$type]) ? $styles[$type] : $styles['info'];

		return '<div class="border-l-4 ' . $style . ' px-4 py-3 rounded mb-6 text-sm font-medium" role="alert">' . htmlspecialchars($msg) . '</div>';
	}
}

/**
 * Turns "upcoming"/"past" ride status into a small colored badge.
 */
if ( ! function_exists('ride_badge'))
{
	function ride_badge($type)
	{
		if ($type === 'upcoming')
		{
			return '<span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-ember-100 text-ember-700 border border-ember-300">Upcoming</span>';
		}
		return '<span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-200 text-slate-600 border border-slate-300">Completed</span>';
	}
}
