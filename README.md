POCCA (Pocket Canteen)
POCCA is a universal canteen management web-based application, made using Laravel. The main goal of the application is to reduce overcrowding of canteens by allowing customers to order online through the application. Additionally, it acts as an easily accessible technological tool that aids canteen vendors in managing their services.

List of Features
All Users:
•	Login
    This function is used by all users to login to their account before being able to use the functionality in the application.
•	Logout
    This function is used by all users to log out from the user account after they are done using the application.
    
Customers:
•	Register Customer
    This function is used by the customer to register a new account for ordering purposes.
•	Edit Profile
    This function is used to edit the profile of a customer. It allows them to edit pictures, change names, phone numbers, email addresses, password, and date of birth.
•	Delete Profile
    This function is used by the customer to delete their account, which will also delete their data in the database.
•	View Canteen
    This function is used by the customer to view all the existing canteens registered in the application.
•	Search Canteen
    This function is used by the customer to search for an existing canteen. The customer can choose whether to search by canteen name or search by vendor name. The output will be the list of canteens containing the           search prompt.
•	Favorite Canteen
    This function is used by the customer to mark their preferred canteen by marking it “Favorite”.
•	View Vendor
    This function is used by the customer to view all the existing vendors registered in the selected canteen.
•	Search Vendor
    This function is used by the customer to search for the existing vendor registered in the selected canteen. The customer can choose whether to search by vendor name or search by menu item name. The output will be the      list of vendors containing the search prompt.
•	Favorite Vendor
    This function is used by the customer to mark their preferred vendor within the selected canteen by marking it “Favorite”.
•	View Current Orders
    This function is used by the customer to see the list of currently ongoing orders. By selecting the order, the vendor can see the details of that order. The details consist of the store name, their contact                 information, the list of ordered menu items and the order status.
•	View History Orders
    This function is used by the customer to see the list of previously completed orders. By selecting the order, the vendor can see the details of that order. The details consist of the store name, their contact              information, the list of ordered menu items and the order status. They can also leave a review.
•	View Menu
    This function is used by the customer to view all the listed menu items provided by the selected vendor.
•	Search Item
    This function is used by the customer to search for the existing menu item in the selected canteen. The customer will need to type the name of the menu item, then the output will be the list of menu items containing        the search prompt.
•	Add Item to Cart
    This function is used by the customer to add the menu item they want to order to the cart. In this function the customer can enter the quantity and put an optional note for the menu item they order in the menu item        detail before adding to the cart.
•	Checkout
    This function is used by the customer to check out the content of the cart which essentially puts the cart content into an order to vendor.
•	Payment
    This function is used by the customer to pay for the order they previously requested to the vendor by uploading the payment proof. They will only be allowed to do this if the vendor already accepts the order request       from the customer.
•	Finish Order
    This functionality can only be used by customers if the status of the order is “Ready”. Customers can finish orders to change the order status into “Complete” meaning that they have already taken the food.
•	Review
    This function is used by the customer when they want to give a review to the vendor. The customer must give a rating and additionally the customer may put the review description and images alongside the rating. This       function is only accessible once the order has already been completed.

Vendors:
•	Register Vendor
    This function is used by the vendor to register a new canteen store account for business purposes.
•	Edit Profile
    This function edits the profile of the vendor account. For vendors, it allows them to update store picture, QRIS, owner name, store name, account password, store contact info, store address, and store description.
•	Delete Profile
    This function is used by the vendor to delete their account, which will also delete the data in the database.
•	Manage Menu
    This function is used by the vendor to manage their menu items and categories in the application. This function consists of 6 related functionalities:
        Add Menu Item: This function is used by the vendor to add the new menu item by clicking the “Add New Menu” button and enter the new menu item detail.
        Edit Menu Item: This function is used by the vendor to update the details of the existing menu item by clicking “Edit” button and enter the new details in the menu item details.
        Delete Menu Item: This function is used by the vendor to delete the existing menu item. This can be done by clicking the “Delete” menu item in the menu item details.
        Search Menu Item: This function is used by vendor to search the menu item using their name as a prompt in the search bar. 
        Create Category: This function is used by the vendor to add the new menu item category.  It can be done by clicking “Add New Category” button. By inputting the new category name in the Add New Category Form and                             click “Add” button.
        Delete Category: This function is used by the vendor to delete existing category. This can be done by clicking the “Delete” button on the selected category. Then the vendor will need to choose where the menu item                           in the deleted category moved to. After that the vendor can click “Confirm” button to finalize deletion.
•	View Current Orders
    This function is used by the vendor to see the list of currently ongoing orders. By selecting the order, the vendor can see the details of that order. The details consist of the customer’s name, their contact `            information, the list of ordered menu items and the order status.
•	View History Orders
    This function is used by the vendor to see the list of previously completed orders. By selecting the order, the vendor can see the details of that order. The details consist of the customer’s name, their contact           information, the list of ordered menu items and the order status.
•	Update Orders Status
    This function is used by the vendor to update the status of existing ongoing order to the next status stage. This process also includes accepting the order, confirming customer payment proof, and changing status to        “Ready” for customer to pick up.
•	View Sales Report
    This function is used by the vendor to view the sales report of the vendor store, depending on the selection the vendor can see today’s sales or a chosen date sales.
•	View Reviews
    This function is used by the vendor to view all the ratings and reviews given from customers to the canteen store.

Admin:
•	Manage Vendors 
    This function is only accessible by Admin. This function is used for the admin to manage the vendor, new and existing vendor. This function consists of 2 functionalities:
    Approve Vendor: This function is used by the admin to approve the new vendor that wants to register their account. The admin selects the incoming new vendor and in the detail page, the admin can approve or reject the                      new vendor by clicking the respective button. Admins can also reject vendors with a reason for rejection.
    Remove Vendor: This functionality is used by the admin to remove the existing vendor from the application by going to vendor detail page and clicking “Remove Vendor” button.
