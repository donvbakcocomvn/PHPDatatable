<?php

namespace Datatable;

class Table
{
    public $rows;
    public $tableProp;
    public $tbodyProp;
    public $theadProp;
    public $classname;
    public $columns;
    public $hasActions;

    public function __construct($dataTable, $classname, $hasActions = true)
    {
        $this->rows = $dataTable["rows"] ?? [];
        $this->columns = $dataTable["columns"] ?? [];
        $this->classname = $classname;
        $this->hasActions = $hasActions;
    }

    public function GetActions($actions, $params = [])
    {
        // $actions = "/quanlythe/index/index/?name=";
    }
    public function GetRows()
    {
        $rows = [];
        $class = $this->classname;
        foreach ($this->rows as $key => $value) {
            $value["Actions"] = "BtnGroup Method";
            if (method_exists($class, "BtnGroup")) {
                $obj = new $class($value);
                $value["Actions"] = $obj->BtnGroup();
            }
            $rows[$key] = $value;
        }
        return $rows;
    }

    public function GetColumns()
    {
        $col = $this->columns;
        if ($this->hasActions == true) {
            $col["Actions"] = "lblAction";
        }
        return $col;

    }
    public function GetHtml()
    {
        $className = $this->classname;
        ?>
        <table class="table table-border">
            <tr class="bg-primary">
                <?php
                foreach ($this->GetColumns() as $key => $title) {
                    ?>
                    <th><?php echo $key == "Actions" ? "Action" : $title; ?></th>
                    <?php
                }
                ?>
            </tr>

            <?php
            foreach ($this->GetRows() as $key => $row) {
                $item = new $className($row);
                if (method_exists($className, "ToRow")) {
                    foreach ($item->ToRow($key) as $k => $v) {
                        $row[$k] = $v;
                    }
                }
                ?>
                <tr>
                    <?php
                    foreach ($this->GetColumns() as $columnName => $title) {
                        ?>
                        <td><?php echo $row[$columnName]; ?></td>
                        <?php
                    }
                    ?>
                </tr>
                <?php
            }
            ?>
        </table>
        <?php
    }

    public function setPropTable($table)
    {
        $tbl = "";
        $tablePro = $table["table"] ?? [];
        foreach ($tablePro as $key => $value) {
            $tbl .= $key . ' = "' . $value . '" ';
        }
        $this->tableProp = $tbl;
        $tbody = "";
        $tablePro = $table["tbody"] ?? [];
        foreach ($tablePro as $key => $value) {
            $tbody .= $key . ' = "' . $value . '" ';
        }
        $this->tbodyProp = $tbody;

        $thear = "";
        $tablePro = $table["thead"] ?? [];
        foreach ($tablePro as $key => $value) {
            $thear .= $key . ' = "' . $value . '" ';
        }
        $this->theadProp = $thear;
    }

    public function RenderHtml()
    {
        $className = $this->classname;
        ?>
        <table <?php echo $this->tableProp; ?>>
            <thead <?php echo $this->theadProp; ?>>
                <tr>
                    <?php
                    foreach ($this->GetColumns() as $key => $title) {
                        ?>
                        <th><?php echo $key == "Actions" ? "Action" : $title; ?></th>
                        <?php
                    }
                    ?>
                </tr>
            </thead>
            <tbody <?php echo $this->tbodyProp; ?>>
                <?php
                foreach ($this->GetRows() as $key => $row) {
                    $item = new $className($row);
                    if (method_exists($className, "ToRow")) {
                        foreach ($item->ToRow($key) as $k => $v) {
                            $row[$k] = $v;
                        }
                    }
                    ?>
                    <tr>
                        <?php
                        foreach ($this->GetColumns() as $columnName => $title) {
                            ?>
                            <td>
                                <?php echo $row[$columnName]; ?>
                            </td>
                            <?php
                        }
                        ?>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
        <?php
    }
    public function GetlinkPTByAction($params, $link = "")
    {
        unset($params["indexPage"]);
        $query_String = http_build_query($params);
        return "{$link}?{$query_String}&indexPage=[i]";
    }
    public function PaginationWidthData($data, $link)
    {
        $totalPage = $data["totalPage"] ?? 0;
        $indexPage = $data["indexPage"] ?? 1;
        $params = $data["params"] ?? [];
        return $this->Pagination($totalPage, $indexPage, $this->GetlinkPTByAction($params, $link));
    }
    public function Pagination($totalPage, $indexPage, $link)
    {
        $HtmlPagination = ' <ul class="pagination mt-10 mb-0">';
        $HtmlPagination .= "<li><a>{$indexPage}/{$totalPage}</a></li>";
        $from = $indexPage - 4;
        $to = $indexPage + 4;
        $from = $from <= 0 ? 1 : $from;
        if ($from > 1) {
            $link1 = str_replace("[i]", 1, $link);
            $HtmlPagination .= '<li><a href="' . $link1 . '"><<</a></li>';
        }
        if ($from > 1) {
            $link1 = str_replace("[i]", $indexPage - 1, $link);
            $HtmlPagination .= '<li><a href="' . $link1 . '"><</a></li>';
        }

        $to = $to >= $totalPage ? $totalPage : $to;
        for ($i = $from; $i <= $to; $i++) {
            $link1 = str_replace("[i]", $i, $link);
            if ($i == $indexPage)
                $HtmlPagination .= '<li class="active" ><a href="' . $link1 . '">' . $i . '</a></li>';
            else
                $HtmlPagination .= '<li><a href="' . $link1 . '">' . $i . '</a></li>';
        }

        if ($to < $totalPage) {
            $link1 = str_replace("[i]", $indexPage + 1, $link);
            $HtmlPagination .= '<li><a href="' . $link1 . '">></a></li>';
        }
        if ($to < $totalPage) {
            $link1 = str_replace("[i]", $totalPage, $link);
            $HtmlPagination .= '<li><a href="' . $link1 . '">>></a></li>';
        }
        $HtmlPagination .= '</ul>';
        return $HtmlPagination;
    }

}

?>