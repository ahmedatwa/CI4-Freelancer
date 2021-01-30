# YallaFreelancer Platform 
Thanks to [Codeigniter 4](https://codeigniter.com) Team who made all of this possible. 
[User Guide](https://codeigniter.com/user_guide/index.html) could be found here as your primary resource.

## Install ##
* install .SQL file located in install folder to your new DB
* open App.php in admin=>config/catalog=>config folder change baseURL & httpCatalog to your domain name
* open Database.php in admin=>config/catalog=>config folder, add your DB connection params.

## Description ##
Freelancer Platform to help people find paid quick, paid Jobs in no time.
A Quick Way to earn Money.
The System could be expanded with no limitations.
Code is usable, which means that it will serve your needs to create any Webtool/Site.

### Before we kick off Please respect the MVC Framework and don't alter the core files. ######

## Server Requirements ##
* PHP version 7.2 or newer with the *intl* extension and *mbstring* extension installed.
* MySQL (5.1+) via the MySQLi driver
* PostgreSQL via the Postgre driver
* SQLite3 via the SQLite3 driver
* For CURLRequest, you will need libcurl
 
#### For Developers. ####
- Extensions Development for both Admin/Catalog:
Extensions are helper files that extend the core funcionality of the system.
They could be designed for Admin or Catalog.
> 1. start from the Admin\Controllers\Extension.
> 2. create your first extension controller file which will act as a masetr controller for the new extension.
> 3. you may follow the same hirarchy for the already installed extension for EX: wallet.php.
> 4. put lang/view files and view file in their respective location.
> 5. if you want to alter DB with new Tables use forge class, check Admin\Models\Extension/BidModel.php.
> <pre><code>$forge = \Config\Database::forge();
>  $fields = [
>    'bid_id' => [
>      'type'  => 'INT',
>      'constraint'     => '11',
>    ],
> $forge->addField($fields);
> $forge->addPrimaryKey('bid_id');
> $forge->createTable('bids', true);</code></pre>
> 7. after finishing the primary extension files, head over to Admin\Extensions and create child extensions to serve the extension purpose, you will find examples there for a good start.
> 6. once children created with the same flow head over to the Admin Panel menu and install the extension.
> 7. to call the extension in Catalog, create your MVC files in Catalog\Controllers\Extensions.
> <pre><code>$extensionModel = new \Catalog\Models\Setting\ExtensionModel();
> $blog = $extensionModel->getExtensions('blog');</code></pre>
```diff
- Important Note, you might encounter issues with lang vars, since no lang data vars are needed in controller.
- therfore you have to alter the Config/Routes.php following the same rules for correct routing.
- Nice isn't it ?
```
>
*****
- Modules Development for both Catalog:
Modules Are created to extend the Theme layout like adding information boxes to Layout parts 
After creating a module it must be assigned to template layout from design menu otherwise they won't be visiable to frontend
> 1. Modules unlike Extensions, they require less work.
> 2. start from the Admin\Controllers\Modules.
> 3. create your first controller, a good start will be checking Account.php.
> 4. put lang/view files and view file in their respective location.
> 5. install your module from Extensions Module 
> 10. Assign the Module to Layout from Design->layout and the Module will be called automatically from their respective layout
*****


<div class="footer">&copy; 2020 A0twa</div>
