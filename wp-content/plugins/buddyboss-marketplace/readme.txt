=== MarketPlace ===
Contributors: buddyboss
Requires at least: 3.8
Tested up to: 4.9.6
Stable tag: 1.5.8
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Integrates OneSocial theme and BuddyPress with WC Vendors

== Description ==

MarketPlace gives you the tools you need to create your own online marketplace. It takes full advantage of WooCommerce and WC Vendors, and adds all the missing elements that make a truly amazing MarketPlace.

== Installation ==

1. Make sure BuddyPress is activated.
2. Make sure WooCommerce is activated.
3. Make sure WC Vendors is activated.
4. Visit 'Plugins > Add New'
5. Click 'Upload Plugin'
6. Upload the file 'buddyboss-marketplace.zip'
7. Activate 'MarketPlace' from your Plugins page.

= Configuration =

1. Visit 'BuddyBoss > MarketPlace' and configure your settings.

== Changelog ==

= 1.5.8 =

* New - Updated fontawesome version 
* Fix - Products gallery images blinking on hover 
* Fix - Notice when adding new products and BuddyPress disabled 
* Update - WooCommerce outdated template 
* Fix - Schedule button not visible on add product page
* Update - Updated template for WC Vendor Pro plugin
* Fix - Missing products counts section on pro-dashboard
* Fix - Spinner style on the single product page
* Fix - Coupon text box style on the cart page
* Fix - Fixed Shop Location widget style
* Fix - Fixed miscellaneous icons after fontawesome update


= 1.5.7 =
* Tweak - Added widget setting to enable/disable radius search in shop location widget
* Tweak - Display category slug instead category id in shop section widget
* Fix - Products per row option is not effective when Marketplace active
* Fix - Collections widget showing white image despite products has images
* Fix - Product image zooming not working in mobile device
* Fix - Stores page displaying empty gaps If vendor has less than 13 products
* Fix - Sync vendors social links with social link displaying on a member profile page
* Fix - Fixed WC Vendors Pro 1.5 compatibility issues
* Fix - Since WC Vendors Pro has added SEO tags now we can now remove our plugin SEO tags
* Fix - Redirect vendor login to the specified page from OneSocial login overlay

= 1.5.6 =
* Tweak - Improved styling of Vendor dashboard product list when no product available
* New - Added an option in setting to change single or double row for each vendors displaying in Stores page
* Dev - Updated all WooCommerce template files
* Fix - Various PHP warning fix
* Fix - Fatal error when BuddyPress is disable
* Fix - Add to Favorite tooltip not working on a single product page
* Fix - Improved Product Review tab styling
* Fix - MarketPlace menu widget links are not working on a mobile device if there is no child menu items
* Fix - Store banner has not been displaying on a single product page

= 1.5.5 =
* New - Allow setting for a default Sellers/Stores per page
* Tweak - Store banner image alt text
* Fix - Vendor approval emails are not being sent when admin manually approve vendor application from the admin dashboard
* Fix - MarketPlace category widget menu links redirect home page instead of product category archive

= 1.5.4 =
* Dev - Fixed vendors data query when querying by meta data
* Dev - Refactored singleton instance class
* Dev - Added helper function bm_is_vendor_user to check whether user is vendor or not
* Fix - Profile > Products links disappear from admin bar links when on the homepage
* Fix - Added ABSPATH checks to all files
* Fix - Fixes a fatal error when $product->get_id() is called in Profile > Favorites Shops
* Fix - Mark favorite button working again on seller page

= 1.5.3 =
* Fix - Form Inputs JavaScript setting is disabled in OneSocial, however dropdown reverts to OneSocial style after the ajax call
* Fix - Register as Vendors does not works when default user role is not a subscriber
* Fix - Sellers and Stores page performance optimization
* Fix - Increase priority of pre_get_posts to fix shop search
* Fix - Various notices/warnings
* Fix - Top navigation menu items disappear after searching in location widget
* Fix - Vendor should be forced to activate the account as soon as they submit vendor registration form
* Fix - Vendors are not showing in the auto suggestion list when editing homepage Featured Sellers widgets
* Fix - Check for the Selects is defined before init_selects
* Fix - Vendor user becomes subscriber when admin user manually activates the account from Admin > Users > Pending
* Fix - Add to Favorites does not show for some vendors
* Fix - Save Changes button does nothing on the Vendor Dashboard setting form
* Tweak - Improve add to favorite button style for better mobile experience

