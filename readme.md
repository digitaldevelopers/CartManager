#CartManager  
*API de gestion de panier pour applications e-commerce*  
**!!! En cours de développement !!!**  
####Installation
```php
require path/to/CartManager.php; 
```
####API
```php
function __construct( string $curr ) {...}
```
```php
function addToCart( array $prod ) {...}
```
```php
function updateQuantity( int $id, [int $quantity] ) {...}
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