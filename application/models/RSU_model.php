<?php
class RSU_model extends CI_Model
{
  function fetch_all()
  {
    $this->db->order_by('tipo', 'ASC');
    return $this->db->get('rsu');
  }

  function insert_api($data)
  {
    $this->db->insert('rsu', $data);
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
    $query = $this->db->get('rsu');
    return $query->result_array();
  }

  function update_api($id, $data)
  {
    $this->db->where("id", $id);
    $this->db->update("rsu", $data);
  }
 
  function delete_single($id)
  {
    $this->db->where("id", $id);
    $this->db->delete("rsu");
    if($this->db->affected_rows() > 0)
    {
      return true;
    }
    else
    {
      return false;
    }
  }

  function verificarTipoRSU($tipo)
  {
    $this->db->where('tipo', $tipo);
    $query = $this->db->get('rsu');
    return $query->result_array();
  }
}
