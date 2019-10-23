<?php
class Desafio_model extends CI_Model
{
  function fetch_all()
  {
    $this->db->order_by('id', 'DESC');
    return $this->db->get('desafio');
  }

  function insert_api($data)
  {
    $this->db->insert('desafio', $data);
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
    $query = $this->db->get('desafio');
    return $query->result_array();
  }

  function update_api($id, $data)
  {
    $this->db->where("id", $id);
    $this->db->update("desafio", $data);
  }
 
  function delete_single($id)
  {
    $this->db->where("id", $id);
    $this->db->delete("desafio");
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
