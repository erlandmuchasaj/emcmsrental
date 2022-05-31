<?php
App::uses('Helper', 'View');
class MenuBuilderHelper extends Helper {
    public $helpers = array('Html');

/**
 * The Menu Builder generates the menu links for a website navagation, including generating dropdowns
 * @param  array $loadMenu
 * @param  array $options
 * @return void
 */
    public function load($loadMenu = array(), $options = array()) {

        if (!$loadMenu) {
            return false;
        }

        if (!empty($options['dropdown'])) {
            $ulOptions = [];
            if (!empty($options['ul'])) {
                $ulOptions = $options['ul'];
            }

            if (empty($ulOptions['class'])) {
                $ulOptions['class'] = 'dropdown-menu';
            }

            echo $this->Html->tag('ul', null, $ulOptions);
        }

        if (empty($options['active'])) {
            $options['active'] = 'active';
        }

        foreach ($loadMenu as $menu) {
            $liOptions = array();
            // lets build the li class
            $liClass = array();
            if (!empty($options['class'])) {
                $liClass[] = $options['class'];
            }
            if (str_replace($this->request->base, '', $this->request->here) == $menu['url']) {
                $liClass[] = $options['active'];
            }

            if (!empty($menu['children'])) {
                $liClass[] = 'dropdown';
            }

            // add class to the  li element
            if (!empty($menu['class'])) {
               $liClass[] = $menu['class'];
            }

            $class = implode(' ', $liClass);
            if ($class) {
                $liOptions['class'] = $class;
            }

            echo $this->Html->tag('li', null, $liOptions);

            $linkOptions = array();
            if (!empty($menu['new_window'])) {
                $linkOptions['target'] = '_blank';
            }

            if (!empty($menu['children'])) {
                // $linkOptions['data-target'] = '#menu';
                $linkOptions['data-toggle'] = 'dropdown';
                $linkOptions['data-hover']  = 'dropdown';
                $linkOptions['class']       = 'dropdown-toggle';
            }


            echo $this->Html->link($menu['title'], $menu['url'], $linkOptions);

            if (!empty($menu['children'])) {
                if (empty($options['children'])) {
                    $options['children'] = array();
                }

                $options['children']['dropdown'] = true;
                $this->load($menu['children'], $options['children']);
            }

            echo '</li>';
        }

        if (!empty($options['dropdown'])) {
            echo '</ul>';
        }
    }
}