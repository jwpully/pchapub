<?PHP
/**
* @name MOOJ Proforms 
* @version 1.0
* @package proforms
* @copyright Copyright (C) 2008-2010 Mad4Media. All rights reserved.
* @author Dipl. Inf.(FH) Fahrettin Kutyol
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @link http://www.mad4media.de Mad4Media Software Development - Softwareentwicklung
* Please note that some Javascript files are not under GNU/GPL License.
* These files are under the mad4media license
* They may edited and used infinitely but may not repuplished or redistributed.  
* For more information read the header notice of the js files.
**/
	
	defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

	function remember_cid($rcid=null)
	{
		if($rcid==null)
			{
				$remember_cid =  JRequest::getInt("remember_cid");
				if(!$remember_cid) $remember_cid=-2;
				define('M4J_REMEMBER_CID_QUERY','&remember_cid='.$remember_cid);
				return $remember_cid;		
			}
		else 
		{
				define('M4J_REMEMBER_CID_QUERY','&remember_cid='.$rcid);
				return $rcid;
		}	
	}//EOF remember_cid




?>