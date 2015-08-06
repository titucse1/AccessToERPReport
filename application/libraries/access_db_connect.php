<?php
class CI_Access_Db_Connect {
    
        var $dbh='';
        var $fiscal_year='';
    	var $CI;

  	function __construct()
	{
		$this->CI =& get_instance();
	
     //$this->dbh = new PDO("odbc:Driver={Microsoft Access Driver (*.mdb)};Dbq=D:\\temp_ac5f6ab512afdf9d852577ae002ce$\\be_main_12_13.mdb;Uid=Admin");
       //$this->dbh =  new PDO("odbc:Driver={Microsoft Access Driver (*.mdb)};Dbq=D:\\temp_ac5f6ab512afdf9d852577ae002ce$\\be_general_db_14_15.mdb;Uid=Admin");
       $this->dbh =  new PDO("odbc:Driver={Microsoft Access Driver (*.mdb)};Dbq=D:\\FY2015-16_general_be.mdb;Uid=Admin");

       $this->fiscal_year="2015-2016";
	//server5\wamp\www
    }

    function query($string) {
        
        try { 
		
            return $this->dbh->query($string);
        }
        catch(PDOException $e) {
            echo $e->getMessage();
        }
    }
	
    function exec($str) {
        try{
			$this->dbh->query("SET NAMES 'UTF8'");
			$this->dbh->query("SET client_encoding='UTF-8'");
		
        return $this->dbh->exec($str);
          }
        catch(PDOException $e) {
            echo $e->getMessage();
        }

    }
    function fetch_single($str) {
        return $this->dbh->query($str);


    }
    function clear_query() {
        $this->dbh=null;

    }
    

    
}

class LibraryCalculation extends CI_Access_Db_Connect
{
    var $last_year_balance;
	var $Project_Bonus;
	var $Somonnoy_Balance;
	
	var $General_Book_Transection_Amount;
    var $Text_Book_Transection_Amount;
    var $Quantity_Basis_Book_Amount;
	var $None_Basis_Book_Amount=0;
	var $Chalan_Discount_Amount=0;
	var $Return_Discount_Amount;
	var $Book_Packing_Cost;
	
	var $Net_Deposit_Amount;
	var $Net_OD_Deposit_Amount;

	var $General_Book_Bonus_Amount;
	var $Text_Book_Bonus_Amount;
	var $Quantity_Basis_Bonus_Amount;

	
    //var $total_chalan_qty;
    //var $average_bonus;
    //var $totalChalanQty;
	
	
 function libraryDetails($library_code)
    {
		$libdetails=array();
		$qstr="SELECT [Library Info].[Library Code], [Library Info].[Library Name], [Library Info].[Library Address], [Library Info].[Library AddressB], [Thana Info].[Thana Name], [Zilla Info].[Zilla Name], [Zilla Info].Division
		FROM ([Library Info] INNER JOIN [Thana Info] ON [Library Info].[Thana Code] = [Thana Info].[Thana Code]) INNER JOIN [Zilla Info] ON [Library Info].[Zilla Code] = [Zilla Info].[Zilla Code]
		Where [Library Info].[Library Code]='".$library_code."'";
		$library_details=$this->dbh->query($qstr);
		foreach($library_details as $library_details)
			{
			$libdetails[$library_details["Library Code"]]['LibCode']=$library_details["Library Code"];
			$libdetails[$library_details["Library Code"]]['LibName']=$library_details["Library Name"];
			$libdetails[$library_details["Library Code"]]['LibAddress']=$library_details["Library Address"];
			$libdetails[$library_details["Library Code"]]['Zilla']=$library_details["Zilla Name"];
			$libdetails[$library_details["Library Code"]]['Thana']=$library_details["Thana Name"];
			$libdetails[$library_details["Library Code"]]['Division']=$library_details["Division"];
			}
		return $libdetails[$library_code];
    }
	
	
 function get_Amount_Basis_General_Bonus($library_code) {
        $chalan_array=array();
        $return_array=array();
		$chalan_library_string="SELECT * FROM (SELECT Sum([Order Chalan Details].[Book Supply Qty]) AS CBookQty,BookType,  Sum(Total_Price) AS CPrice, Sum(bonus) AS TotalBonus
		FROM (SELECT [Library Info].[Library Code], [Book Information].[Book Type]as BookType, [Order Chalan Details].[Book Supply Qty], [Book Information].[Book Code],
		[Book Information].[Book Name], [Book Information].[Book Price], ([Order Chalan Details].[Book Supply Qty]*[Book Information].[Book Price]) AS Total_Price, (([Book Information].BonusFactor*[Book Information].[Book Price])/100)*[Order Chalan Details].[Book Supply Qty] AS bonus,
		[Book Information].[BonusFactor] FROM (([Library Info] INNER JOIN [Order Chalan Info] ON [Library Info].[Library Code]=[Order Chalan Info].[Library Code]) INNER JOIN [Order Chalan Details] ON [Order Chalan Info].[Order No]=[Order Chalan Details].[Order No])
		INNER JOIN [Book Information] ON [Order Chalan Details].[Book Code]=[Book Information].[Book Code] WHERE [Library Info].[Library Code]='$library_code' )
		GROUP BY BookType) AS A inner  JOIN [Book Type Information] as B ON A.BookType = B.[Book Type]";
		
		$library_wise_chalan=$this->dbh->query($chalan_library_string);
		foreach($library_wise_chalan as $library_wise_chalan ) 
			{
			$chalan_array[$library_wise_chalan['Book Type Name']]['Bookqty']=$library_wise_chalan['CBookQty'];
			$chalan_array[$library_wise_chalan['Book Type Name']]['BookType']=$library_wise_chalan['Book Type Name'];
			$chalan_array[$library_wise_chalan['Book Type Name']]['CPrice']=$library_wise_chalan['CPrice'];
			$chalan_array[$library_wise_chalan['Book Type Name']]['CTotalBonus']=$library_wise_chalan['TotalBonus'];
			}
		
