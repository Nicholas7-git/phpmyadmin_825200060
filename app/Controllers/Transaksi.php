<?php namespace App\Controllers;
 
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\TransaksiModel;
 
class Transaksi extends ResourceController
{
    use ResponseTrait;
    // get all product
    public function index()
    {
        $model = new TransaksiModel();
        $data = $model->findAll();
        return $this->respond($data, 200);
    }
 
    // get single product
    public function show($id = null)
    {
        $model = new TransaksiModel();
        $data = $model->getWhere(['id' => $id])->getResult();
        if($data){
            return $this->respond($data);
        }else{
            return $this->failNotFound('No Data Found with id '.$id);
        }
    }
 
    // create a product
    public function create()
    {
        $model = new TransaksiModel();
        $data = [
            'FromRekeningID' => $this->request->getPost('FromRekeningID'),
            'TORekeningID' => $this->request->getPost('TORekeningID'),
            'NominalTransaksi' => $this->request->getPost('NominalTransaksi'),
            'TitleTransaksi' => $this->request->getPost('TitleTransaksi'),
            'RemarksTransaksi' => $this->request->getPost('RemarksTransaksi'),
            'DateTransaksi' => date("Y-m-d")
        ];
        $data = json_decode(file_get_contents("php://input"));
         
        $model->insert($data);
        $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => [
                'success' => 'Data Saved'
            ]
        ];
         
        return $this->respondCreated($data, 201);
    }
 
    // update product
    public function update($id = null)
    {
        $model = new TransaksiModel();
        $json = $this->request->getJSON();
        if($json){
            $data = [
                'FromRekeningID' => $json->FromRekeningID,
                'TORekeningID' => $json->TORekeningID,
                'TitleTransaksi' => $json->TitleTransaksi,
                'RemarksTransaksi' => $json->RemarksTransaksi,
                'DateTransaksi' => $json->DateTransaksi
            ];
        }else{
            $input = $this->request->getRawInput();
            $data = [
                'FromRekeningID' => $input['FromRekeningID'],
                'TORekeningID' => $input['TORekeningID'],
                'TitleTransaksi' => $input['TitleTransaksi'],
                'RemarksTransaksi' => $input['RemarksTransaksi'],
                'DateTransaksi' => $input['DateTransaksi']
            ];
        }
        // Insert to Database
        $model->update($id, $data);
        $response = [
            'status'   => 200,
            'error'    => null,
            'messages' => [
                'success' => 'Data Updated'
            ]
        ];
        return $this->respond($response);
    }
 
    // delete product
    public function delete($id = null)
    {
        $model = new TransaksiModel();
        $data = $model->find($id);
        if($data){
            $model->delete($id);
            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success' => 'Data Deleted'
                ]
            ];
             
            return $this->respondDeleted($response);
        }else{
            return $this->failNotFound('No Data Found with id '.$id);
        }
         
    }
 
}