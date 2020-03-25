<?php

/**
 * 政策库
 */
namespace app\admin\controller;

use app\admin\model\Policy as PolicyModel;
use think\Db;
use think\facade\Url;
use think\Request;


class Policy extends Base
{

    protected $policyModel;
    protected $paramArr;

    public function initialize()
    {
        parent::initialize();
        if (!$this->checkLogin()) {
            $this->redirect($this->loginUrl);
        }
    }

    /**
     * 构造函数
     * Index constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->policyModel = new policyModel();
        $this->paramArr = [];
    }


    /**
     * @param Request $request
     * @return array|mixed
     * @throws \Exception
     */
    public function index(Request $request)
    {
        if ($request->isPost()) {
            return $this->handleUserAction($this->paramArr, $this->policyModel, '', 'get');
        }
        return $this->setFetch('index/policyList', array(
            'count' => $this->policyModel->count(['status' => 1]),
            'exportUrl' => Url::build('Policy/exportPolicyList'),
            'getUrl' => Url::build('Policy/index'),
            'delUrl' => Url::build('Policy/delete')
        ));
    }


    /**
     * @param Request $request
     * @return array
     */
    public function exportPolicyList(Request $request)
    {
        try{
            if ($request->file()) {
                $baseUrl = './public/uploads/';
                $file = $request->file('file');
                $info = $file->move($baseUrl);
                if ($info) {
                    $fileName = $baseUrl . $info->getSaveName();
                    if (!file_exists($fileName)) {
                        exit("文件" . $fileName . "不存在");
                    }
                    include_once './vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php';
                    $objPHPExcel = \PHPExcel_IOFactory::load($fileName);
                    $sheetSelected = 0;
                    $objPHPExcel->setActiveSheetIndex($sheetSelected);
                    $rowCount = $objPHPExcel->getActiveSheet()->getHighestRow();
                    $columnCount = $objPHPExcel->getActiveSheet()->getHighestColumn();
                    $dataArr = array();
                    for ($row = 1; $row <= $rowCount; $row++) {
                        for ($column = 'A'; $column <= $columnCount; $column++) {
                            $dataArr[] = $objPHPExcel->getActiveSheet()->getCell($column . $row)->getValue();
                        }
                    }
                    if(substr($fileName,0,2) == './'){
                        $fileName = rtrim((substr($fileName,0,2)=='./'?BASE_PATH.substr($fileName,1):$fileName),'/');
                        chmod($baseUrl,0777);
                        @unlink(str_replace('/','\\',$fileName));
                    }
                    if (is_array($dataArr)) foreach ($dataArr as $key => $value) {
                        if ($key <= 2) unset($dataArr[$key]);
                        if (empty($value)) unset($dataArr[$key]);
                    }
                    $nameList = $this->policyModel->findAll(['status' => 1], 'name');
                    $newData = array_chunk(array_values($dataArr), 3);
                    if (is_array($newData)) foreach ($newData as $key => $value) {
                        if (in_array(trim($value[2]), $nameList)){
                            unset($newData[$key]);
                            continue;
                        }
                        $newData[$key] = array(
                            'address' => $value[1],
                            'name' => $value[2],
                            'create_time' => time(),
                            'update_time' => time()
                        );
                    }
                    $result = Db::name('policy')->data(array_values($newData))->insertAll();
                    if (is_numeric($result)) {
                        return array('code' => 200, 'msg' => '操作成功');
                    } else {
                        return array('code' => 400, 'msg' => '操作成功,但是没有新增记录产生');
                    }
                } else {
                    echo $file->getError();
                }
            }
        }catch (\Exception $exception){
            return array('code' => 500, 'msg' => '系统异常');
        }
    }


    /**
     * 修改
     * @return array
     * @param Request $request
     * @throws \Exception
     */
    public function edit(Request $request)
    {
        if ($request->isPost()) {
            return $this->handleUserAction($this->paramArr, $this->policyModel, '', 'edit');
        }
        $id = $request->param('id');
        $info = $this->policyModel->find(['id' => $id]);
        return $this->setFetch('index/editPolicy', array(
            'info' => $info,
            'editUrl' => Url::build('Policy/edit'),
            'uploadUrl' => Url::build('Policy/uploadFile')
        ));
    }


    /**
     * @return array
     * @param Request $request
     * @throws \Exception
     */
    public function delete(Request $request)
    {
        if ($request->isPost()) {
            return $this->handleUserAction($this->paramArr, $this->policyModel, '', 'delete');
        }
    }


    /**
     * 上传附件
     * @param Request $request
     * @return array
     */
    public function uploadFile(Request $request)
    {
        if ($request->file()) {
            $baseUrl = './public/uploads/files/';
            if(!is_dir($baseUrl)){
                mkdir($baseUrl);
            }
            $file = $request->file('file');
            $info = $file->move($baseUrl);
            if ($info) {
                $id = $request->post('id');
                $fileUrl =  '/demo/public/uploads/files/'.$info->getSaveName();
                $result = $this->policyModel->edit(array(
                    'id' => $id,
                    'fileUrl' => $fileUrl
                ));
                return $result;
            }
        }
    }


}
