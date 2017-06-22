# Magento 2 "Affiliate Members"

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
      1. GET requests to http://MAGENTO_URL/rest/default/V1/affiliatemembers should list "all" members
      2. GET requests to http://MAGENTO_URL/rest/default/V1/affiliatemembers?searchCriteria[filterGroups][0][filters][0][field]=status&searchCriteria[filterGroups][0][filters][0][value]=enabled should list only the members which has status == enabled

