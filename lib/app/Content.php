<?php

namespace App;

use \Common\Util;
use \Bootstrap\Components\Component;
use \Bootstrap\Components\Input;
use \Bootstrap\Components\Select;

class Content {

    public static function printAlert($message, $type = 'danger', $return = false) {
        /*

        // you can also use the Alert component
        $alert = new \Bootstrap\Components\Alert($message, $type);
        $content = $alert->printHtml();

         */

        $content = '<div class="card shadow-none border-'.$type.' mb-4">
            <div class="card-body p-3">
                <p class="card-text">'.$message.'</p>
            </div>
        </div>';

        if ($return) return $content;
        else echo $content;
    }

    public static function printEmpty($text = 'empty', $return = false) {
        $content = '<span class="badge badge-outline-default text-muted">'.$text.'</span>';
        if ($return) return $content;
        else echo $content;
    }

    public static function printAddress($defaults = null, $name_prefix = '', $return = false) {
        $address = (new Input($name_prefix.'address', ['group_class' => 'col-md-6']))
            ->value(escape(get($name_prefix.'address', $defaults)))
            ->label('Street')
            ->placeholder('Street and number')
            ->attr(['required'])
            ->printHtml(true);

        $address_2 = (new Input($name_prefix.'address_2', ['group_class' => 'col-md-6']))
            ->value(escape(get($name_prefix.'address_2', $defaults)))
            ->label('&nbsp;')
            ->placeholder('Appartment, building, floor, etc.')
            ->printHtml(true);

        $city = (new Input($name_prefix.'city', ['group_class' => 'col-md-6']))
            ->value(escape(get($name_prefix.'city', $defaults)))
            ->label('City')
            ->placeholder('Enter city')
            ->attr(['required'])
            ->printHtml(true);

        $state = self::printStates([
                'group_class' => 'col-md-3',
                'name' => $name_prefix.'state',
                'class' => 'custom-select flex-grow-1',
                'selected' => get($name_prefix.'state', $defaults)
            ], true, true);

        $zip = (new Input($name_prefix.'zip', ['group_class' => 'col-md-3']))
            ->value(escape(get($name_prefix.'zip', $defaults)))
            ->label('Zip')
            ->placeholder('12345')
            ->attr(['required', 'maxlength' => 10])
            ->printHtml(true);

        $content = $address.EOL.$address_2.EOL.$city.EOL.$state.EOL.$zip;

        if ($return) return $content;
        else echo $content;
    }

    public static function printPostToken($url, $return = false) {
        $token = self::getPostToken($url);
        if ($token) {
            $content = '<input type="hidden" name="authenticity_token" value="'.escape(base64_encode($token)).'">'.EOL;

            if ($return) return $content;
            else echo $content;
        }
    }

    public static function getPostToken($url) {
        $token = token(64);
        if (session_id()) {
            $hashed_url = sha1($url);
            $_SESSION[CSRF_SESSION_NAME][$hashed_url] = $token;

            return hash_hmac('sha256', $url, $token);
        }

        return false;
    }

    public static function verifyPost() {
        if (session_id() && is_post()) {
            $post_token = get('authenticity_token', $_POST);
            $key = sha1(SERVER_REQUEST);
            $session_token = get($key, $_SESSION[CSRF_SESSION_NAME]);
            $calc = hash_hmac('sha256', SERVER_REQUEST, $session_token);

            $result = hash_equals(base64_encode($calc), $post_token);
            if ($result) {
                unset($_SESSION[CSRF_SESSION_NAME][$key]);
                return $result;
            }
        }

        throw new \Exception('Failed to authenticate the request. Please try again later.');
    }

    public static function money($amount = 0.00, $format = '%(#10n', $locale = 'en_US') {
        setlocale(LC_MONETARY, $locale);
        return money_format($format, $amount);
    }

    public static function highlight($text, $subject) {
        return preg_replace('/('.$text.')/i', '<span class="bg-yellow">${1}</span>', $subject);
    }

