<?php

namespace TestProject;

class Node
{
	public $path;
	public $title;
	public $next;
	public $prev;

	function __construct(string $path = NULL, string $title = NULL, string $next = NULL, string $prev = NULL)
	{
		$this->title = $title;
		$this->path = $path;
		$this->next = $next;
		$this->prev = $prev;
	}
}

class History
{
	private $firstPage;
	private $currentPage;
	private $lastPage;
	private $length;
	private $action;

	public function __construct()
	{
		// unset($_SESSION['history']);

		$this->firstPage = $_SESSION['history']['firstPage'] ?? NULL;
		$this->currentPage = $_SESSION['history']['currentPage'] ?? NULL;
		$this->lastPage = $_SESSION['history']['lastPage'] ?? NULL;
		$this->length = $_SESSION['history']['length'] ?? 0;
		$this->action = $_SESSION['history']['action'] ?? NULL;

		if (!isset($_SESSION['history'])) {
			$_SESSION['history'] = [];
			$this->updateSessionAll();
		}
	}

	public function __destruct()
	{
		// echo '<pre>';
		// var_dump($_SESSION['history']);
		// echo '</pre>';
	}

	/******************************************************************
	 * Update a specific property in the session
	 ******************************************************************/
	private function updateSession(string $prop, mixed $value)
	{
		$_SESSION['history'][$prop] = $value;
	}

	/******************************************************************
	 * Update all properties in the session
	 ******************************************************************/
	private function updateSessionAll()
	{
		$properties = get_object_vars($this);
		foreach ($properties as $key => $value) {
			$this->updateSession($key, $value);
		}
	}

	/******************************************************************
	 * List all of the nodes in an array
	 ******************************************************************/
	public function list()
	{
		$list = [];

		$Node = $this->firstPage;
		for ($i = 0; $i < $this->length; $i++) {
			$list[] = $Node;
			$Node = $Node->next;
		}

		return $list;
	}

	/******************************************************************
	 * Append new node to history, but only if the new node is not the current page and the user did not perform a history action
	 ******************************************************************/
	public function add(string $path, string $title)
	{
		if (
			$path !== $this->currentPage->path
			&& !$this->action
		) {
			$Node = new Node($path, $title);

			if ($this->lastPage) {
				$Node->prev = $this->lastPage;
				$this->lastPage->next = $Node;
			} else {
				$this->firstPage = $Node;
			}

			$this->currentPage = $Node;
			$this->lastPage = $Node;
			$this->length++;
		}

		$this->action = NULL;
		$this->updateSessionAll();
	}

	/******************************************************************
	 * Get a specific node in the history
	 ******************************************************************/
	public function get(int $index)
	{
		if (
			$this->length === 0
			|| $index >= $this->length
		) {
			return;
		}

		$Node = NULL;

		if ($index < $this->length) { // Start search from the first node
			$Node = $this->firstPage;
			$thisIndex = 0;

			while ($thisIndex < $index) {
				$Node = $Node->next;
				$thisIndex++;
			}
		} else { // Start search from the last node
			$Node = $this->lastPage;
			$thisIndex = $this->length - 1;

			while ($thisIndex > $index) {
				$Node = $Node->prev;
				$thisIndex--;
			}
		}

		return $Node;
	}

	/******************************************************************
	 * Go to the previous node of the current node
	 ******************************************************************/
	public function back()
	{
		// var_dump($this->currentPage->prev);
		// exit();

		if ($this->currentPage && $this->currentPage->prev) {
			$this->currentPage = $this->currentPage->prev;
			$this->action = 'back';
			$this->updateSession('currentPage', $this->currentPage);
			$this->updateSession('action', $this->action);

			header('Location: ' . $this->currentPage->path);
			exit();
		}
	}

	/******************************************************************
	 * Go to the next node of the current node
	 ******************************************************************/
	public function forward()
	{
		if ($this->currentPage && $this->currentPage->next) {
			$this->currentPage = $this->currentPage->next;
			$this->action = 'forward';
			$this->updateSession('currentPage', $this->currentPage);
			$this->updateSession('action', $this->action);

			header('Location: ' . $this->currentPage->path);
			exit();
		}
	}

	/******************************************************************
	 * Go to a specific node
	 ******************************************************************/
	public function goTo(int $index)
	{
		$Node = $this->get($index);

		if ($Node) {
			$this->currentPage = $Node;
			$this->action = 'goTo';
			$this->updateSession('currentPage', $this->currentPage);
			$this->updateSession('action', $this->action);

			header('Location: ' . $this->currentPage->path);
			exit();
		}
	}
}
