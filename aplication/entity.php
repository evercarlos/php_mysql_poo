<?php
/**
 * Created by PhpStorm.
 * User: ECR
 * Date: 27/04/2018
 * Time: 09:50 AM
 */

require_once 'conecction.php';

class entity extends conecction
{
    public function search($s)
    {
        try {
            $sql = "SELECT * FROM entity WHERE name LIKE '$s%'or dni LIKE '%$s%' LIMIT 10";
            $result = mysql_query($sql) or die('error al buscar o seleccionar');
            while ($row = mysql_fetch_array($result)) {
                $data[] = [
                    'id' => $row['id'],
                    'name' => $row['name'],
                    'dni' => $row['dni'],
                    'birth_date' => $row['birth_date']
                ];
            }
            return $data;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function find($id)
    {
        try {
            $sql = "SELECT * FROM entity WHERE id= '" . $id . "'";
            $result = mysql_query($sql) or die('error of search');
            $row = mysql_fetch_row($result) or die('error of result');
            $data = [
                'id' => $row[0],
                'name' => $row[1],
                'dni' => $row[2],
                'birth_date' => $row[3],
            ];

            return $data;

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function create($attributes)
    {
        try {
            $sql = "INSERT INTO entity(name,dni,birth_date) VALUES('" . $attributes['name'] . "','" . $attributes['dni'] . "', '" . $attributes['birth_date'] . "')";
            mysql_query($sql) or die('Error al guardar');
            // retornar el ultmo registro
            //end
            return '';
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function update($id, $attributes)
    {
        try {
            $sql = "UPDATE entity SET name='" . $attributes['name'] . "',dni='" . $attributes['dni'] . "',birth_date='" . $attributes['birth_date'] . "' 
                    WHERE id='" . $id . "'";
            mysql_query($sql) or die('Error al actualizar');

            return '';
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function destroy($id)
    {
        try {

            $sql = "DELETE FROM entity WHERE id='" . $id . "'";
            mysql_query($sql) or die('error al eliminar models');

            return 0;

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}