    public static function printYears($options = [], $required = true, $return = false) {
        $years = [];
        $year_now = date('Y');
        $year_end = date('Y', strtotime('+15 year'));
        foreach (range($year_now, $year_end) as $year) {
            $years[] = [
                'value' => $year,
                'display' => $year
            ];
        }

        $options = Util::setValues([
            'id' => uuid(),
            'class' => 'custom-select',
            'group_class' => '',
            'grouped' => true,
            'name' => 'month',
            'display' => 'display',
            'value' => 'value',
            'label' => null,
            'default' => 'YYYY',
            'attr' => [$required ? 'required' : null],
            'selected' => ''
        ], $options, 'selected');

        return (new Select($years, get('name', $options), get('value', $options), get('display', $options), [
            'grouped' => get('grouped', $options),
            'group_class' => get('group_class', $options)
        ]))
            ->class(get('class', $options))
            ->default(get('default', $options))
            ->attr(get('attr', $options))
            ->label(get('label', $options))
            ->id(get('id', $options))
            ->selected(get('selected', $options))
            ->printHtml($return);
    }

    public static function printHours($options = [], $required = true, $return = false) {
        $hours = [];
        foreach (range(0, 23) as $num) {
            $value = str_pad($num, 2, 0, STR_PAD_LEFT).':00';
            $hours[] = [
                'value' => $value,
                'display' => $value
            ];
        }

        $options = Util::setValues([
            'id' => uuid(),
            'class' => 'custom-select',
            'group_class' => '',
            'grouped' => true,
            'name' => 'hour',
            'display' => 'display',
            'value' => 'value',
            'label' => null,
            'options' => null,
            'default' => 'Hour',
            'selected' => '08:00',
            'attr' => [$required ? 'required' : null],
        ], $options, 'selected');

        return (new Select($hours, get('name', $options), get('value', $options), get('display', $options), [
            'grouped' => get('grouped', $options),
            'group_class' => get('group_class', $options)
        ]))
            ->class(get('class', $options))
            ->default(get('default', $options))
            ->attr(get('attr', $options))
            ->label(get('label', $options))
            ->id(get('id', $options))
            ->selected(get('selected', $options))
            ->printHtml($return);
    }

    public static function printDays($options = [], $required = true, $return = false) {
        $weekdays = [1 => 'Monday', 2 => 'Tuesday', 3 => 'Wednesday', 4 => 'Thursday', 5 => 'Friday', 6 => 'Saturday', 0 => 'Sunday'];
        $days = [];
        foreach ($weekdays as $value => $display) {
            $days[] = [
                'value' => $value,
                'display' => $display
            ];
        }

        $options = Util::setValues([
            'id' => uuid(),
            'class' => 'custom-select',
            'group_class' => '',
            'grouped' => true,
            'name' => 'day',
            'display' => 'display',
            'value' => 'value',
            'label' => null,
            'options' => null,
            'default' => 'Day',
            'attr' => [$required ? 'required' : null],
            'selected' => 1
        ], $options, 'selected');

        return (new Select($days, get('name', $options), get('value', $options), get('display', $options), [
            'grouped' => get('grouped', $options),
            'group_class' => get('group_class', $options)
        ]))
            ->class(get('class', $options))
            ->default(get('default', $options))
            ->attr(get('attr', $options))
            ->label(get('label', $options))
            ->id(get('id', $options))
            ->selected(get('selected', $options))
            ->printHtml($return);
    }

    public static function printMonths($options = [], $required = true, $return = false) {
        $months = [];
        foreach (range(1, 12) as $month) {
            $months[] = [
                'value' => $month,
                'display' => $month
            ];
        }

        $options = Util::setValues([
            'id' => uuid(),
            'class' => 'custom-select',
            'group_class' => '',
            'grouped' => true,
            'name' => 'month',
            'display' => 'display',
            'value' => 'value',
            'label' => null,
            'options' => null,
            'default' => 'MM',
            'attr' => [$required ? 'required' : null],
            'selected' => ''
        ], $options, 'selected');

        return (new Select($months, get('name', $options), get('value', $options), get('display', $options), [
            'grouped' => get('grouped', $options),
            'group_class' => get('group_class', $options)
        ]))
            ->class(get('class', $options))
            ->default(get('default', $options))
            ->attr(get('attr', $options))
            ->label(get('label', $options))
            ->id(get('id', $options))
            ->selected(get('selected', $options))
            ->printHtml($return);
    }

    public static function getColor($brand) {
        $brand_colors = array(
            'default' => '#6a7eb5',
            'secondary' => '#868e96',
            'info' => '#1dc7a0',
            'primary' => '#6a7eb5',
            'danger' => '#ff4341',
            'success' => '#1dc944',
            'warning' => '#ffd541',
            'muted' => '#999999'
        );

        if (!isset($brand_colors[$brand])) $brand = 'info';

        return $brand_colors[$brand];
    }
}