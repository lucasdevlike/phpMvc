<?php

namespace App\Model\Entity;

use PDOStatement;
use WilliamCosta\DatabaseManager\Database;

class Testimony
{
    public int $id;
    public string $nome;
    public string $mensagem;
    public string $data;

    /**
     * MÉTODO RESPONSÁVEL POR CADASTRAR A INSTÂNCIA ATUAL NO BANCO DE DADOS
     * @return boolean
     */
    public function cadastrar(): bool
    {
        //DEFINE A DATA
        $this->data = date('Y-m-d H:i:s');

        //INSERE O DEPOIMENTO NO BANCO DE DADOS
        $this->id = (new Database('depoimentos'))->insert([
            'nome'     => $this->nome,
            'mensagem' => $this->mensagem,
            'data'     => $this->data
        ]);

        return true;
    }


    /**
     * MÉTODO RESPONSÁVEL POR RETORNAR DEPOIMENTOS
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param string $fields
     * @return PDOStatement
     */
    public static function getTestimonies($where = null, $order = null, $limit = null, $fields = '*')
    {

        return (new Database('depoimentos'))->select($where, $order, $limit, $fields);

    }

}
