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

  function verificarDocCadastrado($doc)
  {
    $this->db->where('docCadastrado', $doc);
    $query = $this->db->get('cidadao');
    return $query->result_array();
  }

  function verificarEmail($login)
  {
    $this->db->where('login', $login);
    $query = $this->db->get('cidadao');
    return $query->result_array();
  }

  function autenticar($login, $senha)
  {
    $this->db->where('login', $login);
    $this->db->where('senha', $senha);
    $query = $this->db->get('cidadao');
    return $query->result_array();
  }

  /*getters and setters*/

  function getDoc($login)
  {
    $this->db->select('docCadastrado');
    $this->db->from('cidadao');
    $this->db->where('login', $login);
    $query = $this->db->get();
    $result = $query->row();
    return $result->docCadastrado;
  }

  function getCEP($login)
  {
    $this->db->select('cep');
    $this->db->from('cidadao');
    $this->db->where('login', $login);
    $query = $this->db->get();
    $result = $query->row();
    return $result->cep;
  }

  function getNome($login)
  {
    $this->db->select('nome');
    $this->db->from('cidadao');
    $this->db->where('login', $login);
    $query = $this->db->get();
    $result = $query->row();
    return $result->nome;
  }
}
