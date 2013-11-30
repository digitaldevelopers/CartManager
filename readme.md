#CartManager  
*API de gestion de panier pour applications e-commerce*

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
![](http://i.creativecommons.org/l/by-sa/4.0/88x31.png)  
Ce(tte) œuvre est mise à disposition selon les termes de la [Licence Creative Commons Attribution - Partage dans les Mêmes Conditions 4.0 International](http://creativecommons.org/licenses/by-sa/4.0/)