<?php
class Contato_model extends CI_Model
{
  function fetch_all()
  {
    $this->db->order_by('id', 'ASC');
    return $this->db->get('contato');
  }

  function insert_api($data)
  {
    $this->db->insert('contato', $data);
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
    $query = $this->db->get('contato');
    return $query->result_array();
  }

  function update_api($id, $data)
  {
    $this->db->where("id", $id);
    $this->db->update("contato", $data);
  }
 
  function delete_single($id)
  {
    $this->db->where("id", $id);
    $this->db->delete("contato");
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
