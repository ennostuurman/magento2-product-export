# Spaarne Product Export Module

An educational Magento 2 module to export products to a csv file. 

## Assignment

1. Create a Product Export Module that allows an admin user to export all active simple products to a csv file (var/export/spaarne-product-export.csv) with the following fields: product sku, product name and salable stock qty.
2. The product export should be executed from a separate admin page (route: product_export) which can be navigated to from the admin system menu (System -> Data Transfer). Give the admin user the proper rights to access this page and export these data.
3. The product export will run as an AJAX request ( route: order_export/run). The AJAX controller should return a message to the user indicating success or error. 
4. Create a product attribute which allows the admin to configure whether a product should be exported yes or no. Make sure to only export the products that are allowed for export. 
5. Create a new table which saves the following product export data to the DB, product entity and exported_at datetime (empty if not exported). Think about if you want to just insert these export metadata every time you 
do an export or if you just want to update the exported_at date in case a product has been exported before and is present in the table. Latter will of course keep the table within reasonable size creating as many records as you have simple products.
It all depends on your use case and required functionality, but it's worth to give this a second thought.   

## This lesson focuses on learning the following topics

1. Creating a separate admin page (routing and AJAX controller)
2. Creating an entry in the admin menu
3. Admin user rights (ACL)
4. Returning success / error response messages from an AJAX endpoint 
5. Magento file system (exporting data to CSV)
6. Add custom product attributes (using data patches)
7. Database management (DB schema, create and update tables, getters and setters, the Model-ResourceModel-Collection-triad, insert or update)

## Additional takeaways
1. This assignment shouldn't be just another 101. Coding isn't only about the how-to. Try to understand what Magento does with the code. You're adding code that executes operations in the system. Try to understand the implications of what you're doing. It will make Magento less of a black box and will make you more
creative with coding.You could use xdebug to analyse the request chain, or explore the eav tables when you first run the setup:upgrade to create the export_allowed attribute (hint: look at eav_attribute, patch_list). Change the export_allowed attribute for a product. See if the attribute value appears in the database for the specific
product (entity_id). Hint: look at the catalog_product_entity_* tables (reindex first to make sure the change is there).
2. Don't reinvent the wheel but try to use Magento's built-in functions. For example the Magento insertOnDuplicate function is used in this module to update the product export log table when a product has been exported before.
3. Always test your code, not just blindly deliver. E2E testing is the ultimate test. This module doesn't contain tests, but simply running the export after a change will help you to filter out issues.
4. Always keep performance in mind. Never just deliver your code without having tested performance. Addressing performance bottlenecks in an early stage is vital for the health of the merchant, the customer, the Magento installation and don't forget yourself ;-). 
It's important to realize how your functionality performs. For example the product export in this is module takes about 13 seconds on a Magento 2.4 install with sample data.
That's 1891 simple SKU's. So the export runs on average 145 products per second. After adding in the save export meta data to log table performance is slowed down to
20 seconds or 95 products per second. Writing code and knowing how is one, but trying to understand real-life implications of the functionality you're delivering is another thing.
Now ask yourself what would be the implication when running this against a catalog of a > 100.000 SKU's ;-) . So was it a good idea to write export meta data to the DB at all? 
Back to the drawing board... 


## Prerequisites
1. Magento 2.4.x CE (using the new inventory API's)
2. PHP 7.4


## Disclaimer

This module has been made for personal learning purposes and is for educational purposes only. 
So not suited for commercial re-use. This module for instance uses ES6 syntax which you might want
to compile with Babel when you want to support older browsers. In addition the export is executed in the
browser which might not be a problem with a small sized catalog. However, in real-life situations you'd probably add the product export to the message queue and run the task with cron 
like the default Magento export does (see also my remark about performance in the above takeaways section).


## Special thanks
1. I would like to thank "Mr. autocomplete is the best invention since sliced bread" Joseph Maxwell for being an inspiration. His OrderExport module that accompanies the Magento Developer Certification study guide gave me the idea to create this module.
I'd recommend the SwiftOtter Certification Resources for anyone who wants to learn more about Magento [https://swiftotter.com/certifications#/][] .
2. I would like to thank "Mr. M.acadamy snippets" Mark Shust for providing the one command install Docker environment including the Magento 2.4 sample data install on which I built this module.
And off course for the useful Magento snippets he shares. Checkout his Docker repo and many more [https://github.com/markshust/docker-magento][] .


## Copyright

(c) 2020 - present Spaarne Webdesign, Haarlem, The Netherlands
