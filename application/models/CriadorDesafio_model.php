<?php
class CriadorDesafio_model extends CI_Model
{
  function fetch_all()
  {
    $this->db->order_by('docCadastrado', 'DESC');
    return $this->db->get('criadordesafio');
  }

  function insert_api($data)
  {
    $this->db->insert('criadordesafio', $data);
    if($this->db->affected_rows() > 0)
    {
      return true;
    }
    else
    {
      return false;
    }
  }

  function fetch_single_user($user_docCadastrado)
  {
    $this->db->where("docCadastrado", $user_docCadastrado);
    $query = $this->db->get('criadordesafio');
    return $query->result_array();
  }

  function update_api($user_docCadastrado, $data)
  {
    $this->db->where("docCadastrado", $user_docCadastrado);
    $this->db->update("criadordesafio", $data);
  }
 
  function delete_single_user($user_docCadastrado)
  {
    $this->db->where("docCadastrado", $user_docCadastrado);
    $this->db->delete("criadordesafio");
    if($this->db->affected_rows() > 0)
    {
      return true;
    }
    else
    {
      return false;
    }
  }

  function verificarDocCadastrado($doc)
  {
    $this->db->where('docCadastrado', $doc);
    $query = $this->db->get('criadorDesafio');
    return $query->result_array();
  }

  function verificarEmail($login)
  {
    $this->db->where('login', $login);
    $query = $this->db->get('criadorDesafio');
    return $query->result_array();
  }

  function autenticar($login, $senha)
  {
    $this->db->where('login', $login);
    $this->db->where('senha', $senha);
    $query = $this->db->get('criadorDesafio');
    return $query->result_array();
  }
}
