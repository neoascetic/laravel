<?php namespace Laravel\Database\Query;

class Union {
	public $alias;

	public $items = array();

	/**
	 * Create a new query Union instance
	 * @param  string  $alias
	 * @param  Query   $query
	 * @return void
	 */
	public function __construct($alias, $query)
	{
		$this->alias = $alias;
		$this->add($query, null);
	}

	/**
	 * Add query to container for UNION operation
	 * @param  Query   $query
	 * @param  string  $type
	 * @return void
	 */
	public function add($query, $type = '')
	{
		$this->items[] = array(
			'query' => $query,
			'type'  => $type
		);
	}

	/**
	 * Add query to container for UNION ALL operation
	 * @param  Query   $query
	 * @return void
	 */
	public function add_all($query)
	{
		$this->add($query, 'ALL');
	}

	/**
	 * Get array of bindings merged from all queries inside the container
	 * @return array
	 */
	public function get_bindings()
	{
		$result = array();
		foreach ($this->items as $item)
		{
			$q = $item['query'];
			$result = array_merge($result, $q->bindings);
		}
		return $result;
	}
}
