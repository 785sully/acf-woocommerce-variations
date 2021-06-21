# acf-woocommerce-variations
This is collection of files from various blog posts that add Advanced Custom Field support to WooCommerce variations.

Advanced Custom Fields doesn't support product variations out of the box but you can add support by adding the acf-variations.php code to your project. You do that either by pasting the code directly into your functions.php file or linking to it from the functions.php file.
```php
require get_template_directory() . '/functions/acf-variations.php';
```
Once that is added to your site you can then create custom fields and assign them to product variations.

I collected code examples and feedback from at least three different forum posts on the ACF forums to get this feature to work. 
[This is one of the ACF forum sources I could find.](https://support.advancedcustomfields.com/forums/topic/custom-fields-on-woocommerce-product-variations/)
