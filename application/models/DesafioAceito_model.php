<?php
class DesafioAceito_model extends CI_Model
{
  function fetch_all()
  {
    $this->db->select("desafioaceito.id, desafio.titulo as Desafio, cidadao.nome as Cidadao, criadordesafio.nome as CriadorDesafio, rsu.tipo as TipoRSU, bonificacao.nome as Bonificacao, desafioaceito.cumprido");      
    $this->db->from("desafioaceito");
    $this->db->join("criadordesafio","criadordesafio.docCadastrado = desafioaceito.idCriadorDesafio");
    $this->db->join("cidadao","cidadao.docCadastrado = desafioaceito.idCidadao");
    $this->db->join("rsu","rsu.id = desafioaceito.idTipoRSU");
    $this->db->join("bonificacao","bonificacao.id = desafioaceito.idTipoBonificacao");
    $this->db->join("desafio","desafio.id = desafioaceito.idDesafio");
    return $this->db->get();
  }

  function insert_api($data)
  {
    $this->db->insert('desafioaceito', $data);
    if($this->db->affected_rows() > 0)
    {
      return true;
    }
    else
    {
      return false;
    }
  }

  function update_api($id, $data)
  {
    $this->db->where("id", $id);
    $this->db->update("desafioaceito", $data);
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
