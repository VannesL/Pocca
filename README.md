# **POCCA (Pocket Canteen)** <br>
POCCA is a universal canteen management web-based application, made using Laravel. The main goal of the application is to reduce overcrowding of canteens by allowing customers to order online through the application. Additionally, it acts as an easily accessible technological tool that aids canteen vendors in managing their services. <br>
<br>
<br>
## List of Features <br>
### All Users: <br>
•	`Login` <br>
    This function is used by all users to login to their account before being able to use the functionality in the application. <br>
•	`Logout` <br>
    This function is used by all users to log out from the user account after they are done using the application. <br>
    
### Customers:
•	`Register Customer` <br>
    This function is used by the customer to register a new account for ordering purposes. <br>
•	`Edit Profile` <br>
    This function is used to edit the profile of a customer. It allows them to edit pictures, change names, phone numbers, email addresses, password, and date of birth. <br>
•	`Delete Profile` <br>
    This function is used by the customer to delete their account, which will also delete their data in the database. <br>
•	`View Canteen` <br>
    This function is used by the customer to view all the existing canteens registered in the application. <br>
•	`Search Canteen` <br>
    This function is used by the customer to search for an existing canteen. The customer can choose whether to search by canteen name or 
    search by vendor name. The output will be the list of canteens containing the search prompt. <br>
•	`Favorite Canteen` <br>
    This function is used by the customer to mark their preferred canteen by marking it “Favorite”. <br>
•	`View Vendor` <br>
    This function is used by the customer to view all the existing vendors registered in the selected canteen. <br>
•	`Search Vendor` <br>
    This function is used by the customer to search for the existing vendor registered in the selected canteen. The customer can choose whether to search by vendor name or search by menu item name. The output will be the  
    list of vendors containing the search prompt. <br>
•	`Favorite Vendor` <br>
    This function is used by the customer to mark their preferred vendor within the selected canteen by marking it “Favorite”. <br>
•	`View Current Orders` <br>
    This function is used by the customer to see the list of currently ongoing orders. By selecting the order, the vendor can see the details of that order. The details consist of the store name, their contact                 information, the list of ordered menu items and the order status. <br>
•	`View History Orders` <br>
    This function is used by the customer to see the list of previously completed orders. By selecting the order, the vendor can see the details of that order. The details consist of the store name, their contact              information, the list of ordered menu items and the order status. They can also leave a review. <br>
•	`View Menu` <br>
    This function is used by the customer to view all the listed menu items provided by the selected vendor. <br>
•	`Search Item` <br>
    This function is used by the customer to search for the existing menu item in the selected canteen. The customer will need to type the name of the menu item, then the output will be the list of menu items containing       the search prompt. <br>
•	`Add Item to Cart` <br>
    This function is used by the customer to add the menu item they want to order to the cart. In this function the customer can enter the quantity and put an optional note for the menu item they order in the menu item        detail before adding to the cart. <br>
•	`Checkout` <br>
    This function is used by the customer to check out the content of the cart which essentially puts the cart content into an order to vendor. <br>
•	`Payment` <br>
    This function is used by the customer to pay for the order they previously requested to the vendor by uploading the payment proof. They will only be allowed to do this if the vendor already accepts the order request       from the customer. <br>
•	`Finish Order` <br>
    This functionality can only be used by customers if the status of the order is “Ready”. Customers can finish orders to change the order status into “Complete” meaning that they have already taken the food. <br>
•	`Review` <br>
    This function is used by the customer when they want to give a review to the vendor. The customer must give a rating and additionally the customer may put the review description and images alongside the rating. This       function is only accessible once the order has already been completed. <br>
<br>
### Vendors:
•	`Register Vendor`<br>
    This function is used by the vendor to register a new canteen store account for business purposes.<br>
•	`Edit Profile`<br>
    This function edits the profile of the vendor account. For vendors, it allows them to update store picture, QRIS, owner name, store name, account password, store contact info, store address, and store description.<br>
•	`Delete Profile`<br>
    This function is used by the vendor to delete their account, which will also delete the data in the database.<br>
•	`Manage Menu`<br>
    This function is used by the vendor to manage their menu items and categories in the application. This function consists of 6 related functionalities:<br>
        <ul>
        <li> `Add Menu Item`: This function is used by the vendor to add the new menu item by clicking the “Add New Menu” button and enter the new menu item detail.<br> </li>
        <li>`Edit Menu Item`: This function is used by the vendor to update the details of the existing menu item by clicking “Edit” button and enter the new details in the menu item details.<br></li>
        <li>`Delete Menu Item`: This function is used by the vendor to delete the existing menu item. This can be done by clicking the “Delete” menu item in the menu item details.<br></li>
        <li>`Search Menu Item`: This function is used by vendor to search the menu item using their name as a prompt in the search bar. <br></li>
        <li>`Create Category`: This function is used by the vendor to add the new menu item category.  It can be done by clicking “Add New Category” button. By inputting the new category name in the Add New Category Form and                             click “Add” button.<br></li>
        <li>`Delete Category`: This function is used by the vendor to delete existing category. This can be done by clicking the “Delete” button on the selected category. Then the vendor will need to choose where the menu item                           in the deleted category moved to. After that the vendor can click “Confirm” button to finalize deletion.<br></li>
        </ul>
•	`View Current Orders` <br>
    This function is used by the vendor to see the list of currently ongoing orders. By selecting the order, the vendor can see the details of that order. The details consist of the customer’s name, their contact              information, the list of ordered menu items and the order status. <br>
•	`View History Orders`<br>
    This function is used by the vendor to see the list of previously completed orders. By selecting the order, the vendor can see the details of that order. The details consist of the customer’s name, their contact           information, the list of ordered menu items and the order status. <br>
•	`Update Orders Status`<br>
    This function is used by the vendor to update the status of existing ongoing order to the next status stage. This process also includes accepting the order, confirming customer payment proof, and changing status to        “Ready” for customer to pick up. <br>
•	`View Sales Report`<br>
    This function is used by the vendor to view the sales report of the vendor store, depending on the selection the vendor can see today’s sales or a chosen date sales. <br>
•	`View Reviews`<br>
    This function is used by the vendor to view all the ratings and reviews given from customers to the canteen store. <br>

###Admin: <br>
•	`Manage Vendors`<br>
    This function is only accessible by Admin. This function is used for the admin to manage the vendor, new and existing vendor. This function consists of 2 functionalities:<br>
    <ul>
    <li>`Approve Vendor`: This function is used by the admin to approve the new vendor that wants to register their account. The admin selects the incoming new vendor and in the detail page, the admin can approve or reject the                      new vendor by clicking the respective button. Admins can also reject vendors with a reason for rejection.<br> </li>
    <li>`Remove Vendor`: This functionality is used by the admin to remove the existing vendor from the application by going to vendor detail page and clicking “Remove Vendor” button. </li>
    </ul>
