<?php
class Desafio_model extends CI_Model
{
  function fetch_all()
  {
    $this->db->select('desafio.*, criadorDesafio.nome as criador_desafio, criadorDesafio.cep as cep_criador_desafio, rsu.tipo as tipo_rsu, bonificacao.nome as tipo_bonificacao');    
    $this->db->from('desafio');
    $this->db->join('criadorDesafio', 'criadorDesafio.docCadastrado = desafio.idCriadorDesafio');
    $this->db->join('rsu', 'desafio.idTipoRSU = rsu.id');
    $this->db->join('bonificacao', 'desafio.idTipoBonificacao = bonificacao.id');
    $this->db->order_by('desafio.id', 'DESC');
    return $this->db->get();
  }

  function fetch_single($id_desafio)
  {
    $sql = "select * from desafioaceito where idDesafio = ? && cumprido = 1";
    $query = $this->db->query($sql, $id_desafio);

    if ($query->num_rows() > 0) {
      $this->db->select('desafio.*, criadorDesafio.nome as criador_desafio, criadorDesafio.cep as cep_criador_desafio, rsu.tipo as tipo_rsu, bonificacao.nome as tipo_bonificacao, desafioaceito.cumprido');  
      $this->db->from('desafio');
      $this->db->where("desafio.id", $id_desafio);
      $this->db->join('criadorDesafio', 'criadorDesafio.docCadastrado = desafio.idCriadorDesafio');
      $this->db->join('rsu', 'desafio.idTipoRSU = rsu.id');
      $this->db->join('bonificacao', 'desafio.idTipoBonificacao = bonificacao.id');
      $this->db->join('desafioaceito', 'desafio.id = desafioaceito.idDesafio');
    }
    else {
      $this->db->select('desafio.*, criadorDesafio.nome as criador_desafio, criadorDesafio.cep as cep_criador_desafio, rsu.tipo as tipo_rsu, bonificacao.nome as tipo_bonificacao');    
      $this->db->from('desafio');
      $this->db->where("desafio.id", $id_desafio);
      $this->db->join('criadorDesafio', 'criadorDesafio.docCadastrado = desafio.idCriadorDesafio');
      $this->db->join('rsu', 'desafio.idTipoRSU = rsu.id');
      $this->db->join('bonificacao', 'desafio.idTipoBonificacao = bonificacao.id');
    }
    
    return $this->db->get();
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

  function exibir_meus_desafios($idCriadorDesafio)
  {
    $this->db->select('desafio.*, criadorDesafio.nome as criador_desafio, criadorDesafio.cep as cep_criador_desafio, rsu.tipo as tipo_rsu, bonificacao.nome as tipo_bonificacao');    
    $this->db->from('desafio');
    $this->db->where("desafio.idCriadorDesafio", $idCriadorDesafio);
    $this->db->join('criadorDesafio', 'criadorDesafio.docCadastrado = desafio.idCriadorDesafio');
    $this->db->join('rsu', 'desafio.idTipoRSU = rsu.id');
    $this->db->join('bonificacao', 'desafio.idTipoBonificacao = bonificacao.id');
    $this->db->order_by('desafio.id', 'DESC');
    return $this->db->get();
  }

  function filtrar_desafios($idCriadorDesafio,$idTipoBonificacao,$idTipoRSU)
  {
    $this->db->select('desafio.*, criadorDesafio.nome as criador_desafio, criadorDesafio.cep as cep_criador_desafio, rsu.tipo as tipo_rsu, bonificacao.nome as tipo_bonificacao');    
    $this->db->from('desafio');
    $this->db->join('criadorDesafio', 'criadorDesafio.docCadastrado = desafio.idCriadorDesafio');
    $this->db->join('rsu', 'desafio.idTipoRSU = rsu.id');
    $this->db->join('bonificacao', 'desafio.idTipoBonificacao = bonificacao.id');

    if ($idCriadorDesafio != 'todos') {
      $this->db->where("desafio.idCriadorDesafio", $idCriadorDesafio);
    }
    if ($idTipoBonificacao != 'todos') {
      $this->db->where("desafio.idTipoBonificacao", $idTipoBonificacao);
    }
    if ($idTipoRSU != '2') {
      $this->db->where("desafio.idTipoRSU", $idTipoRSU);
    }
    
    return $this->db->get();
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