		$return_library_wise_string="SELECT * FROM(SELECT [Book Information].[Book Type] AS Expr1, Sum([Return Book Received Details].[Book Return Qty]) AS ReturnQty,
		Sum(Return_Amount) AS Ramount, Sum(Rbonus) AS ReturnBonus, [Book Type Information].[Book Type Name]
		FROM (SELECT [Library Info].[Library Code], [Return Book Received Details].[Book Code], [Return Book Received Details].[Book Return Qty],
		[Book Information].[Book Price], ([Return Book Received Details].[Book Return Qty]*[Book Information].[Book Price]) AS Return_Amount, [Book Information].[Book Type],
		(([Book Information].BonusFactor*[Book Information].[Book Price])/100)*[Return Book Received Details].[Book Return Qty] AS Rbonus FROM (([Library Info]
		INNER JOIN [Return Book Received Info] ON [Library Info].[Library Code]=[Return Book Received Info].[Library Code]) INNER JOIN [Return Book Received Details] ON [Return Book Received Info].[Return Slip No]=[Return Book Received Details].[Return Slip No])
		INNER JOIN [Book Information] ON [Return Book Received Details].[Book Code]=[Book Information].[Book Code]
		WHERE ((([Library Info].[Library Code])='".$library_code."')))  AS A
		INNER JOIN [Book Type Information] ON A.[Book Type] = [Book Type Information].[Book Type]
		GROUP BY [Book Information].[Book Type], [Book Type Information].[Book Type Name]) AS B
		";
		$library_wise_return=$this->dbh->query($return_library_wise_string);
		foreach($library_wise_return as $library_wise_return ) 
			{
			$chalan_array[$library_wise_return['Book Type Name']]['ReturnQty']=$library_wise_return['ReturnQty'];
			$chalan_array[$library_wise_return['Book Type Name']]['Rprice']=$library_wise_return['Ramount'];
			$chalan_array[$library_wise_return['Book Type Name']]['RBookType']=$library_wise_return['Book Type Name'];
			$chalan_array[$library_wise_return['Book Type Name']]['RTotalBonus']=$library_wise_return['ReturnBonus'];
			}
		ksort($chalan_array);
		return $chalan_array;
    }
	
	
   
 function get_library_details_with_chalan_return_deposit($library_code)
    {
        $this->last_year_balance=0;
		$return_chalan_info=array();
		$qstr="SELECT [Sub Account info].[Opening Balance]
		FROM [Library Info] INNER JOIN [Sub Account info] ON [Library Info].[Account Code] = [Sub Account info].[Account Code]
		WHERE ((([Library Info].[Library Code])='".$library_code."'))";
		$year_balance=$this->dbh->query($qstr);
		foreach($year_balance as $balance)
			{
			$dsfdsfdsfsdf=$balance;
			}
			$this->last_year_balance=$dsfdsfdsfsdf['Opening Balance'];
			
		$this->Project_Bonus=0;
		$this->Somonnoy_Balance=0;

		
		$return_chalan_info=array();
		$qstr="SELECT A.[Chalan Date], A.[Chalan No],A.[Packing Cost], Sum(A.BookPrice) AS Price
		FROM (SELECT [Order Chalan Info].[Library Code], [Order Chalan Info].[Chalan Date], [Order Chalan Info].[Chalan No], [Order Chalan Info].[Packing Cost], [Order Chalan Details].[Book Supply Qty], [Book Information].[Book Code], [Book Information].Edition, [Book Information].[Book Price], ([Book Information].[Book Price]* [Order Chalan Details].[Book Supply Qty]) as BookPrice,(([Book Information].BonusFactor*[Book Information].[Book Price])/100)*[Order Chalan Details].[Book Supply Qty] AS bonus
		FROM ([Order Chalan Info] INNER JOIN [Order Chalan Details] ON [Order Chalan Info].[Order No] = [Order Chalan Details].[Order No]) INNER JOIN [Book Information] ON [Order Chalan Details].[Book Code] = [Book Information].[Book Code]
		WHERE ((([Order Chalan Info].[Library Code])='".$library_code."'))
		ORDER BY [Order Chalan Info].[Chalan Date] DESC , [Order Chalan Info].[Chalan No])  AS A
		GROUP BY A.[Chalan Date], A.[Chalan No],A.[Packing Cost]
		ORDER BY A.[Chalan Date] DESC";
		$chalan_details=$this->dbh->query($qstr);
		foreach($chalan_details as $chalan_detail)
			{
			$chalan_info[]=$chalan_detail;
			}
			
		$pp=0;
		foreach($chalan_info as $chalan)
			{
			$return_chalan_info[$pp]['Date']=$chalan['Chalan Date'];
			$return_chalan_info[$pp]['Memo No']=$chalan['Chalan No'];
			$return_chalan_info[$pp]['Packing Cost']=$chalan['Packing Cost'];
			$return_chalan_info[$pp]['Price']=$chalan['Price'];
			$pp++;
			}


		$return_return_info=array();
		$qstr="SELECT A.[Return Date], A.[Return Slip No], Sum(A.BookPrice) AS Price, A.[Return Discount],(Price-A.[Return Discount]) as FbookPrice , A.InternalMemo 
		FROM (SELECT [Return Book Received Info].[Return Date], [Return Book Received Info].[Return Discount], [Return Book Received Details].[Return Slip No], [Book Information].[Book Code], [Book Information].Edition, [Book Information].[Book Price], [Return Book Received Details].[Book Return Qty], [Book Information].BonusFactor, [Return Book Received Info].[Library Code], ([Book Information].[Book Price]*[Return Book Received Details].[Book Return Qty]) AS BookPrice, [Return Book Received Info].InternalMemo
AS InternalMemo FROM ([Return Book Received Info] INNER JOIN [Return Book Received Details] ON [Return Book Received Info].[Return Slip No] = [Return Book Received Details].[Return Slip No]) INNER JOIN [Book Information] ON [Return Book Received Details].[Book Code] = [Book Information].[Book Code]
GROUP BY [Return Book Received Info].[Return Date], [Return Book Received Info].[Return Discount], [Return Book Received Details].[Return Slip No], [Book Information].[Book Code], [Book Information].Edition, [Book Information].[Book Price], [Return Book Received Details].[Book Return Qty], [Book Information].BonusFactor, [Return Book Received Info].[Library Code], [Return Book Received Info].InternalMemo
HAVING ((([Return Book Received Info].[Library Code])='".$library_code."'))
ORDER BY [Return Book Received Info].[Return Date] DESC , [Return Book Received Details].[Return Slip No])  AS A
		GROUP BY A.[Return Date], A.[Return Slip No], A.[Return Discount], A.InternalMemo 
		ORDER BY A.[Return Date] DESC";
		$return_details=$this->dbh->query($qstr);
		foreach($return_details as $return_detail)
			{
			$return_info[]=$return_detail;
			}
			
		$pp=0;
		foreach($return_info as $return)
			{
			$return_return_info[$pp]['Date']=$return['Return Date'];
			$return_return_info[$pp]['Memo No']=$return['Return Slip No'];
			$return_return_info[$pp]['Return Discount']=$return['Return Discount'];
			$return_return_info[$pp]['Price']=$return['FbookPrice'];
			$return_return_info[$pp]['Internal']=$return['InternalMemo'];
			$pp++;
			}

		$return_deposit_info=array();
		$qstr="SELECT [Deposit info].[Deposit Date], [Deposit info].[Deposit Slip No], [Deposit info].[Deposit Type], [Deposit info].[Deposit Amount]
		FROM [Deposit info]
		WHERE ((([Deposit info].[Library code])='".$library_code."'))
		ORDER BY [Deposit info].[Deposit Date] DESC , [Deposit info].[Deposit Slip No]";
		$deposit_details=$this->dbh->query($qstr);
		foreach($deposit_details as $deposit_detail)
			{
			$deposit_info[]=$deposit_detail;
			}
		
		$pp=0;
		foreach($deposit_info as $deposit)
			{
			$return_deposit_info[$pp]['Date']=$deposit['Deposit Date'];
			$return_deposit_info[$pp]['Memo No']=$deposit['Deposit Slip No'];
			$return_deposit_info[$pp]['Type']=$deposit['Deposit Type'];
			$return_deposit_info[$pp]['Price']=$deposit['Deposit Amount'];
			$pp++;
			}
	
	
	return array($return_chalan_info, $return_return_info, $return_deposit_info);
		
    }
	
	
	
	
