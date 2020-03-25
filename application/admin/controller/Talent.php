<?php

namespace app\admin\controller;


use app\admin\model\Talent as TalentModel;
use think\Db;
use think\facade\Url;
use think\Request;


class Talent extends Base
{

    protected $talentModel;
    protected $paramArr;

    public function initialize()
    {
        parent::initialize();
        if (!$this->checkLogin()) {
            $this->redirect('/admin.php/User/login');
        }
    }

    /**
     * 构造函数
     * Index constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->talentModel = new TalentModel();
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
            return $this->handleUserAction($this->paramArr, $this->talentModel, '', 'get');
        }
        return $this->fetch('index/talentList', array(
            'count' => $this->talentModel->count(['status' => 1]),
            'exportUrl' => Url::build('Talent/exportTalentList'),
            'getUrl' => Url::build('Talent/index'),
            'delUrl' => Url::build('Talent/delete')
        ));
    }


    /**
     * @param Request $request
     * @return array
     */
    public function exportTalentList(Request $request)
    {
        try {
            if ($request->file()) {
                $baseUrl = './public/uploads/';
                $file = $request->file('file');
                $info = $file->move($baseUrl);
                if ($info) {
                    $fileName = $baseUrl . $info->getSaveName();
                    if (!file_exists($fileName)) {
                        exit("文件" . $fileName . "不存在");
                    }
                    require_once './vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php';
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
                    if (is_array($dataArr)) foreach ($dataArr as $key => $value) {
                        if ($key <= 21) unset($dataArr[$key]);
                    }
                    $nameList = $this->talentModel->findAll(['status' => 1], 'name');
                    $newData = array_chunk(array_values($dataArr), 11);
                    if (is_array($newData)) foreach ($newData as $key => $value) {
                        if (in_array(trim($value[1]), $nameList)) {
                            unset($newData[$key]);
                            continue;
                        }
                        $newData[$key] = array(
                            'name' => $value[1],
                            'subject_name' => $value[4],
                            'school_name' => $value[3],
                            'job_name' => $value[2]?:'',
                            'first_part' => $value[8]?:'',
                            'second_part' => $value[9]?:'',
                            'third_part' => $value[10]?:'',
                            'subject_part' => $value[6]?:'',
                            'email' => $value[5],
                            'create_time' => time(),
                            'update_time' => time()
                        );
                    }
                    $result = Db::name('talent')->data(array_values($newData))->insertAll();
                    if (is_numeric($result)) {
                        return array('code' => 200, 'msg' => '操作成功');
                    } else {
                        return array('code' => 400, 'msg' => '操作成功,但是没有新增记录产生');
                    }
                } else {
                    echo $file->getError();
                }
            }
        } catch (\Exception $exception) {
            return array('code' => 500, 'msg' => '系统异常');
        }
    }


    /**
     * 修改号码
     * @return array
     * @param Request $request
     * @throws \Exception
     */
    public function edit(Request $request)
    {
        if ($request->isPost()) {
            return $this->handleUserAction($this->paramArr, $this->talentModel, '', 'edit');
        }
        $id = $request->param('id');
        $info = $this->talentModel->find(['id' => $id]);
        return $this->fetch('index/editTalent', array(
            'info' => $info,
            'editUrl' => Url::build('Talent/edit')
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
            return $this->handleUserAction($this->paramArr, $this->talentModel, '', 'delete');
        }
    }


}
