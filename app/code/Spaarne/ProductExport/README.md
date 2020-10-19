**Assignment**

1. Create a Product Export module that allows an admin user to export all active simple products with the following fields: product sku, product name and salable stock qty.
2. The product export should be executed from a separate admin page (route: product_export) which can be navigated to from the admin system menu (System -> Data Transfer). Give the admin user the proper rights to export these data.
3. The AJAX controller should return a message to the user indicating success or error. 
4. Create a product attribute which allows the admin to configure whether a product should be exported yes or no. Make sure to only export the products that are allowed for export. 
5. Create a new table which saves the following product export data to the DB, product entity and exported_at datetime (empty if failed). 


**This lesson focuses on learning the following topics**

1. Creating a separate admin page (routing and AJAX controller)
2. Creating an admin menu
3. Admin user rights (ACL)
4. Returning user success / error messages from an AJAX controller 
5. Magento file system (exporting data to CSV)es
6. Add custom product attributes (data patches)
7. Database management (DB schema, create table, update table)


**Prerequisites**
1. Magento 2.4.x CE
2. PHP 7.4


**Disclaimer**

This module has been made for personal learning purposes and is for educational purposes only. 
So not suited for commercial re(use) whatsoever.

**Copyright**

(c) 2020 - present Spaarne Webdesign, Haarlem, The Netherlands

**Author** 

Enno Stuurman

