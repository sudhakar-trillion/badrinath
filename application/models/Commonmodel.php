<?PHP
class Commonmodel extends CI_Model
{
	public function checkexists($table,$cond)
	{
		$this->db->where($cond);
		$qry = $this->db->get($table);
		if($qry->num_rows()>0)
			return $qry->num_rows();
		else
			return "0";
		
	}
	
		
	public function getnumRows($table,$cond)	
	{
		
		if( sizeof($cond)>0)
		{
			if( array_key_exists('Avg4_Combo',$cond ) )
				$this->db->where("Avg4_Combo",$cond['Avg4_Combo']);	
			else if(  array_key_exists('Avg3_Combo',$cond ) )
				$this->db->where("Avg3_Combo",$cond['Avg3_Combo']);	
				
			
			$this->db->like('D1', trim($cond['D1']),'after');
			$this->db->like('D2', trim($cond['D2']),'after');
			$this->db->like('D3', trim($cond['D3']),'after');
		}
		
		$qry = $this->db->get($table);
		return  $qry->num_rows();
	}
	
	
	public function insertdata($table,$data)
	{
		$this->db->insert($table,$data)	;
		return $this->db->insert_id();
		
	}
	
public function updatedata($table,$data,$cond)	
	{
		$this->db->where($cond);
		$this->db->update($table,$data);
		//return $this->db->affected_rows(); exit; 
//		echo $this->db->last_query(); exit; 
		if($this->db->affected_rows()>0)
			return "1";
		else
			return "0";
	}
	
	public function deleterow($table,$cond)
{
	$this->db->delete($table,$cond);
	return "1";	
}
	
	public function getAfield($table,$cond,$field,$order_by='',$order_by_field='',$limit='')
	{
		$this->db->select($field);
		$this->db->from($table);
		if( sizeof( count($cond) ) )
		{
			$this->db->where($cond);
		}
		if($order_by!='')
		{
			$this->db->order_by($order_by_field,$order_by);
		}	
		if($limit!='')
		{
				$this->db->limit($limit);
		}
		$qry = $this->db->get('');
		if($qry->num_rows()>0)
		{
			return $qry->row($field);			
		}else
			return "0";
		
	}

//general pagination 

	public function paginate($table,$cond,$order_by='',$order_by_field='',$limit,$start )
	{
		
		$this->db->select('*');
		$this->db->from($table);
		
		if( sizeof($cond) )
		{
			//$this->db->where($cond);
			if( array_key_exists('Avg4_Combo',$cond ) )
				$this->db->where("Avg4_Combo",$cond['Avg4_Combo']);	
			else if(  array_key_exists('Avg3_Combo',$cond ) )
				$this->db->where("Avg3_Combo",$cond['Avg3_Combo']);	
				
			
			$this->db->like('D1', trim($cond['D1']),'after');
			$this->db->like('D2', trim($cond['D2']),'after');
			$this->db->like('D3', trim($cond['D3']),'after');
			
		}
		if($order_by!='')
		{
			$this->db->order_by('Date',$order_by);
			$this->db->order_by('Name','ASC');
		}	
		if($limit!='')
		{
				$this->db->limit($limit,$start);
		}
		$qry = $this->db->get('');

#		echo $this->db->last_query();
		if($qry->num_rows()>0)
		{
			return $qry;		
		}
		else
			return "0";
		
		
	}

//general pagination ends here

	public function checkseriesrows($NUM,$XVAL)
	{
		$cond = array();
		
		if($NUM==1)
		{
			
			
			$this->db->like('S1', trim($XVAL),'after');
			$this->db->or_like('S2', trim($XVAL),'after');
			$this->db->or_like('S3', trim($XVAL),'after');
			$this->db->or_like('S4', trim($XVAL),'after');
			
		}
		
		else if($NUM==2)
		{
			
			$this->db->group_start();
				
				$this->db->like('S1', trim($XVAL),'after');
				$this->db->like('S2', trim($XVAL),'after');
			$this->db->group_end();
				
			$this->db->or_group_start();
				$this->db->like('S1', trim($XVAL),'after');
				$this->db->like('S3', trim($XVAL),'after');
			$this->db->group_end();
			
			$this->db->or_group_start();
				$this->db->like('S1', trim($XVAL),'after');
				$this->db->like('S4', trim($XVAL),'after');
			$this->db->group_end();
			
			$this->db->or_group_start();
				$this->db->like('S2', trim($XVAL),'after');
				$this->db->like('S3', trim($XVAL),'after');
			$this->db->group_end();	
		
		$this->db->or_group_start();
				$this->db->like('S2', trim($XVAL),'after');
				$this->db->like('S4', trim($XVAL),'after');
		$this->db->group_end();	
		
		$this->db->or_group_start();
				$this->db->like('S3', trim($XVAL),'after');
				$this->db->like('S4', trim($XVAL),'after');
		$this->db->group_end();		

		
			
		}
		
		else if($NUM==3)
		{
			$this->db->group_start();
				
				$this->db->like('S1', trim($XVAL),'after');
				$this->db->like('S2', trim($XVAL),'after');
				$this->db->like('S3', trim($XVAL),'after');
			$this->db->group_end();

			$this->db->group_start();
				
				$this->db->like('S1', trim($XVAL),'after');
				$this->db->like('S3', trim($XVAL),'after');
				$this->db->like('S4', trim($XVAL),'after');
		
			$this->db->group_end();
			
		$this->db->group_start();
				
				$this->db->like('S1', trim($XVAL),'after');
				$this->db->like('S4', trim($XVAL),'after');
				$this->db->like('S2', trim($XVAL),'after');
	
		$this->db->group_end();
		
		$this->db->group_start();
				
				$this->db->like('S2', trim($XVAL),'after');
				$this->db->like('S3', trim($XVAL),'after');
				$this->db->like('S4', trim($XVAL),'after');
	
		$this->db->group_end();
		}
		else if($NUM==4)
		{
			$this->db->group_start();
				
				$this->db->like('S1', trim($XVAL),'after');
				$this->db->like('S2', trim($XVAL),'after');
				$this->db->like('S3', trim($XVAL),'after');
				$this->db->like('S4', trim($XVAL),'after');
			$this->db->group_end();
		}
		
		$this->db->select('SLNO');
		$qry = $this->db->get('stockdata');
		
		#echo $this->db->last_query(); exit;

		return $qry->num_rows();
		
	}	


