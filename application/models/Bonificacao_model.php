<?php
class Bonificacao_model extends CI_Model
{
  function fetch_all()
  {
    $this->db->order_by('nome', 'ASC');
    return $this->db->get('bonificacao');
  }

  function insert_api($data)
  {
    $this->db->insert('bonificacao', $data);
    if($this->db->affected_rows() > 0)
    {
      return true;
    }
    else
    {
      return false;
    }
  }

  function fetch_single($id)
  {
    $this->db->where("id", $id);
    $query = $this->db->get('bonificacao');
    return $query->result_array();
  }

  function update_api($id, $data)
  {
    $this->db->where("id", $id);
    $this->db->update("bonificacao", $data);
  }
 
  function delete_single($id)
  {
    $this->db->where("id", $id);
    $this->db->delete("bonificacao");
    if($this->db->affected_rows() > 0)
    {
      return true;
    }
    else
    {
      return false;
    }
  }
}
