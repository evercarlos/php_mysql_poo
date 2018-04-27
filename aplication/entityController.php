<?php
/**
 * Created by PhpStorm.
 * User: ECR
 * Date: 27/04/2018
 * Time: 10:28 AM
 */

require_once 'entity.php';

class entityController
{
    public function seach($s)
    {
        try {
            $data = new entity();
            $data = $data->search($s);

            echo json_encode([
                'status' => true,
                'data' => $data
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function find($id)
    {
        try {
            $data = new entity();
            $data = $data->find($id);
            echo json_encode([
                'status' => true,
                'data' => $data
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    function destroy($id)
    {
        try {
            $data = new  entity();
            $data->destroy($id);

            echo json_encode([
                'status' => true
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'status' => false
            ]);
        }
    }
}

$method = $_REQUEST['method'];
$obj = new entityController();

// con entr view and ccntroller
switch ($method) {
    case 'list':
        $met = $obj->seach($_REQUEST['search']);
        break;
    case 'find':
        $met = $obj->find($_REQUEST['id']);
        break;
    case 'delete':
        $met = $obj->destroy($_REQUEST['id']);
        break;
}

return $met;