function get_Amount_basis_Text_book_Bonus($library_code='')
	{
		$text_book_array=array();
		$return_array=array();
		
		$textbook=array();
		$sql="SELECT [Book Information].[Book Name] AS BookName, SUM(Supqty) AS chalanqty, SUM(Total_Price) AS TotalPrice, SUM(bonus) AS Cbonus, [Edition]
		FROM (SELECT [Library Info].[Library Code], [Book Information].[Book Type], [Order Chalan Details].[Book Supply Qty] as Supqty, [Book Information].[Book Code], [Book Information].[Book Name], [Book Information].[Book Price], ([Order Chalan Details].[Book Supply Qty]*[Book Information].[Book Price]) AS Total_Price, (([Book Information].BonusFactor*[Book Information].[Book Price])/100)*[Order Chalan Details].[Book Supply Qty] AS bonus, [Book Information].BonusFactor, [Book Information].Edition as Edition
		FROM (([Library Info] INNER JOIN [Order Chalan Info] ON [Library Info].[Library Code] = [Order Chalan Info].[Library Code]) INNER JOIN [Order Chalan Details] ON [Order Chalan Info].[Order No] = [Order Chalan Details].[Order No]) INNER JOIN [Book Information] ON [Order Chalan Details].[Book Code] = [Book Information].[Book Code]
		WHERE ((([Library Info].[Library Code])='".$library_code."') AND (([Book Information].[Book Type])='R'))) 
		GROUP BY [Book Information].[Book Name], Edition";
		$textbook_details=$this->dbh->query($sql);
		foreach($textbook_details as $textbook_single)
			{
			$textbook[]=$textbook_single;
			}
		$text_book_array=$textbook;
	   
	   
		$return=array();
		$sql="SELECT [Return Book Received Details].[Book Code], [Return Book Received Details].[Book Return Qty], [Book Information].[Book Name], [Book Information].Edition
		FROM (([Return Book Received Info] INNER JOIN [Return Book Received Details] ON [Return Book Received Info].[Return Slip No] = [Return Book Received Details].[Return Slip No]) INNER JOIN [Book Information] ON [Return Book Received Details].[Book Code] = [Book Information].[Book Code]) INNER JOIN [Book Type Information] ON [Book Information].[Book Type] = [Book Type Information].[Book Type]
		WHERE ((([Return Book Received Info].[Library Code])='".$library_code."') AND (([Book Type Information].[Book Type])='R'))
		ORDER BY [Book Information].[Book Name];
		";
		$return_details=$this->dbh->query($sql);
		foreach($return_details as $return_single)
			{
			$return[]=$return_single;
			}
		
		$pp=0;
		foreach($textbook as $book)
			{
			$book['BookName'];
				foreach($return as $ret)
				{
					$text_book_array[$pp]['return']=0;
					if($book['BookName'].$book['Edition']==$ret['Book Name'].$ret['Edition'])
					{
					$text_book_array[$pp]['return']=$ret['Book Return Qty'];
					break;
					}
				}
			$pp++;
			}
			
			
			
		$pp=0;
		foreach($text_book_array as $book)
			{
			$return_array[$pp]['Book Name']=$book['BookName'];
			$return_array[$pp]['Edition']=$book['Edition'];
			$return_array[$pp]['Chalan']=$book['chalanqty'];
			$return_array[$pp]['Return']=$book['return'];
			$return_array[$pp]['Actual Sell']=($book['chalanqty']-$book['return']);
			$return_array[$pp]['Price']=($book['TotalPrice']/$book['chalanqty']);
			$return_array[$pp]['Sell Amount']=($book['chalanqty']-$book['return'])*($book['TotalPrice']/$book['chalanqty']);
			$return_array[$pp]['Bonus']=($book['Cbonus']/$book['TotalPrice'])*100;
			$return_array[$pp]['Bonus Amount']=($book['Cbonus']/$book['chalanqty'])*($book['chalanqty']-$book['return']);

			$pp++;
			}
		return $return_array;
		
	} //End of function get_Text_book_Bonus()
	

function get_return_Discount_Statement($library_code='')
	{ 
		$return_Discount_Statement=array();
		$qstr="SELECT A.[Return Date], A.[Return Slip No], Sum(A.BookPrice) AS Price, A.[Return Discount],(Price-A.[Return Discount]) as FbookPrice, A.[Return Remarks] as Remarks
		FROM (SELECT [Return Book Received Info].[Return Date], [Return Book Received Info].[Return Discount], [Return Book Received Details].[Return Slip No], [Book Information].[Book Code], [Book Information].Edition, [Book Information].[Book Price], [Return Book Received Details].[Book Return Qty], [Book Information].BonusFactor, [Return Book Received Info].[Library Code], ([Book Information].[Book Price]*[Return Book Received Details].[Book Return Qty]) AS BookPrice, [Return Book Received Info].[Return Remarks]
		FROM ([Return Book Received Info] INNER JOIN [Return Book Received Details] ON [Return Book Received Info].[Return Slip No] = [Return Book Received Details].[Return Slip No]) INNER JOIN [Book Information] ON [Return Book Received Details].[Book Code] = [Book Information].[Book Code]
		GROUP BY [Return Book Received Info].[Return Date], [Return Book Received Info].[Return Discount], [Return Book Received Details].[Return Slip No], [Book Information].[Book Code], [Book Information].Edition, [Book Information].[Book Price], [Return Book Received Details].[Book Return Qty], [Book Information].BonusFactor, [Return Book Received Info].[Library Code], [Return Book Received Info].[Return Remarks]
		HAVING ((([Return Book Received Info].[Library Code])='".$library_code."') AND (([Return Book Received Info].[Return Discount])>0))
		ORDER BY [Return Book Received Info].[Return Date] DESC , [Return Book Received Details].[Return Slip No])  AS A
		GROUP BY A.[Return Date], A.[Return Slip No], A.[Return Discount], A.[Return Remarks]
		ORDER BY A.[Return Date] ASC ";
		$Discount_Statement=$this->dbh->query($qstr);
		foreach($Discount_Statement as $Discount)
			{
			$returnDiscount[]=$Discount;
			}
			
		$pp=0;
		foreach($returnDiscount as $return)
			{
			$return_Discount_Statement[$pp]['Return Slip No']=$return['Return Slip No'];
			$return_Discount_Statement[$pp]['Return Date']=$return['Return Date'];
			$return_Discount_Statement[$pp]['Discount Amount']=$return['Return Discount'];
			$return_Discount_Statement[$pp]['Discount Details']=$return['Remarks'];
			$pp++;
			}
		return $return_Discount_Statement;
	}
	
	
