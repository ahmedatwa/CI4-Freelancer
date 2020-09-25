# YallaFreelancer Platform 

## Description
Freelancer Platform to help people find paid quick, paid Jobs in no time.
A Quick Way to earn Money.

### Server Requirements
* PHP version 7.2 or newer with the *intl* extension and *mbstring* extension installed.
* MySQL (5.1+) via the MySQLi driver
* PostgreSQL via the Postgre driver
* SQLite3 via the SQLite3 driver
* For CURLRequest, you will need libcurl
 
#### For Developers.
##### Extensions Development for both Admin/Catalog:
>
> > 1. Please respect the MVC Framework to create new extensions.
> > 2. start from the Admin\Controllers\Extension.
> > 3. create your first extension controller file which will act as a masetr controller for the new extension.
> > 4. you may follow the same hirarchy for the already installed extension for EX: wallet.php.
> > 5. put lang/view files and view file in their respective location.
> > 6. if you want to alter DB with new Tables use forge class, check Admin\Models\Extension/BidModel.php.
> > <pre><code>$forge = \Config\Database::forge();
> >  $fields = [
> >    'bid_id' => [
> >      'type'  => 'INT',
> >      'constraint'     => '11',
> >    ],
$forge->addField($fields);
$forge->addPrimaryKey('bid_id');
$forge->createTable('bids', true);</code></pre>
> > 7. after finishing the primary extension files, head over to Admin\Extensions and create child extensions to serve the extension purpose, you will find examples there for a good start.
> > 8. once children created with the same flow head over to the Admin Panel menu and install the extension.
> > 10. to call the extension in Catalog, create your MVC files in Catalog\Controllers\Extensions.
<pre><code>$extensionModel = new \Catalog\Models\Setting\ExtensionModel();
$blog = $extensionModel->getExtensions('blog');</code></pre>
>
*****









<div class="footer">
        &copy; 2020 A0twa
</div>
