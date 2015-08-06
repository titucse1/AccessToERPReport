<?php
class  CI_Sess_lib
{
	var $CI;

  	function __construct()
	{
		$this->CI =& get_instance();
	}

	function get_cart()
	{

             @session_start();
             if(!isset($_SESSION['cart_my']))
             {   $_SESSION['cart_my']=array(); }

		return $_SESSION['cart_my'];
	}
  

	function set_cart($cart_data)
	{
		//$this->CI->session->set_userdata('cart',$cart_data);
                $_SESSION['cart_my']=$cart_data;
	}

	
	










	//Alain Multiple Payments
	function get_payments_total()
	{
		$subtotal = 0;
		
		foreach($this->get_payments() as $payments)
		{
		    if($payments['payment_type']!='Due')
			{
			$subtotal+=$payments['payment_amount'];
			}
		}
		return to_currency_no_money($subtotal);
	}

	//Alain Multiple Payments
	function get_amount_due()
	{
		$amount_due=0;
		$payment_total = $this->get_payments_total();
		$sales_total=$this->get_total();
		$amount_due=to_currency_no_money($sales_total - $payment_total);
		return $amount_due;
	}

	function get_customer()
	{
		if(!$this->CI->session->userdata('customer'))
			$this->set_customer(-1);

		return $this->CI->session->userdata('customer');
	}

	function set_customer($customer_id)
	{
		$this->CI->session->set_userdata('customer',$customer_id);
		
		//print_r();
		
	}

	function get_mode()
	{
		if(!$this->CI->session->userdata('sale_mode'))
			$this->set_mode('sale');

		return $this->CI->session->userdata('sale_mode');
	}

	function set_mode($mode)
	{
		$this->CI->session->set_userdata('sale_mode',$mode);
	}

	function add_item($item_id,$quantity=1,$discount=0,$price=null,$description=null,$serialnumber=null)
	{
		@session_start();
                $this->get_cart();
                //make sure item exists
               
		if(!$this->CI->Item->exists($item_id))
		{
			//try to get item id given an item_number
			$item_id = $this->CI->Item->get_item_id($item_id);

			if(!$item_id)
				return false;
		}

            // echo $item_id;
		//Alain Serialization and Description

		//Get all items in the cart so far...
		$items = $_SESSION['cart_my'];

		//print_r($items);
		//echo "<br>";
        //We need to loop through all items in the cart.
        //If the item is already there, get it's key($updatekey).
        //We also need to get the next key that we are going to use in case we need to add the
        //item to the cart. Since items can be deleted, we can't use a count. we use the highest key + 1.

        $maxkey=0;                       //Highest key so far
               $itemalreadyinsale=FALSE;        //We did not find the item yet.
		$insertkey=0;                    //Key to use for new entry.
		$updatekey=0;                    //Key to use to update(quantity)
             // print_r($item);
		foreach ($items as $item)
		{
            //We primed the loop so maxkey is 0 the first time.
            //Also, we have stored the key in the element itself so we can compare.
               
			if($maxkey <$item['line'])
			{
				$maxkey = $item['line'];
			}

			if($item['item_id']==$item_id)
			{
				$itemalreadyinsale=TRUE;
				$updatekey=$item['line'];
			}
		}
             // print_r($items[$maxkey]);
			  $disc=$items[$maxkey]['discount'];
		$discount_c=($disc>0)?$disc:$disc=40;
		$quty=$items[$maxkey]['quantity'];
		$quantity_c=($quty>1)?$quty:$quty=1;
		$insertkey=$maxkey+1;
		//echo $maxkey;

		//array/cart records are identified by $insertkey and item_id is just another field.
		$item = array(($insertkey)=>
		array(
			'item_id'=>$item_id,
			'line'=>$insertkey,
			'name'=>$this->CI->Item->get_info($item_id)->name,
			'item_number'=>$this->CI->Item->get_info($item_id)->item_number,
			'description'=>$description!=null ? $description: $this->CI->Item->get_info($item_id)->description,
			'serialnumber'=>$serialnumber!=null ? $serialnumber: '',
			'allow_alt_description'=>$this->CI->Item->get_info($item_id)->allow_alt_description,
			'is_serialized'=>$this->CI->Item->get_info($item_id)->is_serialized,
			'quantity'=>($quantity==1)?$quantity:$quantity,//quantity_c
            'discount'=>($discount==0)?$discount_c:$discount,
			'price'=>$price!=null ? $price: $this->CI->Item->get_info($item_id)->unit_price
			)
		);
      
		//Item already exists and is not serialized, add to quantity
             	if($itemalreadyinsale && ($this->CI->Item->get_info($item_id)->is_serialized ==0) )
		{
                   
			$items[$updatekey]['quantity']+=$quantity;
		}
		else
		{
                      //print_r($items);
			//add to existing array
			 $items+=$item;
		}
              //print_r($items);
		$this->set_cart($items);
		

		return true;

	}
	function out_of_stock($item_id)
	{
		//make sure item exists
		if(!$this->CI->Item->exists($item_id))
		{
			//try to get item id given an item_number
			$item_id = $this->CI->Item->get_item_id($item_id);

			if(!$item_id)
				return false;
		}
		
		$item = $this->CI->Item->get_info($item_id);
		$quanity_added = $this->get_quantity_already_added($item_id);
		
		if ($item->quantity - $quanity_added < 0)
		{
			return true;
		}
		
		return false;
	}
	
