<?php
/**
 * Menu Items
 * All Project Menu
 * @category  Menu List
 */

class Menu{
	
	
			public static $navbarsideleft = array(
		array(
			'path' => 'home', 
			'label' => 'Home', 
			'icon' => '<i class="fa fa-home "></i>'
		),
		
		array(
			'path' => 'user', 
			'label' => 'User', 
			'icon' => '<i class="fa fa-users "></i>'
		),
		
		array(
			'path' => 'absensi', 
			'label' => 'Absensi', 
			'icon' => '<i class="fa fa-list "></i>',
'submenu' => array(
		array(
			'path' => 'absensi', 
			'label' => 'Input Absen', 
			'icon' => '<i class="fa fa-building-o "></i>'
		)
		
		/**array(
			'path' => 'ruang_rapat_lantai_2', 
			'label' => 'Ruang Rapat Lantai 2', 
			'icon' => '<i class="fa fa-building-o "></i>'
		),
		
		array(
			'path' => 'ruang_rapat_lantai_3', 
			'label' => 'Ruang Rapat Lantai 3', 
			'icon' => '<i class="fa fa-building-o "></i>'
		),
		
		array(
			'path' => 'ruang_dewan_pengarah', 
			'label' => 'Ruang Dewan Pengarah', 
			'icon' => '<i class="fa fa-building-o "></i>'
		)**/
	)
		),
		
		array(
			'path' => 'contact_us', 
			'label' => 'Contact Us', 
			'icon' => '<i class="fa fa-mobile-phone "></i>'
		),
		
		array(
			'path' => 'role_permissions/add', 
			'label' => 'Role Permissions', 
			'icon' => ''
		),
		
		array(
			'path' => 'roles/add', 
			'label' => 'Roles', 
			'icon' => ''
		)
	);
		
			public static $navbartopleft = array(
		array(
			'path' => 'absensi', 
			'label' => 'Input Absen', 
			'icon' => ''
		)
		
		/**array(
			'path' => 'profile_rupat_2', 
			'label' => 'Ruang Rapat Lantai 2', 
			'icon' => ''
		),
		
		array(
			'path' => 'profile_rupat_3', 
			'label' => 'Ruang Rapat Lantai 3', 
			'icon' => ''
		)
		
		array(
			'path' => 'profile_rupat_dp', 
			'label' => 'Ruang Dewan Pengarah', 
			'icon' => ''
		)**/
	);
		
	
	
			public static $role = array(
		array(
			"value" => "Admin", 
			"label" => "Admin", 
		),
		array(
			"value" => "User", 
			"label" => "User", 
		),);
		
			public static $user_role_id = array(
		array(
			"value" => "Administrator", 
			"label" => "Administrator", 
		),
		array(
			"value" => "User", 
			"label" => "User", 
		),);
		
			public static $user_role_id2 = array(
		array(
			"value" => "admin", 
			"label" => "Admin", 
		),
		array(
			"value" => "user", 
			"label" => "User", 
		),);
		
}