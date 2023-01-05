<?php
use Datatable\ITable;

class ModelAny implements ITable
{

    public $Id;
    public $Name;

    public function __construct($item = null)
    {
        $this->Id = $item["Id"] ?? null;
        $this->Name = $item["Name"] ?? null;
    }

    /**
     * @return mixed
     */
    public function BtnGroup()
    {
        return $this->btnEdit($this->Id);
    }

    public function btnEdit($id)
    {
        return "<a href='edit.php?id={$id}' >edit</a>";
    }
    public function btnDelete($id)
    {
        return "<a href='delete.php?id={$id}' >delete</a>";
    }

    /**
     * @return mixed
     */
    public function ToArray()
    {
        return (array) $this;
    }
}



?>