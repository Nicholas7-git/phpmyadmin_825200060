<?php namespace App\Controllers;
 
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\RekeningModel;
 
class Rekening extends ResourceController
{
    use ResponseTrait;
    // get all product
    public function index()
    {
        $model = new RekeningModel();
        $data = $model->findAll();
        return $this->respond($data, 200);
    }
 
    // get single product
    public function show($id = null)
    {
        $model = new RekeningModel();
        $data = $model->getWhere(['NamaRekening' => $id])->getResult();
        if($data){
            return $this->respond($data);
        }else{
            return $this->failNotFound('No Data Found with id '.$id);
        }
    }
 
    // create a product
    public function create()
    {
        $model = new RekeningModel();
        $data = [
            'MerchantName' => $this->request->getPost('MerchantName'),
            'NoRekening' => $this->request->getPost('NoRekening'),
            'NamaRekening' => $this->request->getPost('NamaRekening'),
            'SaldoRekening' => $this->request->getPost('SaldoRekening')
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
        $model = new RekeningModel();
        $json = $this->request->getJSON();
        if($json){
            $data = [
                'MerchantName' => $json->MerchantName,
                'NoRekening' => $json->NoRekening,
                'NamaRekening' => $json->NamaRekening,
                'SaldoRekening' => $json->SaldoRekening
            ];
        }else{
            $input = $this->request->getRawInput();
            $data = [
                'MerchantName' => $input['MerchantName'],
                'NoRekening' => $input['NoRekening'],
                'NamaRekening' => $input['NamaRekening'],
                'SaldoRekening' => $input['SaldoRekening']
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
        $model = new RekeningModel();
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