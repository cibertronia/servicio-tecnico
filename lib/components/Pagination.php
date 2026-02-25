<?php

namespace Bootstrap\Components;
use \Bootstrap\Helper;
use \Common\Util;

class Pagination extends Component {
    private $_options_map = [
        'show_pages' => 5,
        'param' => 'page',
        'prev_text' => 'Previous',
        'next_text' => 'Next',
        'size' => 'sm',
        'link_attr' => ''
    ];

    public function __construct($per_page = 20, $items = 0, $options = []) {
        parent::__construct([
            'id' => Util::token(),
            'options' => Helper::set_values($this->_options_map, $options),
            'page' => $_GET['page'] ?? 1,
            'per_page' => $per_page,
            'items' => $items,
            'url' => '',
            'class' => ''
        ]);
    }

    public function offset() {
        // Assuming 20 items per page:
        // page 1 has an offset of 0    (1-1) * 20
        // page 2 has an offset of 20   (2-1) * 20
        // in other words, page 2 starts with item 21
        return ($this->_properties->page - 1) * $this->_properties->per_page;
    }

    public function getPages() {
        return $this->_properties->per_page == 0 ? 0 : ceil($this->_properties->items / $this->_properties->per_page);
    }

    public function getPreviousPage() {
        return max(0, $this->_properties->page - 1);
    }

    public function getNextPage() {
        return min($this->getPages(), $this->_properties->page + 1);
    }

    public function hasPreviousPage() {
        return $this->getPreviousPage() >= 1 ? true : false;
    }

    public function hasNextPage() {
        return $this->getNextPage() <= $this->getPages() ? true : false;
    }

    public function printHtml($return = false) {
        $options = $this->_properties->options;

        parse_str($_SERVER['QUERY_STRING'], $get_array);
        unset($get_array[$options['param']]);
        unset($get_array['_pjax']);
        $query_string = http_build_query($get_array);

        $url = $this->_properties->url.($query_string ? '?'.$query_string : '');
        $url .= strpos($url, '?') === false ? '?' : '&';

        $param = $options['param'];
        $show_pages = $options['show_pages'];
        $total_pages = $this->getPages();

        $current_page = $this->_properties->page;
        $start = $current_page - 2;
        $end = $current_page + 2;
        $htm_pages = [];
        $size = $options['size'];
        $link_attr = $options['link_attr'];

        $prev_html = $current_page == 1 ? '<span title="Previous" class="page-link">'.$options['prev_text'].'</span>' : '<a '.$link_attr.' title="Previous" class="page-link" href="'.escape($url.'page='.$this->getPreviousPage()).'">'.$options['prev_text'].'</a>';
        $next_html = $current_page == $total_pages ? '<span title="Next" class="page-link">'.$options['next_text'].'</span>' : '<a '.$link_attr.' title="Next" class="page-link" href="'.escape($url.'page='.$this->getNextPage()).'">'.$options['next_text'].'</a>';

        if ($total_pages < $show_pages) {
            for ($page = 1; $page <= $total_pages; $page++) {
                $page_html = $current_page == $page ? '<span title="Page '.$page.'" class="page-link">'.$page.'</span>' : '<a '.$link_attr.' title="Page '.$page.'" href="'.escape($url.'page='.$page).'" class="page-link">'.$page.'</a>';
                $htm_pages[] = '<li class="'.($current_page == $page ? 'active' : '').' page-item">'.$page_html.'</li>';
            }

            $html = '
                <ul class="pagination pagination-'.$size.' '.$this->_properties->class.'">
                    <li class="page-item '.($current_page == 1 ? 'disabled' : '').'">'.$prev_html.'</li>
                    '.implode(PHP_EOL, $htm_pages).'
                    <li class="page-item '.($current_page == $total_pages ? 'disabled' : '').'">'.$next_html.'</li>
                </ul>
            ';
        } else {
            if ($current_page < $show_pages) {
                $start = 0;
                $end = $show_pages;
            } else if ($current_page > $total_pages - $show_pages) {
                $start = $total_pages - ($show_pages - 1);
                if ($start == $current_page) $start = $start - 2;
                $end = $total_pages;
            }

            $range = range($start, $end);
            for ($page = 1; $page <= $total_pages; $page++) {
                if ($page > 2 && in_array($page, $range) && $page < $total_pages - 1) {
                    $htm_pages[] = '<li class="'.($current_page == $page ? 'active' : '').' page-item"><a '.$link_attr.' title="Page '.$page.'" class="page-link" href="'.escape($url.$param.'='.$page).'">'.$page.'</a></li>';
                }
            }

            $prev_gap = !in_array(3, $range) ? '<li class="disabled page-item"><a href="#" class="page-link">&hellip;</a></li>' : '';
            $next_gap = !in_array($total_pages - 2, $range) ? '<li class="disabled page-item"><a href="#" class="page-link">&hellip;</a></li>' : '';

            $html = '
                <ul class="pagination pagination-'.$size.' '.$this->_properties->class.'">
                    <li class="'.($this->hasPreviousPage() ? '' : 'disabled').' page-item">'.$prev_html.'</li>
                    <li class="'.($current_page == 1 ? 'active' : '').' page-item"><a '.$link_attr.' title="Page 1" class="page-link" href="'.$url.$param.'=1">1</a></li>
                    <li class="'.($current_page == 2 ? 'active' : '').' page-item"><a '.$link_attr.' title="Page 2" class="page-link" href="'.$url.$param.'=2">2</a></li>
                    '.$prev_gap.'
                    '.implode(PHP_EOL, $htm_pages).'
                    '.$next_gap.'
                    <li class="'.($current_page == $total_pages - 1 ? 'active' : '').' page-item"><a '.$link_attr.' title="Page '.($total_pages - 1).'" class="page-link" href="'.escape($url.$param.'='.($total_pages - 1)).'">'.($total_pages - 1).'</a></li>
                    <li class="'.($current_page == $total_pages ? 'active' : '').' page-item"><a '.$link_attr.' title="Page '.$total_pages.'" class="page-link" href="'.escape($url.$param.'='.$total_pages).'">'.$total_pages.'</a></li>
                    <li class="'.($this->hasNextPage() ? '' : 'disabled').' page-item">'.$next_html.'</li>
                </ul>';
        }

        if ($return) return $html;
        else echo $html;
    }
}