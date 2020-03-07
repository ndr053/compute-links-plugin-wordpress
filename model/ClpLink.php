<?php

class Clp_Link
{
	private $_post;
	private $_wpdb;
	private $_tableName;

	public function __construct()
	{
		global $post;
		global $wpdb;
		$this->_post = $post;
		$this->_wpdb = $wpdb;
		$this->_tableName = 'clp_compute_links';
	}

	public function getUrlById($id)
	{
		return $this->getWpdb()->get_row( sprintf("SELECT * FROM %s WHERE id = %d", $this->getTableName(), $id));
	}

	public function getUrlByPostIdAndUrl($url)
	{
		return $this->getWpdb()->get_row( sprintf("SELECT * FROM %s WHERE md5_url = '%s' AND post_id = %d", $this->getTableName(), md5($url), $this->getPost()->ID));
	}

	public function saveUrl($url)
	{
		$url = esc_url($url);
		$urlSize = $this->_clpGetRemoteFileSize($url);
		return $this->getWpdb()->insert( $this->getTableName(), array(
			'url' => $url,
			'md5_url' => md5($url),
			'size' => $urlSize,
			'user_id' => $this->getPost()->post_author,
			'post_id' => $this->getPost()->ID,
		) );
	}

	public function getPost()
	{
		return $this->_post;
	}

	public function getWpdb()
	{
		return $this->_wpdb;
	}

	public function getTableName()
	{
		return $this->getWpdb()->prefix . $this->_tableName;
	}

	private function _clpGetRemoteFileSize($url)
	{
		$head = array_change_key_case(get_headers($url, 1));
		return $head['content-length'];
	}

}