function get_quantity_basis_Book_bonus($library_code='')
	{ 
		$return_quantity_basis_Book_bonus=array();
		$quantity_basis_Book_bonus=array();
		$quantity_basis_Book_return=array();
		$total_book=array();
		$qstr=	" SELECT P.[Book Name] AS BookName, SUM(P.Supqty) AS chalanqty, SUM(P.Total_Price) AS TotalPrice, SUM(P.bonus) AS Cbonus, P.[Edition], P.NetPrice 
		FROM (SELECT [Library Info].[Library Code], [Book Information].[Book Type], [Order Chalan Details].[Book Supply Qty] as Supqty, [Book Information].[Book Code], [Book Information].[Book Name], [Book Information].[Book Price] as NetPrice, ([Order Chalan Details].[Book Supply Qty]*[Book Information].[Book Price]) AS Total_Price, (([Book Information].BonusFactor*[Book Information].[Book Price])/100)*[Order Chalan Details].[Book Supply Qty] AS bonus, [Book Information].BonusFactor, [Book Information].Edition as Edition
		FROM (([Library Info] INNER JOIN [Order Chalan Info] ON [Library Info].[Library Code] = [Order Chalan Info].[Library Code]) INNER JOIN [Order Chalan Details] ON [Order Chalan Info].[Order No] = [Order Chalan Details].[Order No]) INNER JOIN [Book Information] ON [Order Chalan Details].[Book Code] = [Book Information].[Book Code]
		WHERE ((([Library Info].[Library Code])='".$library_code."')  AND  [Book Information].[Book Name] LIKE '10:TP%' AND (([Book Information].[Book Type])='Y'))) AS P
		GROUP BY P.[Book Name], P.Edition, P.NetPrice ORDER BY P.[Book Name], P.Edition";
		$Book_bonus=$this->dbh->query($qstr);
		$basis_Book_bonus=array();
		foreach($Book_bonus as $bonus)
			{
			$basis_Book_bonus[]=$bonus;
			}
		$pp=0;
			foreach($basis_Book_bonus as $bonus)
			{
			$quantity_basis_Book_bonus[$pp]['Book Name']=$bonus['BookName'];
			$quantity_basis_Book_bonus[$pp]['Edition']=$bonus['Edition'];
			$quantity_basis_Book_bonus[$pp]['Chalan']=$bonus['chalanqty'];
			$quantity_basis_Book_bonus[$pp]['Price']=$bonus['TotalPrice'];
			$quantity_basis_Book_bonus[$pp]['NetPrice']=$bonus['NetPrice'];
			$quantity_basis_Book_bonus[$pp]['Bonus']=$bonus['Cbonus'];
			$total_book[]=$bonus['BookName'].$bonus['Edition'];
			$pp++;
			}
		
		
		
		
		$qstr="SELECT A.Librarycode, A.[Book Name] as BookName , Sum(A.[Book Return Qty]) AS TotalQty, Sum(A.BookPrice) AS BookTotalPrice, Sum(A.Bonus) AS TotalBonus,A.BonusFactor, A.Edition,A.NetPrice
		FROM (SELECT [Return Book Received Info].[Library Code] as Librarycode, [Return Book Received Details].[Return Slip No], [Return Book Received Details].[Book Code], [Return Book Received Details].[Book Return Qty], [Book Information].[Book Name], [Book Information].[Book Type], [Book Information].Edition, [Book Information].[Book Price] as NetPrice, [Book Information].BonusFactor, [Book Type Information].[Book Type Name], ([Book Information].[Book Price]* [Return Book Received Details].[Book Return Qty]) AS BookPrice,((([Book Information].BonusFactor*[Book Information].[Book Price])/100)*[Return Book Received Details].[Book Return Qty]) AS Bonus
		FROM (([Return Book Received Info] INNER JOIN [Return Book Received Details] ON [Return Book Received Info].[Return Slip No] = [Return Book Received Details].[Return Slip No]) INNER JOIN [Book Information] ON [Return Book Received Details].[Book Code] = [Book Information].[Book Code]) INNER JOIN [Book Type Information] ON [Book Information].[Book Type] = [Book Type Information].[Book Type]
		WHERE ((([Return Book Received Info].[Library Code])='".$library_code."') AND (([Book Information].[Book Type])='Y')))  AS A
		WHERE (((A.[Book Name]) Like '10:TP%'))
		GROUP BY A.Librarycode, A.[Book Name], A.Edition,A.BonusFactor,A.NetPrice 
		ORDER BY A.[Book Name]";
		$Book_return=$this->dbh->query($qstr);
		$basis_Book_return=array();
		foreach($Book_return as $return)
			{
			$basis_Book_return[]=$return;
			}
		$pp=0;
			foreach($basis_Book_return as $return)
			{
			$quantity_basis_Book_return[$pp]['Book Name']=$return['BookName'];
			$quantity_basis_Book_return[$pp]['Edition']=$return['Edition'];
			$quantity_basis_Book_return[$pp]['Return']=$return['TotalQty'];
			$quantity_basis_Book_return[$pp]['NetPrice']=$return['NetPrice'];
			$quantity_basis_Book_return[$pp]['Factor']=$return['BonusFactor'];
			if(!in_array($return['BookName'].$return['Edition'],$total_book))
			$total_book[]=$return['BookName'].$return['Edition'];
			$pp++;
			}
			sort($total_book);
			
			$pp=0;
			$data_array=array();
			foreach($total_book as $book)
			{
				foreach($quantity_basis_Book_bonus as $bonus)
				{
					if($book==$bonus['Book Name'].$bonus['Edition'])
					{
					$data_array[$pp]['Book Name']=$bonus['Book Name'];
					$data_array[$pp]['Edition']=$bonus['Edition'];
					$data_array[$pp]['Chalan']=$bonus['Chalan'];
					$data_array[$pp]['Return']=0;
					$data_array[$pp]['Price']=$bonus['NetPrice'];
					$data_array[$pp]['Factor']=0;
					}
				}
				
				foreach($quantity_basis_Book_return as $return)
				{
					if($book==$return['Book Name'].$return['Edition'])
					{
					$data_array[$pp]['Book Name']=$return['Book Name'];
					$data_array[$pp]['Edition']=$return['Edition'];
					if(!isset($data_array[$pp]['Chalan']))
					$data_array[$pp]['Chalan']=0;
					$data_array[$pp]['Return']=$return['Return'];
					$data_array[$pp]['Price']=$return['NetPrice'];
					$data_array[$pp]['Factor']=$return['Factor'];
					}
				}
			$pp++;
			}
		
		$pp=0;
		foreach($data_array as $data)
		{
		$return_quantity_basis_Book_bonus[$pp]['Book Name']=$data['Book Name'];
		$return_quantity_basis_Book_bonus[$pp]['Edition']=$data['Edition'];
		$return_quantity_basis_Book_bonus[$pp]['Chalan']=$data['Chalan'];
		$return_quantity_basis_Book_bonus[$pp]['Return']=$data['Return'];
		$return_quantity_basis_Book_bonus[$pp]['Actual Sell']=$data['Chalan']-$data['Return'];
		$return_quantity_basis_Book_bonus[$pp]['Price']=$data['Price'];
		$return_quantity_basis_Book_bonus[$pp]['Sell Amount']=($data['Chalan']-$data['Return'])*$data['Price'];
		$return_quantity_basis_Book_bonus[$pp]['Factor']=$data['Factor'];
		$return_quantity_basis_Book_bonus[$pp]['Bonus']=$data['Factor']*($data['Chalan']-$data['Return']);
		$pp++;
		}
		return $return_quantity_basis_Book_bonus;
	}


function make_table_library($lib=array(),$title)
	{
		
		
		start_table(TABLESTYLE, "width=950px");
		$th = array(_($title.$this->fiscal_year));
		inactive_control_column($th);//_("Districts"),_("Division")
		table_header($th,"colspan='6' style='font-size:16px; padding:10px;'");
		$th2 = array(_("Lecture Publications Ltd"),_("37,Banglabazar, Dhaka-1100"));
		table_header($th2,"colspan='3'");
			start_row();
			label_cell(_("Library Code"), 'style=" background:#EEEEEE;"');
			label_cell($lib['LibCode']);
			label_cell(_("Library Name"), 'style=" background:#EEEEEE;"');
			label_cell($lib["LibName"]);
			label_cell(_("Library Address"), 'style=" background:#EEEEEE;"');
			label_cell($lib["LibAddress"]);
			end_row();
			start_row();
			label_cell(_("Thana "), 'style=" background:#EEEEEE;"');
			label_cell($lib['Thana']);
			label_cell(_("Zilla"), 'style=" background:#EEEEEE;"');
			label_cell($lib["Zilla"]);
			label_cell(_("Division"), 'style=" background:#EEEEEE;"');
			label_cell($lib["Division"]);
			end_row();
		
		end_table();
	}
	
	
