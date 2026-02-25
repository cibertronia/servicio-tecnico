<?php
namespace Bootstrap\Components;
use \Bootstrap\Helper;
use \Common\Util;
class Nav extends Component {
	public function __construct($nav_items = [], $active = '') {
		parent::__construct([
			'items' => $nav_items,
			'id' 		=> Util::token(),
			'active'=> $active
		]);
	}
	public function printHtml($return = false) {
		$that 		= $this;
		$properties = $this->_properties;

		$nav_items= Helper::getValue($properties->items, [
			'if_closure' => function($nav_items) use ($that) {
				return Helper::runCallback($nav_items, [$that]);
			},
			'if_other' => function($nav_items) {
				parent::err('Nav:items requires array');
				return null;
			}
		]);
		if (!is_array($nav_items)) {
			parent::err("Nav:items requires array");
			return null;
		}
		$list_items = $this->parseNav($nav_items);
		$result = parent::printList($list_items, ['class' => 'nav-menu', 'attr' => ['id' => 'js-nav-menu']], true);

		if ($return) return $result;
		else echo $result;
	}

	private function parseNav($items, &$parent_props = null) {
		if (!$items) return [];
		$properties = $this->_properties;

		$nav_items_list = [];
		foreach ($items as $name => $item) {
			$item_props = [
				'url' => '#',
				'url_target' => '',
				'icon' => '',
				'badge' =>  '',
				'title' => $name,
				'span' => null,
				'tags' => '',
				'label' => '',
				'active' => $name === $properties->active,
				'items' => [],
				'attr' => [],
				'class' => [],
				'li_class' => [],
				'group' => false
			];

			$item_props = Util::setValues($item_props, $item, 'title');

			if ($item_props['group']) {
				$nav_items_list[] = [
					'content' => $item_props['title'],
					'class' => 'nav-title'
				];

			} else {
				$icon = $item_props['icon'] ? '<i class="'.$item_props['icon'].'"></i>' : '';
				$title = $item_props['title'];
				$tags = trim(strtolower($title.' '.$item_props['tags']));
				$is_active = $item_props['active'];

				if ($parent_props) {
					$i18n = $parent_props['i18n'].'_'.strtolower(str_replace(' ', '_', $title));
					$tags = $parent_props['tags'].' '.$tags;

					if ($is_active) $parent_props['active'] = true;
				} else {
					$i18n = 'nav.'.strtolower(str_replace(' ', '_', $title));
				}

				$title_htm = '<span class="nav-link-text" data-i18n="'.$i18n.'">'.$title.'</span>';

				if ($item_props['span']) {
					$span_prop = Util::setValues(['class' => '', 'text' => ''], $item_props['span'], 'text');
					$title_htm .= '<span class="'.$span_prop['class'].'">'.$span_prop['text'].'</span>';
				}

				$li_classes = [];

				$submenu_htm = '';
				if ($item_props['items']) {
					$item_props['i18n'] = $i18n;
					$item_props['tags'] = $tags;

					$submenu_items = $this->parseNav(is_string($item_props['items']) ? [$item_props['items']] : $item_props['items'], $item_props);
					$submenu_htm = parent::printList($submenu_items, null, true);

					if ($is_active || $item_props['active']) {
						$li_classes[] = 'active open';
						if ($parent_props) $parent_props['active'] = true;
					}

				} else if ($is_active) {
					$li_classes[] = 'active';
				}

				if ($item_props['li_class']) {
					if (is_string($item_props['li_class'])) $li_classes[] = $item_props['li_class'];
					else if (is_array($item_props['li_class'])) $li_classes = array_merge($li_classes, $item_props['li_class']);
				}

				$item_class = $item_props['class'] ? ' '.implode(' ', $item_props['class']) : '';
				$item_props['attr']['class'] = ($item_props['attr']['class'] ?? '').' '.$item_class;
				$item_props['attr']['data-filter-tags'] = $tags;

				$nav_item_attrs = array_map(function($attr, $value) {
					return $attr.'="'.escape($value).'"';
				}, array_keys($item_props['attr']), $item_props['attr']);

				$nav_htm = '
					<a href="'.escape($item_props['url']).'" title="'.$title.'" '.($item_props['url_target'] ? 'target="'.escape($item_props['url_target']).'"' : '').' '.implode(' ', $nav_item_attrs).'>
						'.$icon.'
						'.$title_htm.'
					</a>
					'.$submenu_htm.'
				';

				$nav_items_list[] = [
					'content' => $nav_htm,
					'class' => implode(' ', $li_classes)
				];
			}

		}

		return $nav_items_list;
	}
}