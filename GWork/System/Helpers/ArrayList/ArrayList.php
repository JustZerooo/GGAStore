<?php
	/**
	 * @author gwork
	 */

	namespace GWork\System\Helpers\ArrayList {
		use \Iterator;

	    class ArrayList implements Iterator {
			private $position = 0,
					$items = [];

			/**
			 * ArrayList constructor.
			 * @param array $items
			 */
			public function __construct(array $items) {
				$this->items = $items;
			}

			/**
			 * Returns all items.
			 * @return array
			 */
			public function getAll(): array {
	            return $this->items;
	        }

			/**
			 * Sorts the array.
			 * @param callable|null $callback
			 */
			public function sort(callable $callback = null) {
				if($callback == null) {
					$this->list = sort($this->list);
				} else {
					$this->list = $callback($this->list);
				}
			}

			/**
			 * Returns the current item.
			 * @return mixed
			 */
			public function current() {
				return $this->list[$this->position];
			}

			/**
			 * Select the next item.
			 */
			public function next() {
	            $this->position++;
	        }

			/**
			 * Select the previous item.
			 */
			public function previous() {
	            $this->position--;
	        }

			/**
			 * Returns the position of the current item.
			 * @return int
			 */
			public function key(): int {
	            return $this->position;
	        }

			/**
			 * Checks if the current position is valid.
			 * @return bool
			 */
			public function valid(): bool {
	            return isset($this->list[$this->position]);
	        }

			/**
			 * Rewind the Iterator to the first element
			 */
			public function rewind() {
	            $this->position = 0;
	        }
	    }
	}
