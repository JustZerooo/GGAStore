<?php
	/**
	 * @author gwork
	 */

	namespace GWork\System\Helpers\Pagers {
	    class Pager {
			private $page = 1,
					$pages = 0,
					$items = [],
					$itemsPerPage = 0;

			/**
			 * Pager constructor.
			 * @param array $items
			 * @param int   $itemsPerPage
			 */
			public function __construct(array $items, int $itemsPerPage) {
				$this->items = $items;
				$this->itemsPerPage = $itemsPerPage;

				$this->pages = ceil(count($this->items) / $this->itemsPerPage);
			}

			/**
			 * Returns the current page.
			 * @return int
			 */
			public function getPage(): int {
				return $this->page;
			}

			/**
			 * Returns the count of pages.
			 * @return int
			 */
			public function getPages(): int {
				return $this->pages;
			}

			/**
			 * Changes the current page.
			 * @param int $page
			 */
			public function setPage(int $page) {
				if($page > $this->getPages()) {
					$this->setPage(1);
				}

				$this->page = $page;
			}

			/**
			 * Returns all the items of the current page.
			 * @return array
			 */
			public function getContent(): array {
	            return array_slice($this->items, ($this->page - 1) * $this->itemsPerPage, $this->itemsPerPage);
	        }
	    }
	}