	public function seriesdatapaginate($XVAL,$NUM,$order_by='DESC',$order_by_field='SLNO',$limit,$start)
	{
		#echo $XVAL.":".$NUM; exit;
		
		$cond = array();
		
		if($NUM==1)
		{
			
			
			$this->db->like('S1', trim($XVAL),'after');
			$this->db->or_like('S2', trim($XVAL),'after');
			$this->db->or_like('S3', trim($XVAL),'after');
			$this->db->or_like('S4', trim($XVAL),'after');
			
		}
		
		else if($NUM==2)
		{
			
			$this->db->group_start();
				
				$this->db->like('S1', trim($XVAL),'after');
				$this->db->like('S2', trim($XVAL),'after');
			$this->db->group_end();
				
			$this->db->or_group_start();
				$this->db->like('S1', trim($XVAL),'after');
				$this->db->like('S3', trim($XVAL),'after');
			$this->db->group_end();
			
			$this->db->or_group_start();
				$this->db->like('S1', trim($XVAL),'after');
				$this->db->like('S4', trim($XVAL),'after');
			$this->db->group_end();
			
			$this->db->or_group_start();
				$this->db->like('S2', trim($XVAL),'after');
				$this->db->like('S3', trim($XVAL),'after');
			$this->db->group_end();	
		
		$this->db->or_group_start();
				$this->db->like('S2', trim($XVAL),'after');
				$this->db->like('S4', trim($XVAL),'after');
		$this->db->group_end();	
		
		$this->db->or_group_start();
				$this->db->like('S3', trim($XVAL),'after');
				$this->db->like('S4', trim($XVAL),'after');
		$this->db->group_end();		

		
			
		}
		
		else if($NUM==3)
		{
			$this->db->group_start();
				
				$this->db->like('S1', trim($XVAL),'after');
				$this->db->like('S2', trim($XVAL),'after');
				$this->db->like('S3', trim($XVAL),'after');
			$this->db->group_end();

			$this->db->group_start();
				
				$this->db->like('S1', trim($XVAL),'after');
				$this->db->like('S3', trim($XVAL),'after');
				$this->db->like('S4', trim($XVAL),'after');
		
			$this->db->group_end();
			
		$this->db->group_start();
				
				$this->db->like('S1', trim($XVAL),'after');
				$this->db->like('S4', trim($XVAL),'after');
				$this->db->like('S2', trim($XVAL),'after');
	
		$this->db->group_end();
		
		$this->db->group_start();
				
				$this->db->like('S2', trim($XVAL),'after');
				$this->db->like('S3', trim($XVAL),'after');
				$this->db->like('S4', trim($XVAL),'after');
	
		$this->db->group_end();
		}
		else if($NUM==4)
		{
			$this->db->group_start();
				
				$this->db->like('S1', trim($XVAL),'after');
				$this->db->like('S2', trim($XVAL),'after');
				$this->db->like('S3', trim($XVAL),'after');
				$this->db->like('S4', trim($XVAL),'after');
			$this->db->group_end();
		}	
			
			
		if($order_by!='')
		{
			$this->db->order_by('Date',$order_by);
			$this->db->order_by('Name','ASC');
		}	
		if($limit!='')
		{
				$this->db->limit($limit,$start);
		}
		$qry = $this->db->get('stockdata');

		#echo $this->db->last_query();
		
		if($qry->num_rows()>0)
		{
			return $qry;		
		}
		else
			return "0";
			
	}//series data pagination ends hree

}//class ends here

?>