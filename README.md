# Magento 2 "Affiliate Members"
Zb is the namespace, my last name Zaib.

1. Display "Affiliate Members" link in Admin Menu under "Marketing" menu.
2. After clicking on the menu link from Step 2, It should open grid view for Affiliate Members
3. In grid, display following field items.
      1. Name
      2. Status
      3. Created
      4. Modified
4. add/edit/delete members.
5. While adding/editing capture following information
      1. Name (String Field)
      2. Status (Enabled/Disabled Option)
      3. Profile Image (Image Uploader)
6. public API for this module as following
      1. GET requests to http://MAGENTO_URL/index.php/rest/V1/affiliatemembers/list should list "all" members
      2. GET requests to http://MAGENTO_URL/index.php/rest/V1/affiliatemembers/active should list only the members which has status == enabled