= 1.5.2 =
* Enhancement - Removed vendors without product from sellers and store pages
* Fix - location search widget

= 1.5.1 =
* Fix - Store search bar on the vendor store page pulls result from all products
* Fix - Vendors orders count is not showing on the sellers page
* Fix - Show product count in  prodod
* Fix - Removed BuddyPress is active check from required plugins check
* Fix - Shop location filter widget long search text creates styling issue
* Fix - Featured products title font size too big in marketplace menu
* Fix - Blank screen on theme switch
* Fix - Category widgets link has 404 page if coming from any pagination page.
* Fix - The Next button is missing at the bottom of orders table in the Profile > Orders
* Fix - On the tablet the menu of marketplace when displayed is striped
* Fix - When we remove one of the favorite product, all our favorite products are gone.
* Fix - WC Vendors Pro 1.4.4 compatibility fix
* Fix - Order page styling fix
* New - Search radius option added in shop location filter widget
* New - Added option to show up category in MarketPlace categories menu even if don’t have products added yet in that category yet.
* New - Added option to manually choose vendors inside the Featured sellers widget.
* New - Added option to automatically pull newset product in Newest Products widget
* New - Added Favorite button for non logged in users

= 1.5.0 =
* Fix - Dual message if cart is empty
* Fix - Product - Gallery navigation
* Fix - If vendor removes an image from the image gallery of a product, a blank image appears on the front end
* Fix - Cache code added for vc element
* Fix - Removed BuddyPress dependency
* Fix - Added transient cache for widget

= 1.4.2 =
* Enhancement – License Module

= 1.4.1 =
* Fix - Vendor shipping tab select box style fix
* Fix - Order received page style tweak
* Fix - WCV 1.4 templates update

= 1.4.0 =
* Fix - Register fixes to become Vendor
* Fix - Shop name when sharing link on Facebook
* Fix - Product feed widget on homepage still shows the deleted product
* Fix - PHP Warning and Notices
* Fix - Vendor product image upload issue
* Fix - WooCommerce loop_shop_per_page filter not working
* Fix - Cant swipe up/down on single product page after reaching the product pictures point
* Fix - Terms and conditions option for vendors on Registration overlay form
* Fix - When user apply color filter in shop page or shop category, the website don’t load the footer
* Fix - MarketPlace widget menu items are not clickable on mobile
* Fix - Font family inside typography is being overridden by hardcoded ones inside css files
* Fix - Cant override single-product-reviews.php
* Fix - Out of stock Item is also included in listing of products on single product page
* Fix - Serving Scaled Images
* Fix - Product gallery sometime show duplicate images. Showing product featured images 2 times in lightbox
* Fix - JS Error in browser console
* Fix - Search field on Sellers page for sellers says Stores
* Fix - In Vendor dashboard category men and sticky menu overlap with the order detail popup
* Fix - Recent product widget column settings issue fix
* Fix - Geodirectory conflict fix
* Fix - WooCommerce 3.0 Product Gallery fixes
* Fix - Sub categories for all Marketplace categories do then not display
* Fix - Updated placeholder text
* Fix - Pagination on Vendor > Product listing page

= 1.3.1 =
* Fix - Vendor Dashboard order table has wrong row titles in mobile
* Fix - Buttons are getting cut in mobile

