<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Application Controller Class
 *
 * This class object is the super class that every library in
 * CodeIgniter will be assigned to.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/general/controllers.html
 */
class CI_Controller {

	private static $instance;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		self::$instance =& $this;

		// Assign all the class objects that were instantiated by the
		// bootstrap file (CodeIgniter.php) to local class variables
		// so that CI can run as one big super object.
		foreach (is_loaded() as $var => $class)
		{
			$this->$var =& load_class($class);
		}

		$this->load =& load_class('Loader', 'core');

		$this->load->initialize();
		
		log_message('debug', "Controller Class Initialized");

	}

	

	public static function &get_instance()
	{
		return self::$instance;
	}
	
	function getProductList()
	{
		$this->db->select('IDCR_TBL_CATEGORY_INFO.Category_Info_Name,IDCR_TBL_PRODUCT_PACKAGE.Product_Package_Name, Product_Info_Id, Product_Info_Id, Product_Info_IMEI_1, Product_Info_IMEI_2, Product_Info_Purchase, Product_Info_Expire, Product_Info_TeamViewer, Product_Info_Description, IDCR_TBL_PROD_STATUS_INFO.Status_Info_Name');
		$this->db->from('IDCR_TBL_PRODUCT_INFO');
		$this->db->join('IDCR_TBL_CATEGORY_INFO', 'IDCR_TBL_CATEGORY_INFO.Category_Info_Id = IDCR_TBL_PRODUCT_INFO.F_Category_Info_Id');	
		$this->db->join('IDCR_TBL_PROD_STATUS_INFO', 'IDCR_TBL_PROD_STATUS_INFO.Status_Info_Id = IDCR_TBL_PRODUCT_INFO.F_Status_Info_Id');	
		
		$this->db->join('IDCR_TBL_PRODUCT_PACKAGE', 'IDCR_TBL_PRODUCT_INFO.F_Product_Package_Id = IDCR_TBL_PRODUCT_PACKAGE.Product_Package_Id', 'left');	
		
		if($Status_Info_Id!='')
		$this->db->where('IDCR_TBL_PROD_STATUS_INFO.Status_Info_Id', $Status_Info_Id);	
		
		if($Is_Void!='')
		$this->db->where('IDCR_TBL_PRODUCT_INFO.Is_Void', $Is_Void);
		

		$this->db->order_by('Product_Info_Id', 'DESC');	
		$query=$this->db->get();
		$product_info=$query->result();
		$query->free_result();
		$result=array();
			if(count($product_info)>0)
			{
				$result= $product_info;
			}
		print_r($result);
	}
	
	
	
	
	
}
// END Controller class

/* End of file Controller.php */
/* Location: ./system/core/Controller.php */