function make_table_amount_Basis_General_Bonus($amount_Basis_General_Bonus=array())
	{	
		start_table(TABLESTYLE, "width=950px");
		$th = array(_("Book Type Name"),_("Chalan Qty"),_("Return Qty"),_("Actual Sell Qty"),_("Sell Amount"),_("Bonus Amount"),_("Bonus %"));
		inactive_control_column($th);//_("Districts"),_("Division")
		table_header($th);
		$l=0;
		$total_chalan=0;
		$total_return=0;
		$total_sell_qty=0;
		$total_sell_amount=0;
		$total_bonus_amount=0;
		$total_percentage=0;
		
		$this->General_Book_Bonus_Amount=0;
		foreach($amount_Basis_General_Bonus as $myrow) {
		
		if($myrow["BookType"]!='Text Book' && $myrow["BookType"]!='System Default')
			{
            $l++;
			alt_table_row_color($k);
			label_cell($myrow["BookType"]);
			$total_chalan+=$myrow["Bookqty"];
			label_cell(number_format($myrow["Bookqty"], 0, '.', ''), 'style="text-align:right;"');
			$total_return+=$myrow["ReturnQty"];
			label_cell(number_format($myrow["ReturnQty"], 0, '.', ''), 'style="text-align:right;"');
			$actQty=$myrow["Bookqty"]-$myrow["ReturnQty"];
			$total_sell_qty+=$actQty;
			label_cell(number_format($actQty, 0, '.', ''), 'style="text-align:right;"');
			$actQty=0;
			$actual_price=$myrow["CPrice"]-$myrow["Rprice"];
			label_cell(number_format($actual_price, 2, '.', ''), 'style="text-align:right;"');
			$total_sell_amount+=$actual_price;
			$total_bonus=$myrow["CTotalBonus"]-$myrow["RTotalBonus"];
			label_cell(number_format($total_bonus, 2, '.', ''), 'style="text-align:right;"');
			$total_bonus_amount+=$total_bonus; 
			$percentage=($total_bonus/$actual_price)*100;
			$total_bonus=0;
			$actual_price=0;
			label_cell(number_format($percentage, 2, '.', ''), 'style="text-align:right;"');

			
			$total_percentage+=$percentage;
			$percentage=0;
			end_row();
			}
		
		}
		$overall_percentage=($total_bonus_amount*100/$total_sell_amount);
		echo $footer='<tr>
		<td style="text-align:right;"><b>Total Qty/Amount</b></td>
		<td style="text-align:right;"><b>'.$total_chalan.'</b></td>
		<td style="text-align:right;"><b>'.$total_return.'</b></td>
		<td style="text-align:right;"><b>'.$total_sell_qty.'</b></td>
		<td style="text-align:right;"><b>'.number_format($total_sell_amount, 2, '.', '').'</b></td>
		<td style="text-align:right;"><b>'.number_format($total_bonus_amount, 2, '.', '').'</b></td>
		<td style="text-align:right;"><b>'.number_format($overall_percentage, 2, '.', '').'</b></td>
		
		</tr>';
		$l=0;
		//inactive_control_row($th);
		end_table();
		echo '<br/>';
		
		$this->General_Book_Transection_Amount=$total_sell_amount;
		$this->General_Book_Bonus_Amount=$total_bonus_amount;
	}

function table1($all_chalan)
{
		$this->Book_Packing_Cost=0;
		$html='';
		$pp=0;
		foreach($all_chalan as $chalan)
		{
		
		$class='oddrow';
		if($pp%2==0)
		$class='evenrow';
		$html.= '<tr class="'.$class.'">';
		$html.= '<td>'.date("d/m/Y",strtotime($chalan['Date'])).'</td>';
		$html.= '<td>'.$chalan['Memo No'].'</td>';
		$html.= '<td style="text-align:right;">'.number_format($chalan['Packing Cost'], 2, '.', '').'</td>';
		$html.= '<td style="text-align:right;">'.number_format($chalan['Price'], 2, '.', '').'</td>';
		$html.= '</tr>';
		$pp++;
		$this->Book_Packing_Cost+=$chalan['Packing Cost'];
		//if($pp==90)break;
		}
		return $html;
	}
function table2($all_return)
{
		$html='';
		$pp=0;
		foreach($all_return as $return)
		{
		$class='oddrow';
		if($pp%2==0)
		$class='evenrow';
		$html.= '<tr class="'.$class.'">';
		$html.= '<td>'.date("d/m/Y",strtotime($return['Date'])).'</td>';
		$html.= '<td>'.$return['Memo No'].'</td>';
		$html.= '<td style="text-align:right;">'.number_format($return['Price'], 2, '.', '').'</td>';
		$html.= '</tr>';
		$pp++;
		}
		return $html;
	}
function table3($all_deposit)
{
		$html='';
		$pp=0;
		$this->Net_Deposit_Amount=0;
	    $this->Net_OD_Deposit_Amount=0;
	
		foreach($all_deposit as $deposit)
		{
		$class='oddrow';
		if($pp%2==0)
		$class='evenrow';
		$html.= '<tr class="'.$class.'">';
		$html.= '<td>'.date("d/m/Y",strtotime($deposit['Date'])).'</td>';
		$html.= '<td>'.$deposit['Memo No'].'</td>';
		$html.= '<td style="text-align:center;" >'.$deposit['Type'].'</td>';
		$html.= '<td style="text-align:right;">'.number_format($deposit['Price'], 2, '.', '').'</td>';
		$html.= '</tr>';
		$pp++;
		if(strtolower($deposit['Type'])=='od')
		$this->Net_OD_Deposit_Amount+=$deposit['Price'];
		$this->Net_Deposit_Amount+=$deposit['Price'];
		}
		return $html;
	}
