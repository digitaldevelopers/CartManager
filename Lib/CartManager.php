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
 * @license MIT 
 */
class CartManager {
	
	/**
	 * Meta-data for verbose creation
	 * @var array
	 * @since  1.0
	 */
	private $meta = array(
		'created' => date(),
		'modified' => date()
	);

	/**
	 * Create Cart
	 * @param  boolean $verbose Add meta-data into cart
	 * @return void           
	 * @since  1.0
	 */
	public function createCart() {
		if( !isset($_SESSION['cart']) ) {
			$_SESSION['cart'] = array();
		}
		array_push($_SESSION['cart'], $this->meta);
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
			if( !isset($_SESSION['cart'][$prod['id']]) ) {
				$_SESSION['cart'][$prod['id']] = array(
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
				if( !$this->updateQuantity($prod['id']) )
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
	public function updateQuantity( $id, $quantity = 1) {
		if( $this->isInCart($id) ) {
			if( is_integer($quantity) ){
				if( !$quantity ) {
					$this->deleteItem( $id );
				} else {
					$_SESSION['cart'][$id]['quantity'] += $quantity;
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
		return isset($_SESSION['cart'][$id]);
	}

	/**
	 * Set last update cart time
	 * @return void
	 * @since  1.0
	 */
	private function lastModified( $id = null ) {
		if( isset($_SESSION['cart']) ) {
			$_SESSION['cart']['meta']['modified'] = date();
		}

		if( !is_null($id) ) {
			if( $this->isInCart($id) ) {
				$_SESSION['cart'][$id]['modified'] = date();
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
		if( isset($_SESSION['cart'][$id]) ) {
			unset($_SESSION['cart'][$id])
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
			$_SESSION['cart'] = array();
		} else {
			return false;
		}
	}
}
?>