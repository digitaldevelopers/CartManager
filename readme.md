#CartManager  
*API de gestion de panier pour applications e-commerce (**v.1.0**)*

####Installation
**PHP5 requis**
```php
require path/to/CartManager.php; 
```
####API

*En cours de rédaction*
```php
function __construct( string $curr ) {...}
```
```php
function addToCart( array $prod ) {...}
```
```php
function updateQuantity( int $id, [bool $add, int $quantity] ) {...}
```
```php
function deleteItem( int $id ) {...}
```
```php
function resetCart() {...}
```
```php
function nbProduct() {...}
```
```php
function getPrice() {...}
```
```php
function getSymbol() {...}
```
```php
function getStringCurrency() {...}
```
```php
function readMeta( string $key ) {...}
```

####License 
[MIT](http://opensource.org/licenses/MIT)