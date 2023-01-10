## Project Overview
## System Requirements
PHP >= 7.0
## Installation Instructions
Composer is the easiest way to manage dependencies in your project. Create a file named composer.json with the following:
```json
{
    "require": {
       "namdongvando/phpdatatable": "^1.22"
    }
}
```
And run Composer to install Datatable:

```bash
composer require namdongvando/phpdatatable
```

## Code Samples

```php
<?php
include("../src/Response.php");
include("../src/ITable.php");
include("../src/Table.php");
include("ModelAny.php");
use Datatable\Response;
use Datatable\Table;

$mdoelAny = new ModelAny();
$items[] = ["Id" => 1, "Name" => "Name1"];
$items[] = ["Id" => 2, "Name" => "Name2"];
$items[] = ["Id" => 3, "Name" => "Name3"];
$items[] = ["Id" => 4, "Name" => "Name4"];
$items[] = ["Id" => 5, "Name" => "Name5"];
$response = new Response();
$response->params = ["number" => 1, "keyword" => $_GET["keyword"] ?? ""];
$response->totalrows = 10;
$response->number = 1;
$response->indexPage = 1;
$response->rows = $items;
$response->status = Response::OK;
$response->columns = ["Id" => "Id", "Name" => "Name"];
$data = $response->ToArray();
?>
<!DOCTYPE html>
<html lang="">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Examples Datatable</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <h1 class="text-center">Datatable</h1>

    <div>
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">List Items</h3>
            </div>
            <div class="box-body">
                <?php
                $link = "/examples/index.php";
                // $dataTable = new Table(["rows" => $data["rows"], "columns" => $columns], Card::class);
                $dataTable = new Table(["rows" => $response->rows, "columns" => $response->columns], ModelAny::class);
                $dataTable->setPropTable(
                    [
                        "table" => ["id" => "table", "class" => "table table-border"],
                        "thead" => ["class" => "bg-primary"],
                    ]
                );
                $dataTable->RenderHtml();
                echo $dataTable->PaginationWidthData($data, $link);
                ?>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>

</html>
```
