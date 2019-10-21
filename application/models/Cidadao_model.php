<?php
class Cidadao_model extends CI_Model
{
  function fetch_all()
  {
    $this->db->order_by('docCadastrado', 'DESC');
    return $this->db->get('cidadao');
  }

  function insert_api($data)
  {
    $this->db->insert('cidadao', $data);
    if($this->db->affected_rows() > 0)
    {
      return true;
    }
    else
    {
      return false;
    }
  }

  function fetch_single_user($docCadastrado)
  {
    $this->db->where("docCadastrado", $docCadastrado);
    $query = $this->db->get('cidadao');
    return $query->result_array();
  }

  function update_api($docCadastrado, $data)
  {
    $this->db->where("docCadastrado", $docCadastrado);
    $this->db->update("cidadao", $data);
  }
 
  function delete_single_user($docCadastrado)
  {
    $this->db->where("docCadastrado", $docCadastrado);
    $this->db->delete("cidadao");
    if($this->db->affected_rows() > 0)
    {
      return true;
    }
    else
    {
      return false;
    }
  }

  function autenticar($login, $senha)
  {
    $this->db->where('login', $login);
    $this->db->where('senha', $senha);
    $query = $this->db->get('cidadao');
    return $query->result_array();
  }
}
