# WC Filter Migration #
**Contributors:**      Bryan Headrick  
**Donate link:**       https://bryanheadrick.com  
**Tags:**  
**Requires at least:** 4.4  
**Tested up to:**      4.8.1 
**Stable tag:**        0.0.0  
**License:**           GPLv2  
**License URI:**       http://www.gnu.org/licenses/gpl-2.0.html  

## Description ##

Migrate from [Product Filters for WooCommerce](https://woocommerce.com/products/product-filters/) to [Berocket WC AJAX Product Filters](https://berocket.com/product/woocommerce-ajax-products-filter)

## Installation ##

### Manual Installation ###

1. Upload the entire `/wc-filter-migration` directory to the `/wp-content/plugins/` directory.
2. Activate WC Filter Migration through the 'Plugins' menu in WordPress.

### Usage ###

Create a checkbox filter in the style you want all filters to have.
run the cli command followed by the post id of the filter you created to model after and then id of the filter group.
This assumes only one filter group.

example: 
wp wc_filter_migration {filter id} {group id}

## Limitations ##
This was built for a fairly limited use case, so not all possible options will be migrated. 
This was only tested against filters on product attributes and tags and the only display rules were for a single product 
category id. This assumes a single product group from the source and destination. This will only migrate checkbox filters.

## Screenshots ##


## Changelog ##

### 0.0.0 ###
* First release

## Upgrade Notice ##

### 0.0.0 ###
First Release
