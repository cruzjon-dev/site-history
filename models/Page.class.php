<?php

namespace TestProject;

class Page
{
	public $title;
	public $content;

	function __construct(string $title, string $content)
	{
		$this->title = $title;
		$this->content = $content;
	}
}
