Created by Kaushal Kishore <br>
Email : kaushal.rahuljaiswal@gmail.com<br>
Website : http://www.kaushalkishore.com<br>

<h2>Introduction</h2>
Zend Users ACL is a role based access control list  module for Zend Framework 2, which provides the authentication process for roles for using the actions of controller. You can easily manage the permissions for controller, actions by DB using this module. It contains Roles, Resources, Role Permissions, User Role and the Permission tables for managing the infromation of roles and permissions.

<b>Note:</b> This module is dependent on the <a href='https://github.com/kaushalkishorejaiswal/Users' target='_blank'>Users</a> module. If you use the Users module then all the functionality of Users module and the UsersACL module will work perfectaly.

<h2>Tables Structure :</h2>
<ul>
	<li>
		<pre>
		<b>Permission Table:</b>
		CREATE TABLE `permission` (
		  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
		  `permission_name` varchar(45) NOT NULL,
		  `resource_id` int(10) unsigned NOT NULL,
		  PRIMARY KEY (`id`)
		);
		</pre>
	</li>

	<li>
		<pre>
		<b>Resource Table:</b>
		CREATE TABLE `resource` (
		  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
		  `resource_name` varchar(50) NOT NULL,
		  PRIMARY KEY (`id`)
		);
		</pre>
	</li>
	
	<li>
		<pre>
		<b>Role Table:</b>
		CREATE TABLE `role` (
		  `rid` int(10) unsigned NOT NULL AUTO_INCREMENT,
		  `role_name` varchar(45) NOT NULL,
		  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
		  PRIMARY KEY (`rid`)
		);
		</pre>
	</li>
	
	<li>
		<pre>
		<b>Role Permission Table:</b>
		CREATE TABLE `role_permission` (
		  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
		  `role_id` int(10) unsigned NOT NULL,
		  `permission_id` int(10) unsigned NOT NULL,
		  PRIMARY KEY (`id`)
		)
		</pre>
	</li>
	
	<li>
		<pre>
		<b>User Role Table:</b>
		 CREATE TABLE `user_role` (
		  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
		  `user_id` int(10) unsigned NOT NULL,
		  `role_id` int(10) unsigned NOT NULL,
		  PRIMARY KEY (`id`)
		)
		</pre>
	</li>
</ul>

<h2>Tables Data and its descriptions :</h2>
<ul>
	<li>
		<pre>
		Roles : It contains all the Roles for the ZF2 site users. 
		Sample data :
		+-----+-----------+--------+
		| rid | role_name | status |
		+-----+-----------+--------+
		|   1 | Manager   | Active |
		|   2 | Employee  | Active |
		|   3 | Customer  | Active |
		|   4 | Guest     | Active |
		+-----+-----------+--------+
		</pre>
	</li>
	<li>
		<pre>
		Resources : It contains all the controllers name with their full path.
		+----+------------------------------+
		| id | resource_name                |
		+----+------------------------------+
		|  1 | Application\Controller\Index |
		|  2 | Album\Cotroller\Album        |
		|  3 | Users\Controller\Index       |
		+----+------------------------------+
		</pre>
	</li>
	<li>
		<pre>
		Permissions : It contains all the actions name and resource_id for their 
		actions. Currently it contains all the actions of Application 
		Index Controller.
		+----+-----------------+-------------+
		| id | permission_name | resource_id |
		+----+-----------------+-------------+
		|  1 | index           |           1 |
		|  5 | list            |           1 |
		|  6 | add	       |           1 |
		|  7 | edit            |           1 |
		|  8 | delete          |           1 |
		|  9 | update          |           1 |
		+----+-----------------+-------------+
		</pre>
	</li>
	<li>
		<pre>
		User Role : It contains all the roles of the users, 
		where user_id is the primary key of the users.
		+----+---------+---------+
		| id | user_id | role_id |
		+----+---------+---------+
		|  1 |       1 |       1 |
		|  2 |       2 |       2 |
		|  3 |       3 |       3 |
		|  4 |       4 |       4 |
		+----+---------+---------+
		</pre>
	</li>
	<li>
		<pre>
		Role Permissions : It contails all the permission for the role, 
		where role_id is the foreign key of role table and permission_id 
		is the foreign key of permission table.
		+----+---------+---------------+
		| id | role_id | permission_id |
		+----+---------+---------------+
		|  1 |       1 |             1 |
		|  9 |       1 |             5 |
		| 10 |       1 |             6 |
		| 11 |       2 |             7 |
		| 12 |       3 |             8 |
		| 13 |       4 |             9 |
		| 14 |       1 |             7 |
		+----+---------+---------------+
		</pre>
	</li>
</ul>


<h2>Functionality of the UsersACL Module:</h2>
<ul>
<li>Role base page access control</li>
<li>All the things are handled by DB</li>
</ul>

<h2>Installation</h2>
<ul>
<li>Clone the UsersACL Module into your vendor folder</li>
<li>Enabling it in your application.config.phpfile.</li>
<li>Import the UsersACLData.sql file in your database, located in data folder of UsersACL module</li>
</ul>

<h2>Enable the module in application.config.php</h2>
<pre>
&lt;?php
return array(
    'modules' => array(
        // ...
        'UsersACL',
    ),
    // ...
);
</pre>
