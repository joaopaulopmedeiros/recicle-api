<?php
class DesafioAceito_model extends CI_Model
{
  function fetch_all($id_user)
  {
    $this->db->select("desafioaceito.id, desafio.titulo as titulo, cidadao.nome as Cidadao, criadordesafio.nome as CriadorDesafio, rsu.tipo as tipo_rsu, bonificacao.nome as tipo_bonificacao, desafioaceito.cumprido");      
    $this->db->from("desafioaceito");
    $this->db->join("criadordesafio","criadordesafio.docCadastrado = desafioaceito.idCriadorDesafio");
    $this->db->join("cidadao","cidadao.docCadastrado = desafioaceito.idCidadao");
    $this->db->join("rsu","rsu.id = desafioaceito.idTipoRSU");
    $this->db->join("bonificacao","bonificacao.id = desafioaceito.idTipoBonificacao");
    $this->db->join("desafio","desafio.id = desafioaceito.idDesafio");
    $this->db->where("cidadao.docCadastrado",$id_user);
    return $this->db->get();
  }

  function insert_api($data)
  {
    $id_user = element('idCidadao',$data);
    $id_desafio = element('idDesafio',$data);

    $this->db->select("*");
    $this->db->from("desafioaceito");
    $this->db->where("idCidadao",$id_user);
    $this->db->where("idDesafio",$id_desafio);
    
    $query = $this->db->get();
    $check = $query->row();

    if(($query->num_rows() == 0) || ($query->num_rows() > 1 && $check->cumprido == 1)){
      $this->db->insert('desafioaceito', $data);
    }
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
