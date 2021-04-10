<?php

namespace App\Models;

use App\Lib\DBConn;

class Product
{
    private $db;
    private $table = 'products';
    private $response;

    public function __CONSTRUCT()
    {
        $this->db = DBConn::StartUp();
    }

    /*
     * get all products
     */

    public function getAll()
    {
        try {

            $stm = $this->db->prepare("SELECT id, description, price FROM $this->table");

            $stm->execute();

            $this->response = array('response' => $stm->fetchAll(), 'message' => '');

            return $this->response;

        } catch (\Exception $e) {

            $this->response = array('response' => false, 'message' => $e->getMessage());
            return $this->response;

        }
    }

    /*
     * get only one product
     */

    public function get(int $prodId)
    {
        try {

            $sql = "SELECT id, description, price FROM $this->table where id = :productId";

            $stm = $this->db->prepare($sql);

            $prodId = htmlspecialchars(strip_tags($prodId));
            $stm->bindParam(":productId", $prodId);
            $stm->execute();

            $this->response = array('response' => $stm->fetchAll(), 'message' => '');

            return $this->response;

        } catch (\Exception $e) {

            $this->response = array('response' => false, 'message' => $e->getMessage());
            return $this->response;

        }
    }

    /*
     * update an existing product or creates a new one
     */

    public function updateOrCreate(string $prodDescription, float $prodPrice, int $prodId = null)
    {

        if(($prodPrice <= 0)||($prodDescription === "")){
            $this->response = array('response' => false, 'message' => 'Debe completar todos los campos');

            return $this->response;
        }

        if (!is_null($prodId)) {

            $sql = "UPDATE $this->table SET description = :prodDescription, price = :prodPrice where id = :prodId";

            $stm = $this->db->prepare($sql);

            $prodId = htmlspecialchars(strip_tags($prodId));

            $stm->bindParam(":prodId", $prodId);

        } else {

            $sql = "INSERT INTO $this->table (description, price) values (:prodDescription, :prodPrice)";

            $stm = $this->db->prepare($sql);

        }

        $prodDescription = htmlspecialchars(strip_tags($prodDescription));
        $prodPrice = htmlspecialchars(strip_tags($prodPrice));

        $stm->bindParam(":prodDescription", $prodDescription);
        $stm->bindParam(":prodPrice", $prodPrice);

        try {

            $stm->execute();
            $this->response = array('response' => true, 'message' => '');

            return $this->response;

        } catch (\Exception $e) {

            $this->response = array('response' => false, 'message' => $e->getMessage());

            return $this->response;

        }
    }

    /*
     * Deletes one product
     */

    public function destroy(int $prodId)
    {
        try {

            $sql = "DELETE FROM $this->table where id = :productId";

            $stm = $this->db->prepare($sql);

            $prodId = htmlspecialchars(strip_tags($prodId));
            $stm->bindParam(":productId", $prodId);
            $stm->execute();

            $this->response = array('response' => true, 'message' => '');

            return $this->response;

        } catch (\Exception $e) {

            $this->response = array('response' => false, 'message' => $e->getMessage());
            return $this->response;

        }
    }
}