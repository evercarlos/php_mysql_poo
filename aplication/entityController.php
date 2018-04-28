<?php
/**
 * Created by PhpStorm.
 * User: ECR
 * Date: 27/04/2018
 * Time: 10:28 AM
 */

require_once 'entity.php';
require '../vendor/autoload.php';

use Carbon\Carbon;

class entityController
{
    public function seach($s)
    {
        try {
            $data_repo = new entity();
            $data_repo = $data_repo->search($s);
            Carbon::setLocale('es');

            foreach ($data_repo as $dat) {
                $data[] = [
                    'id' => $dat['id'],
                    'name' => $dat['name'],
                    'dni' => $dat['dni'],
                    'birth_date' => (is_null($dat['birth_date'])) ? '' : ($dat['birth_date'] == '0000-00-00') ? '' : Carbon::parse($dat['birth_date'])->format('d/m/Y')
                ];
            }
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

    function createUpdate($request)
    {
        try {
            $data = $request;
            Carbon::setLocale('es');
            $repo = new entity();
            $data['birth_date'] = ($data['birth_date'] == "") ? null : Carbon::createFromFormat('d/m/Y', $data['birth_date']);
            // echo $data['birth_date'];
            //var_dump($data['birth_date']);
            if ($data['id'] != 0) {
                $repo->update($data['id'], $data);
            } else {
                $repo->create($data);
            }

            echo json_encode([
                'status' => true
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

            $data['birth_date'] = (is_null($data['birth_date'])) ? '' : ($data['birth_date'] = '0000-00-00') ? '' : Carbon::parse($data['birth_date'])->format('d/m/Y');

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
    case 'createUpdate':
        $met = $obj->createUpdate($_REQUEST);
        break;
    case 'delete':
        $met = $obj->destroy($_REQUEST['id']);
        break;
}

return $met;






