<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Datatable;

/**
 * Description of Response
 *
 * @author MSI
 */
class Response
{

    const OK = "OK";
    public $rows;
    public $items;
    public $dataResponse;
    public $params;
    public $mess;
    public $status;
    public $indexPage;
    public $number;
    public $columns;
    public $totalrows;
    public $totalPage;

    public function __construct($items = null)
    {
        $this->rows = $items["rows"] ?? null;
        $this->items = $items["items"] ?? null;
        $this->dataResponse = $items["dataResponse"] ?? null;
        $this->mess = $items["mess"] ?? null;
        $this->status = $items["status"] ?? null;
        $this->params = $items["params"] ?? null;
        $this->columns = $items["columns"] ?? null;
        $this->indexPage = $items["indexPage"] ?? 1;
        $this->number = $items["number"] ?? 10;
        $this->totalrows = $items["totalrows"] ?? 0;
        $this->totalPage = ceil($this->totalrows / $this->number);
    }

    public function SendResponse()
    {

    }

    public static function ToJson($items)
    {
        return json_encode($items, JSON_UNESCAPED_UNICODE);
    }
    public function ToArray()
    {
        $r = (array) $this;
        $r["totalPage"] = ceil($this->totalrows / $this->number);
        return $r;
    }
}