	function get_quantity_already_added($item_id)
	{
		$items = $this->get_cart();
		$quanity_already_added = 0;
		foreach ($items as $item)
		{
			if($item['item_id']==$item_id)
			{
				$quanity_already_added+=$item['quantity'];
			}
		}
		
		return $quanity_already_added;
	}
	
	function get_item_id($line_to_get)
	{
		$items = $this->get_cart();

		foreach ($items as $line=>$item)
		{
			if($line==$line_to_get)
			{
				return $item['item_id'];
			}
		}
		
		return -1;
	}

	function edit_item($line,$description,$serialnumber,$quantity,$discount,$price)
	{
		$items = $this->get_cart();
		if(isset($items[$line]))
		{
			$items[$line]['description'] = $description;
			$items[$line]['serialnumber'] = $serialnumber;
			$items[$line]['quantity'] = $quantity;
			$items[$line]['discount'] = $discount;
			$items[$line]['price'] = $price;
			$this->set_cart($items);
		}

		return false;
	}
   /* function edit_item($line,$description,$serialnumber,$quantity,$discount,$price)
	{
		$items = $this->get_cart();
		if(isset($items[$line]))
		{
			$items[$line]['description'] = $description;
			$items[$line]['serialnumber'] = $serialnumber;
			$items[$line]['quantity'] = $quantity;
			$items[$line]['discount'] = $discount;
			$items[$line]['price'] = $price;
			$this->set_cart($items);
		}

		return false;
	}*/
	
	function is_valid_receipt($receipt_sale_id)
	{
		//POS #
		$pieces = explode(' ',$receipt_sale_id);

		if(count($pieces)==2)
		{
			return $this->CI->Sale->exists($pieces[1]);
		}

		return false;
	}
	
	function is_valid_item_kit($item_kit_id)
	{
		//KIT #
		$pieces = explode(' ',$item_kit_id);

		if(count($pieces)==2)
		{
			return $this->CI->Item_kit->exists($pieces[1]);
		}

		return false;
	}

	function return_entire_sale($receipt_sale_id)
	{
		//POS #
		$pieces = explode(' ',$receipt_sale_id);
		$sale_id = $pieces[1];

		$this->empty_cart();
		$this->remove_customer();

		foreach($this->CI->Sale->get_sale_items($sale_id)->result() as $row)
		{
			$this->add_item($row->item_id,-$row->quantity_purchased,$row->discount_percent,$row->item_unit_price,$row->description,$row->serialnumber);
		}
		$this->set_customer($this->CI->Sale->get_customer($sale_id)->person_id);
	}
	
	function add_item_kit($external_item_kit_id)
	{
		//KIT #
		$pieces = explode(' ',$external_item_kit_id);
		$item_kit_id = $pieces[1];
		
		foreach ($this->CI->Item_kit_items->get_info($item_kit_id) as $item_kit_item)
		{
			$this->add_item($item_kit_item['item_id'], $item_kit_item['quantity']);
		}
	}

	function copy_entire_sale($sale_id)
	{
		$this->empty_cart();
		$this->remove_customer();

		foreach($this->CI->Sale->get_sale_items($sale_id)->result() as $row)
		{
			
			//echo $row->item_id.''.$row->quantity_purchased.''.$row->discount_percent.''.$row->item_unit_price.''.$row->serialnumber.'<br/>';
			$this->add_item($row->item_id,$row->quantity_purchased,$row->discount_percent,$row->item_unit_price,$row->description,$row->serialnumber);
		}
		foreach($this->CI->Sale->get_sale_payments($sale_id)->result() as $row)
		{
			$this->add_payment($row->payment_type,$row->payment_amount);
		}
		$this->set_customer($this->CI->Sale->get_customer($sale_id)->person_id);

	}
	
	function copy_entire_suspended_sale($sale_id)
	{
		
                $this->empty_cart();
		$this->remove_customer();
           
		foreach($this->CI->Sale_suspended->get_sale_items($sale_id)->result() as $row)
		{
		
                $this->add_item($row->item_id,$row->quantity_purchased,$row->discount_percent,$row->item_unit_price,$row->description,$row->serialnumber);


                }
		foreach($this->CI->Sale_suspended->get_sale_payments($sale_id)->result() as $row)
		{
		
                        $this->add_payment($row->payment_type,$row->payment_amount);
		}
		$this->set_customer($this->CI->Sale_suspended->get_customer($sale_id)->person_id);
		$this->set_comment($this->CI->Sale_suspended->get_comment($sale_id));
	}

	function delete_item($line)
	{
		$items=$this->get_cart();
		
		unset($items[$line]);
		$this->set_cart($items);
	}