function make_table_library_details_with_chalan_return_deposit($library_details_with_chalan_return_deposit=array())
	{
		$all_chalan=$library_details_with_chalan_return_deposit[0];
		$all_return=$library_details_with_chalan_return_deposit[1];
		$all_deposit=$library_details_with_chalan_return_deposit[2];
		
		$total_chalan=0;
		$total_pack_cost=0;
		foreach($all_chalan as $chalan)
		{
			$total_chalan+=$chalan['Price'];
			$total_pack_cost+=$chalan['Packing Cost'];
		}
		$internal_return=0;
		$total_return=0;
		foreach($all_return as $return)
		{
			if($return['Internal']==1)
			$internal_return+=$return['Price'];
			$total_return+=$return['Price'];
		}
		$total_Deposit=0;
		foreach($all_deposit as $deposit)
		{
			$total_Deposit+=$deposit['Price'];
		}
		
		
		echo '<center><table class="tablestyle" width="950px" cellspacing="0" cellpadding="0">
		<thead><tr>   
			<th colspan="2" class="tableheader">Summury</td>
		</tr></thead>
		<tr>
				<td style="background:#EEEEEE;" width="400px">
				<table class="no_border" width="450px" cellspacing="0" border="0" cellpadding="2">
					<tr>
						<td>(+)Total Chalan</td>
						<td style="text-align:right;">'.number_format($total_chalan, 2, '.', '').'</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>(-)Internal Retrn</td>
						<td style="text-align:right;">'.number_format($internal_return, 2, '.', '').'</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>(-)Total Retrn</td>
						<td style="text-align:right;">'.number_format($total_return-$internal_return, 2, '.', '').'</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td colspan="3"><hr/></td>
					</tr>
					<tr>
						<td><b>Net Chalan</b></td>
						<td>&nbsp;</td>
						<td style="text-align:right;"><b>'.number_format($total_chalan-$total_return, 2, '.', '').'</b></td>
					</tr>				
				    <tr>
						<td>(+)Total Packing Cost</td>
						<td style="text-align:right;">'.number_format($total_pack_cost, 2, '.', '').'</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td colspan="3"><hr/></td>
					</tr>
					<tr>
						<td><b>Total Receivable</b></td>
						<td>&nbsp;</td>
						<td style="text-align:right;"><b>'.number_format($total_pack_cost+$total_chalan-$total_return, 2, '.', '').'</b></td>
					</tr>
					<tr>
						<td>(-)Total Deposit</td>
						<td style="text-align:right;">'.number_format($total_Deposit, 2, '.', '').'</td>
						<td>&nbsp;</td>
					</tr>
					
					 <tr>
						<td>Project Bonus</td>
						<td style="text-align:right;">'.number_format($this->Project_Bonus, 2, '.', '').'</td>
						<td>&nbsp;</td>
					</tr>
					
					 <tr>
						<td>Last Year Balance</td>
						<td style="text-align:right;">'.number_format($this->last_year_balance, 2, '.', '').'</td>
						<td>&nbsp;</td>
					</tr>
					
					 <tr>
						<td>Balance</td>
						<td style="text-align:right;">'.number_format($this->Somonnoy_Balance, 2, '.', '').'</td>
						<td>&nbsp;</td>
					</tr>
					
					<tr>
						<td colspan="3"><hr/></td>
					</tr>
					
					<tr>
						<td><b>Net Receivable/Payable</b></td>
						<td>&nbsp;</td>
						<td style="text-align:right;"><b>'.number_format($total_pack_cost+$total_chalan-$total_return-$total_Deposit+$this->last_year_balance, 2, '.', '').'</b></td>
					</tr>
					
					
				</table>		
				
				</td>
				<td width="450px">&nbsp;</td>
			</tr>
			</table></center>';

		start_table(TABLESTYLE, 'width="950px" cellspacing="0" cellpadding="0"');
		$th = array(_("Details"));
		inactive_control_column($th);//_("Districts"),_("Division")
		table_header($th,"colspan='11'");
		$th2 = array(_("Chalan","colspan='4'"),_("Return","colspan='3'"),_("Deposit","colspan='4'"));
		table_header($th2);

		echo '<tr>
		
		<td style="vertical-align: top;"><table class="no_border" width="100%" border="0" cellspacing="0" cellpadding="2">
		<tr><td class="tableheader">Date</td><td class="tableheader">Memo No</td><td class="tableheader">Packing Cost</td><td class="tableheader">Amount</td></tr>
		'.$this->table1($all_chalan).'
		</table></td>
		
		<td style="vertical-align: top;"><table class="no_border" width="100%" border="0" cellspacing="0" cellpadding="2">
		<tr><td class="tableheader">Date</td><td class="tableheader">Memo No</td><td class="tableheader">Amount</td></tr>
		'.$this->table2($all_return).'
		</table></td>
		
		<td style="vertical-align: top;"><table class="no_border" width="100%" border="0" cellspacing="0" cellpadding="2">
		<tr><td class="tableheader">Date</td><td class="tableheader">Memo No</td><td class="tableheader">Type</td><td class="tableheader">Amount</td></tr>
		'.$this->table3($all_deposit).'
		</table></td>
		</tr>';
		end_table();
		echo '<br/>';
	}


function make_table_text_book_Bonus($text_book_Bonus=array())
	{
		start_table(TABLESTYLE, "width=950px");
		$th = array(_("Book Name"),_("Edition"),_("Chalan"),_("Return"),_("Actual Sell"),_("Price"),_("Sell Amount"),_("Bonus"),_("Bonus Amount"));
		inactive_control_column($th);//_("Districts"),_("Division")
		table_header($th);
		$pp=0;
		$Total_Chalan=0;
		$Total_Return=0;
		$Total_Actual_Sell=0;
		$Total_Sell_Amount=0;
		$Total_Bonus_Amount=0;
		$this->Text_Book_Bonus_Amount=0;
		foreach($text_book_Bonus as $myrow) {
			if($myrow["BookType"]!='System Default')
			{
				alt_table_row_color($k);
				
				label_cell($myrow["Book Name"]);
				label_cell($myrow["Edition"]);
				label_cell(number_format($myrow["Chalan"], 0, '.', ''), 'style="text-align:right;"');
				label_cell($myrow["Return"], 'style="text-align:right;"');
				label_cell($myrow["Actual Sell"], 'style="text-align:right;"');
				label_cell($myrow["Price"], 'style="text-align:right;"');
				label_cell(number_format($myrow["Sell Amount"], 2, '.', ''), 'style="text-align:right;"');
				label_cell($myrow["Bonus"].'%', 'style="text-align:center;"');
				label_cell(number_format($myrow["Bonus Amount"], 2, '.', ''), 'style="text-align:right;"');
				end_row();
				$pp++;
				$Total_Chalan+=$myrow["Chalan"];
				$Total_Return+=$myrow["Return"];
				$Total_Actual_Sell+=$myrow["Actual Sell"];
				$Total_Sell_Amount+=$myrow["Sell Amount"];
				$Total_Bonus_Amount+=$myrow["Bonus Amount"];
			}
		
		}
		echo $footer='<tr>
			<td style="text-align:right;"><b>Total Qty/Amount</b></td>
			<td><b>&nbsp;</b></td>
			<td style="text-align:right;"><b>'.$Total_Chalan.'</b></td>
			<td style="text-align:right;"><b>'.$Total_Return.'</b></td>
			<td style="text-align:right;"><b>'.$Total_Actual_Sell.'</b></td>
			<td><b>&nbsp;</b></td>
			<td style="text-align:right;"><b>'.number_format($Total_Sell_Amount, 2, '.', '').'</b></td>
			<td><b>&nbsp;</b></td>
			<td style="text-align:right;"><b>'.number_format($Total_Bonus_Amount, 2, '.', '').'</b></td>
		
		</tr>';
		//inactive_control_row($th);
		end_table();
		echo '<br/>';
		$this->Text_Book_Transection_Amount=$Total_Sell_Amount;
		$this->Text_Book_Bonus_Amount=$Total_Bonus_Amount;
	}


