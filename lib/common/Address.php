<?php

namespace Common;

class Address {
	private $_input = null;
	private $_geocode_data = null;
	private $_position = null;
	private $_components = null;
	private $_formatted = null;

	public function __construct($input) {
		if (is_object($input)) {
			$input = Util::toArray($input);
		}

		$this->_input = $input;

		if (isset($this->_input['lat']) && isset($this->_input['lng'])) {
			$this->setPosition($this->_input['lat'], $this->_input['lng']);
		}
	}

	public static function zip5($zipcode) {
		if (!$zipcode) return null;

	    $result = substr($zipcode, 0, 5);
	    return str_pad($result, 5, '0', STR_PAD_LEFT);
	}

	public function isCoordinate(&$coordinate = null) {
		if (is_string($this->_input)) {
			$coord = Util::explodeClean($this->_input, ',');
			if (count($coord) === 2) {
           		$coordinate = [(float)$coord[0], (float)$coord[1]];
           	}
		} else if (count($this->_input) && isset($this->_input[0]) && isset($this->_input[1])) {
			$coordinate = [(float)$this->_input[0], (float)$this->_input[1]];
		}

		return $coordinate ? true : false;
	}

	public function isComponents() {
		$arr_input = Util::toArray($this->_input);
		if (!is_array($arr_input)) return false;

		return array_key_exists('city', $arr_input) || array_key_exists('state', $arr_input) || array_key_exists('zip', $arr_input);
	}

	public function format($newline = false) {
		if (!$newline) return $this->getFormatted();

		$components = $this->getComponents();
		$line1 = implode(', ', array_filter([get('address', $components), get('address_2', $components)]));
		$line2 = implode(', ', array_filter([get('city', $components), get('state', $components).' '.get('zip', $components)]));

		return $line1.EOL.$line2;
	}

	public function getFormatted() {
		if ($this->_formatted) return $this->_formatted;

		if ($this->isComponents()) {
			$this->_formatted = Util::formatAddress($this->_input, 'address');
		} else if ($this->isCoordinate()) {
			$components = $this->getComponents();
			$this->_formatted = Util::formatAddress($components, 'address');
		} else {
			$this->_formatted = $this->_input;
		}

		return $this->_formatted;
	}

	public function setPosition($lat, $lng) {
		$this->_position = [$lat, $lng];
		return true;
	}

	public function getPosition($components = null, &$data = null, $force = false) {
		// if (__LOCAL__) return Faker::getPosition($data);

		if ($this->isCoordinate($coordinate)) {
			if (!$force) return $coordinate;

			$param = 'latlng='.urlencode($coordinate[0].','.$coordinate[1]);
		} else {
			if ($this->isComponents()) {
				$address = Util::formatAddress($this->_input, 'address');
			} else {
				$address = $this->_input;
			}

			if (!$address) return false;
			$param = 'address='.urlencode(utf8_encode($address));
		}

		$url = 'https://maps.googleapis.com/maps/api/geocode/json?'.$param.($components ? '&components='.$components : '').'&key='.GOOGLE_API_KEY;

		if ($this->_geocode_data) {
			$data = $this->_geocode_data;
		} else {
			// check for cache
			$cache = new Cache(APP_CACHE_PATH);
	        $cache_name = sha1($url);
	        $data = $cache->get($cache_name);
	        if (!$data) {
	        	$content = file_get_contents($url);
				$data = json_decode($content);

				$cache->set($cache_name, $data, 86400 * 15); // 15d
	        }
		}

		if ($data) {

			// store geocode data;
			$this->_geocode_data = $data;
			$status = $data->status;

			if ($data->status === 'OK') {
				$lat = $data->results[0]->geometry->location->lat;
            	$lng = $data->results[0]->geometry->location->lng;
            	$this->_position = [$lat, $lng];

            	return $this->_position;
			}
		}

		return false;
	}

	public function getComponents() {
		if ($this->_components) return $this->_components;
		if ($this->isComponents()) {
			return $this->_input;
		}

		// force geocode to get data
		$this->getPosition(null, $data, true);
		if ($data) {
            $components = $data->results[0] ?? null;

            $get_component = function ($name) use ($components) {
            	if ($components) {
            		foreach ($components->address_components as $component) {
	                    if (in_array($name, $component->types)) {
	                        return $component->short_name;
	                        break;
	                    }
	                }
            	}

                return null;
            };

            $address = $get_component('street_number');
            $address_2 = $get_component('neighborhood');
            $route = $get_component('route');
            $city = $get_component('locality');
            $state = $get_component('administrative_area_level_1');
            $zip = $get_component('postal_code');

            $address_parts = array();
            if ($address) $address_parts[] = $address;
            if ($route) $address_parts[] = $route;

            $address = implode(' ', $address_parts);

            $this->_components = [
                'address' => $address,
                'address_2' => $address_2,
                'city' => $city,
                'state' => $state,
                'zip' => $zip
            ];

            return $this->_components;
		}

		return false;
    }

