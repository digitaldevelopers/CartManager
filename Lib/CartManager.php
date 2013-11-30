<?php
/**
 * CartManager
 *
 * PHP 5
 *
 * API pour gérer les paniers d'applications e-commerce
 *
 * @version 1.0
 * @author  Gaudé Benjamin <support@gaudebenjamin.com>
 * @license Licence Creative Commons Attribution
 *          Partage dans les Mêmes Conditions 4.0 International 
 *          http://creativecommons.org/licenses/by-sa/4.0/
 */
class CartManager {

	/**
	 * Currency supported
	 * @var array
	 * @since  1.0
	 */
	public $currency_allowed = array(
		'euro' => array(
			'symbol' 	=> '€',
			'singular' 	=> 'euro',
			'plural' 	=> 'euros'
			),
		'dollar' => array(
			'symbol' => '$',
			'singular' => 'dollar',
			'plural' => 'dollars'
			)
		);

	/**
	 * Current currency
	 * @var string
	 * @since  1.0
	 */
	public $currency = "";

	/**
	 * Constructor
	 * @param string $curr Currency to use
	 * @since  1.0
	 */
	public function __construct($curr = 'euro') {
		if( !isset($_SESSION['cart']) ) {
			$_SESSION['cart'] = array();
			$_SESSION['cart']['meta']['created'] = date('Y-m-d H:i:s');
			$_SESSION['cart']['meta']['modified'] = date('Y-m-d H:i:s');
		}

		if( array_key_exists($curr, $this->currency_allowed) ) {
			$this->currency = $curr;
		} else {
			die('This currency (<strong>'.$curr.'</strong>) is not allowed / supported');
		}
	}

	/**
	 * Add item to cart
	 * Update quantity if item is already in cart
	 * @param array $prod Product data
	 *                    Fields: id, name, description, thumbnail, unitPrice
	 * @return void FALSE if an error occured
	 * @since  1.0
	 */
	public function addToCart( $prod = array() ) {
		if( empty($prod) ) {
			return false;
		}
		if( isset($prod['id']) ) {
			if( !isset($_SESSION['cart']['content'][$prod['id']]) ) {
				$_SESSION['cart']['content'][$prod['id']] = array(
					'added' => date('Y-m-d H:i:s'),
					'modified' => date('Y-m-d H:i:s'),
					'quantity' => 1,
					'name' => $prod['name'],
					'description' => $prod['description'],
					'thumbnail' => $prod['thumbnail'],
					'unitPrice' => $prod['price']
				);
				return true;
			} else {
				if( !$this->updateQuantity($prod['id'], true) )
					return false;
			} 	
		} else {
			return false;
		}
	}

	/**
	 * Update the amount of an object
	 * @param  int $id Product ID
	 * @return void  FALSE if an error occured
	 * @since  1.0
	 */
	public function updateQuantity( $id, $add = false, $quantity = 1) {
		if( $this->isInCart($id) ) {
			if( is_integer($quantity) ){
				if( !$quantity ) {
					$this->deleteItem( $id );
				} else {
					if( $add )
						$_SESSION['cart']['content'][$id]['quantity'] += $quantity;
					else
						$_SESSION['cart']['content'][$id]['quantity'] = $quantity;
				}
				$this->lastModified( $id );
			}
		} else {
			return false;
		}
	}
	
	/**
	 * Test id the product is in cart  
	 * @param  int  $id Product id
	 * @return boolean     
	 * @since  1.0
	 */
	private function isInCart( $id ) {
		return isset($_SESSION['cart']['content'][$id]);
	}

	/**
	 * Set last update cart time
	 * @return void
	 * @since  1.0
	 */
	private function lastModified( $id = null ) {
		if( isset($_SESSION['cart']) ) {
			$_SESSION['cart']['meta']['modified'] = date('Y-m-d H:i:s');
		}

		if( !is_null($id) ) {
			if( $this->isInCart($id) ) {
				$_SESSION['cart']['content'][$id]['modified'] = date('Y-m-d H:i:s');
			}
		}
	}

	/**
	 * Delete item from cart
	 * @param  int $id Object's ID
	 * @return boolean    False if error
	 * @since  1.0
	 */
	public function deleteItem( $id ) {
		if( isset($_SESSION['cart']['content'][$id]) ) {
			unset($_SESSION['cart']['content'][$id]);
		} else {
			return false;
		}
	}

	/**
	 * Reset cart if exist
	 * @return boolean False if error
	 * @since  1.0
	 */
	public function resetCart() {
		if( isset($_SESSION['cart']) ) {
			$_SESSION['cart']['content'] = array();
		} else {
			return false;
		}
	}

	/**
	 * Calculating the number of products in the shopping cart
	 * @return int 	$nb Product number - FALSE if an error occured
	 * @since  1.0
	 */
	public function nbProduct() {
		if( isset($_SESSION['cart']) ) {
			$nb = 0;
			if( empty($_SESSION['cart']['content']) ) {
				return $nb;
			}
			foreach($_SESSION['cart']['content'] as $product) {
				$nb += $product['quantity'];
			}
			return $nb;
		}
		return false;
	}

	public function getPrice() {
		if( isset($_SESSION['cart']) ) {
			$price = 0.00;
			if( empty($_SESSION['cart']['content']) ) {
				return number_format($price, 2);
			}
			foreach($_SESSION['cart']['content'] as $product) {
				$price += $product['quantity']*$product['unitPrice'];
			}
			return number_format($price, 2);
		}
		return false;
	}

	/**
	 * Erase all cart session content
	 * @return void 
	 * @since  1.0
	 */
	public function eraseCart() {
		if( isset($_SESSION['cart']) ) {
			unset( $_SESSION['cart'] );
		}
	}

	/**
	 * Return currencu symbol
	 * @return string Symbol
	 * @since  1.0
	 */
	public function getSymbol() {
		return $this->currency_allowed[$this->currency]['symbol'];
	}

	/**
	 * Return string currency
	 * @return strong String currency
	 * @since  1.0
	 */
	public function getStringCurrency() {
		if( $this->getPrice() > 1 ) {
			return $this->currency_allowed[$this->currency]['plural'];
		} else {
			return $this->currency_allowed[$this->currency]['singular'];
		}
	}

	/**
	 * Read meta-data
	 * @param  strong $key Meta-data name
	 * @return string      Meta-data content
	 * @since  1.0
	 */
	public function readMeta($key) {
		if( isset($_SESSION['cart']['meta'][$key]) )
			return $_SESSION['cart']['meta'][$key];

		return false;
	}
}
?>