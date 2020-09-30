<?php
class Factura
{
    private $pdo;

    public function __CONSTRUCT()
    {
        try
        {
            $this->pdo = new PDO('mysql:host=localhost;dbname=db', '', '');
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);                
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function Consulta()
    {
        try
        {
            $result = array();

            $stm = $this->pdo->prepare("SELECT * FROM factura");
            $stm->execute();

            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r)
            {
                $alm = new factura();

                $alm->__SET('id', $r->id);
                $alm->__SET('FechaEmision', $r->FechaEmision);
                $alm->__SET('FechaVencimiento', $r->FechaVencimiento);

                $result[] = $alm;
            }

            return $result;
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }


    public function Eliminar($id)
    {
        try 
        {
            $stm = $this->pdo
                      ->prepare("DELETE FROM factura WHERE id = ?");                      

            $stm->execute(array($id));
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }

    public function Actualizar(Factura $data)
    {
        try 
        {
            $sql = "UPDATE factura SET 
                        FechaEmision    = ?, 
                        FechaVencimiento = ?,
                        Precio =?
                    WHERE id = ?";

            $this->pdo->prepare($sql)
                 ->execute(
                array(
                    $data->__GET('FechaEmision'), 
                    $data->__GET('FechaVencimiento'), 
                    $data->__GET('Precio')
                    )
                );
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }

    public function Altas(Factura $data)
    {
        try 
        {
        $sql = "INSERT INTO detalle_factura (FechaEmision,FechaVencimiento) 
                VALUES (?, ?)";

        $this->pdo->prepare($sql)
             ->execute(
            array(
                $data->__GET('FechaEmision'), 
                $data->__GET('FechaVencimiento'), 
                )
            );
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }
}