= 1.3.0 =
* Fix - Internet Explorer issues on Store
* Fix - Featured Sellers widget not working after VC 5.0 update
* Fix - Market Panel hover color issue
* Fix - OneSocial theme typography not always working with MarketPlace
* Fix - Hidden product still showing in shop link on single product page
* Fix - Shipping fields under Vendor dashboard shipping tab conflict with WC Vendors Pro 1.3.7
* Fix - Disabled the store banner in WC Vendors Pro but vendors are still able to upload banners.
* Fix - 2nd search query throws 404 error on a paginated search result
* Fix - On single product page right side Upsell products are broken
* Fix - Some URLs have underscores and are not SEO friendly
* Fix - WPML compatibility with Stores, Sellers, and Homepage Handpicked Collection widget
* Fix - Demo Data Google Font 404 issue inside console
* Fix - Location filter widget text can not be translated
* Fix - Option to add Meta title and Meta description for Vendor specific pages with Yoast SEO

= 1.2.1 =
* Fix - Single Store pages broken with free version of WC Vendors plugin

= 1.2.0 =
* New - Improve product slider, for a smooth experience
* New - Add a magnifier glass when viewing a product image
* New - Add options to control colors and fonts for MarketPanel navigation
* New - Social SnapChat for vendors
* New - Verified Vendors Badge
* New - Complete shipping interface for user screen and product edit in wp-admin
* Fix - Display the favorite count in Dashboard > Products
* Fix - Search results, show 4 products on the last line
* Fix - Asking a question - Autofill the product name in the subject line
* Fix - Feedback does not have any specific ID or class on Sellers Page
* Fix - Not able to add two word tags during creat/edit product from frontend
* Fix - Whenever the country is changed, the state and zipcode options do not reset according to each country
* Fix - Private listing visible in Store Banner on single product page
* Fix - Remove particular shop from Favorite is removing all shops from the members Favorite Shop list
* Fix - Default store banner not showing when vendor does not have store banner
* Fix - WooCommerce 'Set Zone for shipping' search box not working with WC Vendors Pro activated
* Fix - Shipping label appearing many times
* Fix - On Mobile, Store thumbnail is distorted
* Fix - All Sellers page layout
* Fix - Visual Composer Columns stuck at 4. Unable to change.
* Fix - Speed performance issues due to too many queries
* Fix - Out of 4 Products, 3 are displaying in first row and 4th item in 2nd row on Homepage in safari
* Fix - MarketPanel Latest product tab
* Fix - Shop owner avatar in mobile
* Fix - MarketPlace Pages Bold Text option of Typography is not working
* Fix - Vendor is unable to add featured image for product in IE11
* Fix - Dashboard Setting page, Country drop down getting broken with WC Vendors Pro 1.3.3
* Fix - WC Vendors Pro fixed shipping from issue, we need to update our code.
* Fix - Vendors can't edit existing coupons
* Fix - Support for default store cover
* Fix - Users redirect to the vender dashboard after register is not working with overlay when user registers as vendor
* Fix - RTL layout issues
* Fix - Top rated products widgets
* Fix - Coupon usage restriction has duplicate labels
* Fix - Vendor Application form drop down issue
* Fix - When products are out of stock the favorite button looks wrong in MarketPanel
* Fix - Cart icon redirects to product page on click
* Fix - Country and zip fields need margin between each other
* Fix - Snapchat box is missing
* Fix - Store banner cover photo placeholder
* Fix - Notification pop-up on hover
* Fix - Compatibility with new WC Vendors shortcodes
* Fix - Shipping calculation drop down
* Fix - Font loading issue / FontAwesome  update
* Fix - Warning on category page
* Fix - Duplicate products via dashboard
* Fix - WooCommerce template override in child theme not working for content-product.php
* Fix - Homepage keeps showing deleted data (Products)
* Fix - Light box for a product gallery images not working correctly on single product page
* Fix - Store message view looks broken

= 1.1.2 =
* Fix - Shop owner avatar size issue in mobile
* Fix - Products are displaying in wrong rows on homepage in Safari
* Fix - Blank space that is left only in the first row on mobile devices
* Fix - Removed hard-coded font family