function make_table_return_Discount_Statement($return_Discount_Statement=array())
	{
		start_table(TABLESTYLE, "width=950px");
		$th = array(_("Return Slip No"),_("Return Date"),_("Discount Amount"),_("Discount Details"));
		inactive_control_column($th);//_("Districts"),_("Division")
		table_header($th);
		$pp=0;
		$Discount_Amount=0;
		foreach($return_Discount_Statement as $myrow) {
			if($myrow["BookType"]!='System Default')
			{
				alt_table_row_color($k);
				
				label_cell($myrow["Return Slip No"], 'style="text-align:center;"');
				label_cell(date("d/m/Y",strtotime($myrow["Return Date"])), 'style="text-align:center;"');
				label_cell(number_format($myrow["Discount Amount"], 2, '.', ''), 'style="text-align:right;"');
				label_cell($myrow["Discount Details"]);
				end_row();
				$pp++;
				$Discount_Amount+=$myrow["Discount Amount"];
			}
		
		}
		echo $footer='<tr>
		<td style="text-align:right;"><b>Total:</b></td>
		<td style="text-align:right;"><b>'.$pp.'</b></td>
		<td style="text-align:right;"><b>'.number_format($Discount_Amount, 2, '.', '').'</b></td>
		
		</tr>';
		//inactive_control_row($th);
		end_table();
		echo '<br/>';
		
		
		echo '
		<center>
		<table class="table-style" width="950px" cellspacing="0" cellpadding="20">
		<tr>
		<td style="text-align:center;"><br /><br /><br /><br /><hr /><b>Marketing<br />lecture Publications Ltd.<br />37, banglabazar, Dhaka-1100</b></td>
		<td style="text-align:center;"><br /><br /><br /><br /><hr /><b>Distribution<br />lecture Publications Ltd.<br />37, banglabazar, Dhaka-1100</b></td>
		<td style="text-align:center;"><br /><br /><br /><br /><hr /><b>MIS<br />lecture Publications Ltd.<br />37, banglabazar, Dhaka-1100</b></td>
		</tr>
		</table>
		</center>
		';
		echo '<br/>';
		$this->Return_Discount_Amount=$Discount_Amount;
	}
	
function make_table_quantity_basis_Book_bonus($quantity_basis_Book_bonus=array())
	{
		start_table(TABLESTYLE, "width=950px");
		$th = array(_("Book Name"),_("Edition"),_("Chalan"),_("Return"),_("Actual Sell"),_("Price"),_("Sell Amount"),_("Factor"),_("Bonus"));
		inactive_control_column($th);//_("Districts"),_("Division")
		table_header($th);
		$pp=0;
		$Chalan=0;
		$Return=0;
		$Actual_Sell=0;
		$Sell_Amount=0;
		$Bonus=0;
		foreach($quantity_basis_Book_bonus as $myrow) {
			if($myrow["BookType"]!='System Default')
			{
				alt_table_row_color($k);
				label_cell($myrow["Book Name"], 'style="text-align:lrft;"');
				label_cell($myrow["Edition"], 'style="text-align:center;"');
				label_cell($myrow["Chalan"], 'style="text-align:right;"');
				label_cell($myrow["Return"], 'style="text-align:right;"');
				label_cell(number_format($myrow["Actual Sell"], 2, '.', ''), 'style="text-align:right;"');
				label_cell($myrow["Price"], 'style="text-align:right;"');
				label_cell(number_format($myrow["Sell Amount"], 2, '.', ''), 'style="text-align:right;"');
				label_cell($myrow["Factor"], 'style="text-align:right;"');
				label_cell(number_format($myrow["Bonus"], 2, '.', ''), 'style="text-align:right;"');
				end_row();
				$pp++;

				$Chalan+=$myrow["Chalan"];
				$Return+=$myrow["Return"];
				$Actual_Sell+=$myrow["Actual Sell"];
				$Sell_Amount+=$myrow["Sell Amount"];
				$Bonus+=$myrow["Bonus"];
			}
		
		}
		echo $footer='<tr>
			<td colspan="2" style="text-align:right;"><b>Total Qty:</b></td>
			<td style="text-align:right;"><b>'.$Chalan.'</b></td>
			<td style="text-align:right;"><b>'.$Return.'</b></td>
			<td style="text-align:right;"><b>'.$Actual_Sell.'</b></td>
			<td style="text-align:right;">&nbsp;</td>
			<td style="text-align:right;"><b>'.number_format($Sell_Amount, 2, '.', '').'</b></td>
			<td style="text-align:right;">&nbsp;</td>
			<td style="text-align:right;"><b>'.number_format($Bonus, 2, '.', '').'</b></td>
		</tr>';
		end_table();
		echo '<br/>';
		
		$this->Quantity_Basis_Book_Amount=$Sell_Amount;
		$this->Quantity_Basis_Bonus_Amount=$Bonus;
		
	}
	





