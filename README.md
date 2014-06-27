Created by Kaushal Kishore <br>
Email : kaushal.rahuljaiswal@gmail.com<br>
Website : http://www.kaushalkishore.com<br>

Users Access Control List for Zend FrameWork 2

<h2>Introduction</h2>
Zend Users ACL is a role based access control list  module for Zend Framework 2, which provides the authentication process for roles for using the actions of controller. You can easily manage the permissions for controller, actions by DB using this module. It contains Roles, Resources, Role Permissions, User Role and the Permission tables for managing the infromation of roles and permissions.

<h2>Tables and its descriptions :</h2>
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
		<pre>
	</li>
</ul>
