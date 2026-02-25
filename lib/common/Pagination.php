<?php

namespace Common;

class Pagination {

    private $_current_page;
    private $_per_page;
    private $_items;

    public function __construct($items = 0, $page = 1, $per_page = 20) {
        $this->_current_page = (int)$page;
        $this->_per_page = (int)$per_page;
        $this->_items = $items;
    }

    public function offset() {
        return ($this->_current_page - 1) * $this->_per_page;
    }

    public function totalPages() {
        return $this->_per_page == 0 ? 0 : ceil($this->_items / $this->_per_page);
    }

    public function getPreviousPage() {
        return $this->_current_page - 1;
    }

    public function getLastPage() {
        return $this->totalPages();
    }

    public function getNextPage() {
        return $this->_current_page + 1;
    }

    public function hasPreviousPage() {
        return $this->getPreviousPage() >= 1 ? true : false;
    }

    public function hasNextPage() {
        return $this->getNextPage() <= $this->totalPages() ? true : false;
    }

    public function getLinkHeader($url) {
        parse_str($_SERVER['QUERY_STRING'], $get_array);
        unset($get_array['page']);
        unset($get_array['per_page']);
        $query_string = http_build_query($get_array);

        $url = $url.($query_string ? '?'.$query_string : '');
        $url .= strpos($url, '?') === false ? '?' : '&';

        $rels = ['next', 'last', 'first', 'prev'];
        $urls = [];

        $links = [];
        foreach ($rels as $rel) {
            $page = null;

            switch ($rel) {
                case 'next':
                    $page = $this->hasNextPage() ? $this->getNextPage() : null;
                    break;
                case 'last':
                    $page = $this->getLastPage();
                    break;
                case 'first':
                    $page = 1;
                    break;
                case 'prev':
                    $page = $this->hasPreviousPage() ? $this->getPreviousPage() : null;
                    break;
            }

            if ($page) {
                $urls[] = '<'.$url.'page='.$page.'&per_page='.$this->_per_page.'>; rel="'.$rel.'"';
            }
        }

        return implode(', ', $urls);
    }
}

?>