function make_table_Library_Closing_Statement($lib_code='')
	{
		$Extra_Bonus_Array=array();
		$qstr="SELECT [Library Info].[Library Code], [Sub Account info].[Extra Bonus], [Sub Account info].[TP Extra Bonus], [Sub Account info].[Closing Discount], [Sub Account info].[Account Code]
		FROM [Library Info] INNER JOIN [Sub Account info] ON [Library Info].[Account Code] = [Sub Account info].[Account Code]
		WHERE ((([Library Info].[Library Code])='".$lib_code."'))";
		$Extra_Bonus=$this->dbh->query($qstr);
		foreach($Extra_Bonus as $Bonus)
			{
			$Extra_Bonus_Array['Extra Bonus']=$Bonus['Extra Bonus'];
			$Extra_Bonus_Array['TP Extra Bonus']=$Bonus['TP Extra Bonus'];
			$Extra_Bonus_Array['Other Bonus']=$Bonus['Closing Discount'];
			}
			
			
		$Net_Sales_Amount=$this->General_Book_Transection_Amount+$this->Text_Book_Transection_Amount+$this->Quantity_Basis_Book_Amount+$this->None_Basis_Book_Amount;
		$Net_Discount_Amount=0;
		
		echo '<center>
				<table class="tablestyle" width="950px" cellspacing="0" cellpadding="0">
				<tr>   
				<td>
				
				
				
				
		<table class="no_border" width="940px" cellspacing="0" border="0" cellpadding="2">
		<thead><tr>   
			<th colspan="4" width="948px" class="tableheader">Sales Part</td>
		</tr></thead>
		<tr>
			<td width="375px">General Book Transection Amount</td>
			<td width="75px">:=(+)</td>
			<td width="160px" style="text-align:right;">'.number_format($this->General_Book_Transection_Amount, 2, '.', '').'</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>Text Book Transection Amount</td>
			<td>:=(+)</td>
			<td style="text-align:right;">'.number_format($this->Text_Book_Transection_Amount, 2, '.', '').'</td>
			<td rowspan="3" style="text-align:right;">Net Sales Amount (Tk.):=<br />'.number_format($Net_Sales_Amount, 2, '.', '').'</td>
		</tr>
		<tr>
			<td>Quantity Basis Book Amount</td>
			<td>:=(+)</td>
			<td style="text-align:right;">'.number_format($this->Quantity_Basis_Book_Amount, 2, '.', '').'</td>
		</tr>
		<tr>
			<td>None Basis Book Amount</td>
			<td>:=(+)</td>
			<td style="text-align:right;">'.number_format($this->None_Basis_Book_Amount, 2, '.', '').'</td>
		</tr>
		<tr>
		<td colspan="4"><hr/></td>
		</tr>

		<tr>
			<td>Chalan Discount Amount</td>
			<td>:=(-)</td>
			<td style="text-align:right;">'.number_format($this->Chalan_Discount_Amount, 2, '.', '').'</td>
			<td rowspan="2" style="text-align:right;">Net Discount Amount (Tk.):=<br />'.number_format($this->Return_Discount_Amount-$this->Chalan_Discount_Amount, 2, '.', '').'</td>
		</tr>
		<tr>
			<td>Return Discount/Cost Amount</td>
			<td>:=(+)</td>
			<td style="text-align:right;">'.number_format($this->Return_Discount_Amount, 2, '.', '').'</td>
		</tr>
		<tr>
			<td colspan="4"><hr/></td>
		</tr>

		<tr>
			<td>Net Sales Amount After Discount</td>
			<td>:=</td>
			<td style="text-align:right;">&nbsp;</td>
			<td style="text-align:right;">'.number_format($Net_Sales_Amount_After_Discount=$Net_Sales_Amount+$this->Return_Discount_Amount-$this->Chalan_Discount_Amount, 2, '.', '').'</td>
		</tr>
		<tr>
			<td>Book Packing Cost</td>
			<td>:=(+)</td>
			<td style="text-align:right;">'.number_format($this->Book_Packing_Cost, 2, '.', '').'</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td colspan="4"><hr/><hr/></td>
		</tr>
		<tr>
			<td><b>Net Receivable Sales Amount (Tk.)</b></td>
			<td>:=</td>
			<td>&nbsp;</td>
			<td style="text-align:right;"><b>'.number_format($Net_Receivable_Sales_Amount=$Net_Sales_Amount_After_Discount+$this->Book_Packing_Cost, 2, '.', '').'</b></td>
		</tr>
		<tr>
			<td colspan="4">&nbsp;</td>
		</tr>
		</table>
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
	
		
		<table class="no_border" width="948px" cellspacing="0" border="0" cellpadding="2">
		<thead><tr>   
			<th colspan="4" width="948px" class="tableheader">Deposit Part</td>
		</tr></thead>
		<tr>
			<td width="375px">Total Deposit Amount</td>
			<td width="75px">:=(+)</td>
			<td width="160px" style="text-align:right;">'.number_format($this->Net_Deposit_Amount-$this->Net_OD_Deposit_Amount, 2, '.', '').'</td>
			<td rowspan="2" style="text-align:right;">Net Deposit Amount (Tk.):=<br />'.number_format($this->Net_Deposit_Amount, 2, '.', '').'</td>
		</tr>
		<tr>
			<td>Total OD Deposit Amount</td>
			<td>:=(+)</td>
			<td style="text-align:right;">'.number_format($this->Net_OD_Deposit_Amount, 2, '.', '').'</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
		<td colspan="4"><hr/></td>
		</tr>
		<tr>
			<td>Opening Balance Amount</td>
			<td>:=(+)</td>
			<td style="text-align:right;">'.number_format($this->last_year_balance, 2, '.', '').'</td>
			<td style="text-align:right;">'.number_format($deposit_part=$this->Net_Deposit_Amount-$this->last_year_balance, 2, '.', '').'</td>
		</tr>
		<tr>
			<td colspan="4"><hr/><hr/></td>
		</tr>
		<tr>
			<td><b>Net Receivable Amount (Tk.)</b></td>
			<td>:=</td>
			<td>&nbsp;</td>
			<td style="text-align:right;"><b>'.number_format($Net_Receivable_Amount=$Net_Receivable_Sales_Amount-$deposit_part, 2, '.', '').'</b></td>
		</tr>
		<tr>
			<td colspan="4">&nbsp;</td>
		</tr>
		</table>	
				
		
		
		
		
		
		
		
		
		
		<table class="no_border" width="938px" cellspacing="0" border="0" cellpadding="2">
		<thead><tr>   
			<th colspan="4" width="948px" class="tableheader">Bonus Part</td>
		</tr></thead>
		<tr>
			<td width="375px">General Book Bonus Amount</td>
			<td width="75px">:=(+)</td>
			<td width="160px" style="text-align:right;">'.number_format($this->General_Book_Bonus_Amount, 2, '.', '').'</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>Text Book Bonus Amount</td>
			<td>:=(+)</td>
			<td style="text-align:right;">'.number_format($this->Text_Book_Bonus_Amount, 2, '.', '').'</td>
			<td style="text-align:right;"><b>General Bonus:&nbsp;'.number_format(($this->General_Book_Bonus_Amount*100)/$this->General_Book_Transection_Amount, 2, '.', '').'&nbsp;%</b></td>
		</tr>
		<tr>
			<td>Quantity Basis Bonus Amount</td>
			<td>:=(+)</td>
			<td style="text-align:right;">'.number_format($this->Quantity_Basis_Bonus_Amount, 2, '.', '').'</td>
			<td style="text-align:right;"><b>Extra Bonus:&nbsp;'.number_format($Extra_Bonus_Array['Extra Bonus'], 2, '.', '').'&nbsp;%</b></td>
		</tr>
		<tr>
			<td>Extra Amount Basis Bonus Amount</td>
			<td>:=(+)</td>
			<td style="text-align:right;">'.number_format(($Extra_Bonus_Array['Extra Bonus']/100)*$this->General_Book_Transection_Amount, 2, '.', '').'</td>
			<td style="text-align:right;">&nbsp;</td>
		</tr>
		<tr>
			<td>Test Paper Extra Bonus Amount</td>
			<td>:=(+)</td>
			<td style="text-align:right;">'.number_format($Extra_Bonus_Array['TP Extra Bonus'], 2, '.', '').'</td>
			<td style="text-align:right;" rowspan="2"><b>Total Bonus Amount(Tk.):=<br/>'.number_format($Total_Bonus_Amount=$this->General_Book_Bonus_Amount+$this->Text_Book_Bonus_Amount+$this->Quantity_Basis_Bonus_Amount+($Extra_Bonus_Array['Extra Bonus']/100)*$this->General_Book_Transection_Amount+$Extra_Bonus_Array['TP Extra Bonus']+$Extra_Bonus_Array['Other Bonus'], 2, '.', '').'</b></td>
		</tr>
		<tr>
			<td>Test Paper Extra Bonus Amount</td>
			<td>:=(+)</td>
			<td style="text-align:right;">'.number_format($Extra_Bonus_Array['Other Bonus'], 2, '.', '').'</td>
			
		</tr>
		<tr>
			<td colspan="4"><hr/><hr/></td>
		</tr>
		<tr>
			<td><b>Final Closing Amount (Tk.)</b></td>
			<td>:=</td>
			<td>&nbsp;</td>
			<td style="text-align:right;"><b>'.number_format($Net_Receivable_Amount-$Total_Bonus_Amount, 2, '.', '').'</b></td>
		</tr>
		<tr>
			<td colspan="4">&nbsp;</td>
		</tr>
		</table>
		
		
		
				
				
				
				
				
				
			</td>
			</tr>
			</table>
		</center>
		
		
		
		
		<center>
		<br />
		<span style="text-align:left; font-size:14px; font-weight:bold;">-: Comment :-</span>
		<table class="tablestyle" width="950px" cellspacing="0" cellpadding="0">
		<tr><td><br /><br /><br /></td></tr>
		</table>
		</center>
		
		
		
		
		
		<center>
		<table class="table-style" width="950px" cellspacing="0" cellpadding="20">
		<tr>
		<td style="text-align:center;"><br /><br /><br /><br /><hr /><b>Distribution Dept</b></td>
		<td style="text-align:center;"><br /><br /><br /><br /><hr /><b>Account Dept</b></td>
		<td style="text-align:center;"><br /><br /><br /><br /><hr /><b>Library Signature</b></td>
		<td style="text-align:center;"><br /><br /><br /><br /><hr /><b>Sales &amp; Marketing Dept</b></td>
		</tr>
		</table>
		</center>
		
		
		
		';
	}
	
	
	
	
	

   
}

?>