	function empty_cart()
	{
		$this->CI->session->unset_userdata('cart');
	}

	function remove_customer()
	{
		$this->CI->session->unset_userdata('customer');
	}

	function clear_mode()
	{
		$this->CI->session->unset_userdata('sale_mode');
	}
        function clear_cart_all()
        {
            $this->clear_mode();
            @session_start();
            unset($_SESSION['cart_my']);
            $this->clear_comment();
		$this->clear_email_receipt();
		$this->empty_payments();
		$this->remove_customer();
        }
	function clear_all()
	{
		$this->clear_mode();
		$this->empty_cart();
		$this->clear_comment();
		$this->clear_email_receipt();
		$this->empty_payments();
		$this->remove_customer();
	}

	function get_taxes()
	{
		$customer_id = $this->get_customer();
		$customer = $this->CI->Customer->get_info($customer_id);

		//Do not charge sales tax if we have a customer that is not taxable
		if (!$customer->taxable and $customer_id!=-1)
		{
		   return array();
		}

		$taxes = array();
		foreach($this->get_cart() as $line=>$item)
		{
			$tax_info = $this->CI->Item_taxes->get_info($item['item_id']);

			foreach($tax_info as $tax)
			{
				$name = $tax['percent'].'% ' . $tax['name'];
				$tax_amount=($item['price']*$item['quantity']-$item['price']*$item['quantity']*$item['discount']/100)*(($tax['percent'])/100);


				if (!isset($taxes[$name]))
				{
					$taxes[$name] = 0;
				}
				$taxes[$name] += $tax_amount;
			}
		}

		return $taxes;
	}
	function get_taxes_chalan($customer_id,$taxable,$all_item_pos)
	{
		$customer_id = $this->get_customer();
		$customer = $this->CI->Customer->get_info($customer_id);

		//Do not charge sales tax if we have a customer that is not taxable
		if (!$taxable and $customer_id!=-1)
		{
		   return array();
		}

		$taxes = array();
		foreach($all_item_pos->result() as $line=>$item)
		{
			$tax_info = $this->CI->Item_taxes->get_info($item->item_id);

			foreach($tax_info as $tax)
			{
				$name = $tax['percent'].'% ' . $tax['name'];
				$tax_amount=($item->item_unit_price*$item->quantity_purchased-$item->item_unit_price*$item->quantity_purchased*$item->discount_percent/100)*(($tax['percent'])/100);


				if (!isset($taxes[$name]))
				{
					$taxes[$name] = 0;
				}
				$taxes[$name] += $tax_amount;
			}
		}

		return $taxes;
	}

	function get_subtotal()
	{
		$subtotal = 0;
		foreach($this->get_cart() as $item)
		{
		    $subtotal+=($item['price']*$item['quantity']-$item['price']*$item['quantity']*$item['discount']/100);
		}
		return to_currency_no_money($subtotal);
	}
	function get_subtotal_chalan($all_item_pos)
	{
		$subtotal = 0;
		foreach($all_item_pos->result() as $line=>$item)
		{
		    $subtotal+=($item->item_unit_price*$item->quantity_purchased-$item->item_unit_price*$item->quantity_purchased*$item->discount_percent/100);
		}
		return to_currency_no_money($subtotal);
	}

	function get_total()
	{
		$total = 0;
		foreach($this->get_cart() as $item)
		{
            $total+=($item['price']*$item['quantity']-$item['price']*$item['quantity']*$item['discount']/100);
		}

		foreach($this->get_taxes() as $tax)
		{
			$total+=$tax;
		}

		return to_currency_no_money($total);
	}
	function get_total_chalan($taxes,$all_item_pos)
	{
		$total = 0;
		foreach($all_item_pos->result() as $line=>$item)
		{
            $total+=($item->item_unit_price*$item->quantity_purchased-$item->item_unit_price*$item->quantity_purchased*$item->discount_percent/100);
		}

		foreach($taxes as $tax)
		{
			$total+=$tax;
		}

		return to_currency_no_money($total);
	}
        function convertToBanglaNumber($englishNumber)
		{
			$englishNumber = (string) $englishNumber;
			$banglaNumber = '';
			$indexLimit = strlen($englishNumber);
			for($i=0; $i<$indexLimit; $i++)
			{
				switch($englishNumber[$i])
				{
					case "0":
						$banglaNumber .= '০';
						break;
					case "1":
						$banglaNumber .= '১';
						break;
					case "2":
						$banglaNumber .= '২';
						break;
					case "3":
						$banglaNumber .= '৩';
						break;
					case "4":
						$banglaNumber .= '৪';
						break;
					case "5":
						$banglaNumber .= '৫';
						break;
					case "6":
						$banglaNumber .= '৬';
						break;
					case "7":
						$banglaNumber .= '৭';
						break;
					case "8":
						$banglaNumber .= '৮';
						break;
					case "9":
						$banglaNumber .= '৯';
						break;
					default:
						$banglaNumber .= $englishNumber[$i];
						break;
				}
			}
			return $banglaNumber;
		}
}
?>