    public static function getPinletUrl($name = 'dot', $brand = 'danger', $scale = 2) {
        $color = str_replace('#', '', \App\Content::getColor($brand));

        return 'https://www.google.com/maps/vt/icon/name=assets/icons/poi/tactile/pinlet_shadow-2-medium.png,assets/icons/poi/tactile/pinlet_outline_v2-2-medium.png,assets/icons/poi/tactile/pinlet-2-medium.png,assets/icons/poi/quantum/pinlet/'.$name.'_pinlet-2-medium.png&highlight=ff000000,ffffff,'.$color.',ffffff&color=ff000000?scale='.$scale;
    }

    public static function getPinUrl($brand = 'danger', $scale = 2) {
        $color = str_replace('#', '', \App\Content::getColor($brand));
        $acsent_color = $brand === 'danger' ? '960a0a' : 'ffffff';

        return 'https://www.google.com/maps/vt/icon/name=assets/icons/spotlight/spotlight_pin_v2_shadow-1-small.png,assets/icons/spotlight/spotlight_pin_v2-1-small.png,assets/icons/spotlight/spotlight_pin_v2_dot-1-small.png,assets/icons/spotlight/spotlight_pin_v2_accent-1-small.png&highlight=ff000000,'.$color.','.$acsent_color.',ffffff&color=ff000000?scale='.$scale;
    }

    // http://webdevzoom.com/get-center-of-polygon-triangle-and-area-using-javascript-and-php/
    public static function centroid($coord) {
        $centroid = array_reduce($coord, function ($x,$y) use ($coord) {
            $len = count($coord);
            return [$x[0] + $y[0] / $len, $x[1] + $y[1] / $len];
        }, array(0,0));

        return $centroid;
    }

	public static function staticMap($options, $params = null) {
		$defaults = [
			'size' => '500x400',
			'center' => '39.1146963, -101.3455815',
			'format' => 'jpg',
			'zoom' => 4,
			'autoscale' => 2,
			'scale' => 2
		];

		$params_data = [];

		$options = array_merge($defaults, is_array($options) ? $options : ['center' => $options, 'size' => '500x400']);
		foreach ($options as $key => $value) {
			$params_data[] = $key.'='.urlencode($value);
		}

		if ($params && is_array($params)) {
			foreach ($params as $param) {
				$params_data[] = get('name', $param).'='.urlencode(get('value', $param));
			}
		}

		$url = 'https://maps.googleapis.com/maps/api/staticmap?'.implode('&', $params_data).'&key='.GOOGLE_API_KEY;
		return $url;
	}

	public static function distance($origin, $destination, &$data = null) {
		$distance = false;

        $destination = is_array($destination) ? implode('|', $destination) : $destination;
        $origin = is_array($origin) ? implode('|', $origin) : $origin;

        $url = 'https://maps.googleapis.com/maps/api/distancematrix/json?origins='.urlencode($origin).'&destinations='.urlencode($destination).'&units=imperial&key='.GOOGLE_API_KEY;

        $content = file_get_contents($url);

        if ($output = json_decode($content)) {
            if ($output->rows) {
                $elements = $output->rows[0]->elements[0];
                $data = [
	            	'distance' => isset($elements->distance) ? $elements->distance->value : false,
	            	'duration' => isset($elements->duration) ? $elements->duration->value : false
	            ];

	            $distance = $data['distance'];
            }

            $data['status'] = $output->status;

        } else {
        	$data['status'] = 'ERROR';
        }

        return $distance !== false ? $distance / 1609.34 : false;
    }

	// Sign a URL with a given crypto key
	// Note that this URL must be properly URL-encoded
	public static function signUrl($input_url, $crypto_key, $expires = 1200) {
	    // parse the url
	    $url = parse_url($input_url);

	    $urlPartToSign = $url['path'] . '?' . $url['query'];

	    // Decode the private key into its binary format
	    $decodedKey = base64_decode(str_replace(array('-', '_'), array('+', '/'), $crypto_key));

	    // Create a signature using the private key and the URL-encoded
	    // string using HMAC SHA1. This signature will be binary.
	    $signature = hash_hmac('sha1', $urlPartToSign, $decodedKey,  true);

	    $encodedSignature = str_replace(array('+', '/'), array('-', '_'), base64_encode($signature));

	    return $input_url."&signature=".$encodedSignature.'&t='.(time() + $expires);
	}

	public static function parseGeom($ps) {
        $arr = array();

        //match '(' and ')' plus contents between them which contain anything other than '(' or ')'
        preg_match_all('/\([^\(\)]+\)/', $ps, $matches);

        if ($matches = $matches[0]) {
            foreach ($matches as $match) {
                preg_match_all('/-?\d+\.?\d*/', $match, $tmp_matches);
                if ($tmp_matches = $tmp_matches[0]) {
                    //convert all the coordinate sets in tmp from strings to Numbers and convert to LatLng objects
                    $position = array();
                    for ($i = 0; $i < count($tmp_matches); $i += 2) {
                    	$lat = (float)$tmp_matches[$i];
                        $lng = (float)$tmp_matches[$i + 1];

                        $position[] = array($lat, $lng);
                    }

                    $arr[] = $position;
                }
            }
        }

        //array of arrays of LatLng objects, or empty array
        return $arr;
    }
}