= 1.1.1 =
* Fix - Member avatar appearing stretched on mobile devices
* Fix - WooCommerce Filter loop_shop_columns is not working
* Fix - Internet Explorer 11 all homepage elements are very wide
* Fix - Missing argument 3 for BuddyBoss_BM_Plugin::bm_login_redirect()

= 1.1.0 =
* New - Add the seller's name & link below in the product box
* New - Add a checkbox to registration page for vendors
* New - Add the follow button to the Shop owner box
* Tweak - Adjust dropdown menu styling
* Fix - Geolocation Shop Location filter
* Fix - PHP Notices
* Fix - Dashboard Products Pagination issue
* Fix - Multiple digits product price issue on MarketPanel
* Fix - Product Sold Out display on Index Pages
* Fix - WC Vendors Product Variation integration Issues

= 1.0.9 =
* Fix - Syntax errors in main-class.php

= 1.0.8 =
* Fix - Private products showing on Stores and Sellers pages
* Fix - Vendor My Product tab
* Fix - Override wc_vendors and woocommerce template in child theme
* Fix - Deleted products should be removed from all user Favorite lists
* Fix - BuddyPress Reorder Tabs plugin compatibility
* Fix - Tabs misaligned on single Product page
* Fix - Main menu missing after searching inside shop
* Fix - Product pagination not working
* Fix - Save Product button not working
* Fix - Calendar not work properly in WC Vendors Pro dashboard

= 1.0.7 =
* Fix - MarketPanel layout on mobile
* Fix - MarketPanel hover with multiple categories
* Fix - Compatibility with WC Vendors attributes

= 1.0.6 =
* New - Shop Location filter added
* New - Allow adding colors from front-end while editing product
* Fix - Compatibility with YITH WooCommerce Ajax Product Filter plugin
* Fix - Menu: Subcategories appearing twice, at 1st and 2nd levels
* Fix - "Product Management" option in WC Vendors
* Fix - Search result pagination showing 404
* Fix - Search filter result order
* Fix - Layout issues with MarketPanel disabled
* Fix - Warning Errors on Product Edit page
* Fix - Various layout issues

= 1.0.5 =
* Tweak - Better formatted product search results for BP Global Search
* Tweak - Disable plugin and show error, when attempting to switch themes
* Tweak - Hide Vendors shops who haven't listed any products
* Tweak - Option for featured seller by User ID, in Visual Composer
* Fix - Updated templates for WC Vendors v1.2.3
* Fix - Pinterest not appearing in social links
* Fix - PHP notice below single product thumbnail
* Fix - Tooltip cut off on mobile
* Fix - Ask a Question when not logged in
* Fix - Featured Seller layout improvements
* Fix - Related Products display on Product single
* Fix - Select tab on Coupons page
* Fix - Better hover behavior in MarketPanel
* Fix - Swap placehold.it images for built in images
* Fix - Notices on Product Categories widget
* Fix - WooCommerce sidebar switching not working
* Fix - Schedule sale option hidden on Vendor Product Listing form
* Fix - Style Order Modal, Order Filters on dashboard/orders page
* Fix - Various CSS issues

= 1.0.4 =
* Fix - Removed hidden inputs
* Fix - WooCommerce hooks
* Fix - Slider issues

= 1.0.3 =
* Fix - Allow featured seller set by site option
* Fix - Vendor Store page broken when Messages component is disabled
* Fix - Category widget is not working with Visual Composer
* Fix - Remove 'Products' tab on BuddyPress profile menu for non-Vendors
* Fix - Add to Basket confirmation message taking up whole page
* Fix - Add Product and Add Coupon buttons not appearing on Dashboard
* Fix - Upsell, cross-sell issue in Vendor Pro Dashboard product edit page
* Fix - WC Vendors template changes not applying
* Fix - Safari layout issues
* Fix - Tooltip getting cut in mobile
* Fix - 404 errors

= 1.0.2 =
* Fix - Error notice when deactivating WC Vendors Pro
* Fix - Compatibility with PHP 5.4
* Fix - Various CSS issues

= 1.0.1 =
* Fix - Minor CSS issues

= 1.0.0 =
* Initial Release
