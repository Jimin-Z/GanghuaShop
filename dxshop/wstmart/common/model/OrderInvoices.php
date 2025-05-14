<?php
namespace wstmart\common\model;
use think\Db;
use Env;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 发票详情类
 */
class OrderInvoices extends Base{
    protected $table = 'ws_orders';
    protected $pk = 'orderId';

    /************************************* 商家 *********************************************/
    /**
     * 获取发票详情列表列表
     */
    public function queryShopInvoicesByPage($sId=0){
        $shopId = $sId==0?(int)session('WST_USER.shopId'):$sId;
        $orderNo = (int)input('orderNo');
        $startDate = input('startDate');
        $endDate = input('endDate');
        $isMakeInvoice = (int)input('isMakeInvoice');
        $where = [];
        if($orderNo!='') $where[] = ['o.orderNo','like',"%$orderNo%"];
        if($startDate!='' && $endDate!=''){
            $where[] = ['o.createTime','between',[$startDate.' 00:00:00',$endDate.' 23:59:59']];
        }else if($startDate!=''){
            $where[] = ['o.createTime','>=',$startDate.' 00:00:00'];
        }else if($endDate!=''){
            $where[] = ['o.createTime','<=',$endDate.' 23:59:59'];
        }
        $where[] = ['o.shopId','=',$shopId];
        $where[] = ['o.dataFlag','=',1];
        $where[] = ['o.isInvoice','=',1];
        $where[] = ['o.isMakeInvoice','=',$isMakeInvoice];
        $where[] = ['o.orderStatus','not in','-1,-2'];
        $rs =  Db::name('orders')->alias('o')
            ->field('o.orderNo, o.realTotalMoney, o.invoiceJson, o.createTime, o.orderId')
            ->where($where)
            ->order('o.orderId desc')
            ->paginate(input('limit/d'))
            ->toArray();
        if(count($rs)>0){
            foreach ($rs['data'] as $k=>$v){
                $result = json_decode($v['invoiceJson'],true);
                $rs['data'][$k]['invoiceHead'] = $result['invoiceHead'];
                $rs['data'][$k]['invoiceCode'] = (isset($result['invoiceCode']) && $result['invoiceCode'])?$result['invoiceCode']:'-';
                $rs['data'][$k]['invoiceAddr'] = (isset($result['invoiceAddr']) && $result['invoiceAddr'])?$result['invoiceAddr']:'-';
                $rs['data'][$k]['invoicePhoneNumber'] = (isset($result['invoicePhoneNumber']) && $result['invoicePhoneNumber'])?$result['invoicePhoneNumber']:'-';
                $rs['data'][$k]['invoiceBankName'] = (isset($result['invoiceBankName']) && $result['invoiceBankName'])?$result['invoiceBankName']:'-';
                $rs['data'][$k]['invoiceBankNo'] = (isset($result['invoiceBankNo']) && $result['invoiceBankNo'])?$result['invoiceBankNo']:'-';
            }
        }
        return WSTReturn('ok',1,$rs);
    }

    /**
     * 导出发票
     */
    public function toExport(){
        $name='invoice';
        $where = [];
        $ids = input('ids');
        if($ids != ''){
            $ids = explode(',',WSTFormatIn(',',input('ids')));
            $where[] = ['o.orderId','in',$ids];
        }
        $isMakeInvoice = (int)input('isMakeInvoice');
        $where[] = ['o.isMakeInvoice','=',$isMakeInvoice];
        $where[] = ['o.dataFlag','=',1];
        $where[] = ['o.shopId','=',(int)session('WST_USER.shopId')];
        $where[] = ['o.orderStatus','not in','-1,-2'];
        $where[] = ['o.isInvoice','=',1];

        $page = Db::name('orders')->alias('o')
            ->field('o.orderNo, o.realTotalMoney, o.invoiceJson, o.createTime, o.orderId ,o.isInvoice')
            ->where($where)
            ->order('o.createTime', 'desc')
            ->paginate(input('limit/d'))
            ->toArray();

        if(count($page['data'])>0){
            foreach ($page['data'] as $key => $v){
                $invoiceArr = json_decode($v['invoiceJson'],true);
                $page['data'][$key]['invoiceHead'] = $invoiceArr['invoiceHead'];
                if(isset($invoiceArr['invoiceCode']) && $invoiceArr['invoiceCode']){
                    $page['data'][$key]['invoiceCode'] = $invoiceArr['invoiceCode'];
                }else{
                    $page['data'][$key]['invoiceCode'] = '-';
                }
                $page['data'][$key]['invoiceAddr'] = (isset($invoiceArr['invoiceAddr']) && $invoiceArr['invoiceAddr'])?$invoiceArr['invoiceAddr']:'-';
                $page['data'][$key]['invoicePhoneNumber'] = (isset($invoiceArr['invoicePhoneNumber']) && $invoiceArr['invoicePhoneNumber'])?$invoiceArr['invoicePhoneNumber']:'-';
                $page['data'][$key]['invoiceBankName'] = (isset($invoiceArr['invoiceBankName']) && $invoiceArr['invoiceBankName'])?$invoiceArr['invoiceBankName']:'-';
                $page['data'][$key]['invoiceBankNo'] = (isset($invoiceArr['invoiceBankNo']) && $invoiceArr['invoiceBankNo'])?$invoiceArr['invoiceBankNo']:'-';
                $page['data'][$key]['realTotalMoney'] = $v['realTotalMoney'];
                $page['data'][$key]['createTime'] = $v['createTime'];
            }
        }

        require Env::get('root_path') . 'extend/phpexcel/PHPExcel.php';

        $objPHPExcel = new \PHPExcel();
        // 设置excel文档的属性
        $objPHPExcel->getProperties()->setCreator("WSTMart")//创建人
        ->setLastModifiedBy("WSTMart")//最后修改人
        ->setTitle($name)//标题
        ->setSubject($name)//题目
        ->setDescription($name)//描述
        ->setKeywords("订单")//关键字
        ->setCategory("Test result file");//种类

        // 开始操作excel表
        $objPHPExcel->setActiveSheetIndex(0);
        // 设置工作薄名称
        $objPHPExcel->getActiveSheet()->setTitle(iconv('gbk', 'utf-8', 'Sheet'));
        // 设置默认字体和大小
        $objPHPExcel->getDefaultStyle()->getFont()->setName(iconv('gbk', 'utf-8', ''));
        $objPHPExcel->getDefaultStyle()->getFont()->setSize(11);
        $styleArray = array(
            'font' => array(
                'bold' => true,
                'color'=>array(
                    'argb' => 'ffffffff',
                )
            )
        );
        //设置宽
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(50);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(30);

        $objRow = $objPHPExcel->getActiveSheet()->getStyle('A1:I1');
        $objRow->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID);
        $objRow->getFill()->getStartColor()->setRGB('666699');
        $objRow->getAlignment()->setVertical(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objRow->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(25);

        $objPHPExcel->getActiveSheet()
            ->setCellValue('A1', '订单编号')
            ->setCellValue('B1', '开票金额')
            ->setCellValue('C1', '发票抬头')
            ->setCellValue('D1', '发票税号')
            ->setCellValue('E1', '注册地址')
            ->setCellValue('F1', '注册电话')
            ->setCellValue('G1', '开户银行')
            ->setCellValue('H1', '银行账号')
            ->setCellValue('I1', '下单时间');
        $objPHPExcel->getActiveSheet()->getStyle('A1:I1')->applyFromArray($styleArray);
        $i = 1;
        $totalRow = 0;
        for ($row = 0; $row < count($page['data']); $row++){
            $i = $i+1;
            $i2 = $i3 = $i;
            $objPHPExcel->getActiveSheet()
                ->setCellValue('A'.$i2, $page['data'][$row]['orderNo'])
                ->setCellValue('B'.$i2, $page['data'][$row]['realTotalMoney'])
                ->setCellValue('C'.$i2, " ".$page['data'][$row]['invoiceHead'])
                ->setCellValue('D'.$i2, " ".$page['data'][$row]['invoiceCode'])
                ->setCellValue('E'.$i2, " ".$page['data'][$row]['invoiceAddr'])
                ->setCellValue('F'.$i2, " ".$page['data'][$row]['invoicePhoneNumber'])
                ->setCellValue('G'.$i2, " ".$page['data'][$row]['invoiceBankName'])
                ->setCellValue('H'.$i2, " ".$page['data'][$row]['invoiceBankNo'])
                ->setCellValue('I'.$i2, $page['data'][$row]['createTime']);
        }
        $totalRow = ($totalRow==0)?1:$totalRow-1;
        $objPHPExcel->getActiveSheet()->getStyle('A1:I'.$totalRow)->applyFromArray(array(
            'borders' => array (
                'allborders' => array (
                    'style' => \PHPExcel_Style_Border::BORDER_THIN,  //设置border样式
                    'color' => array ('argb' => 'FF000000'),     //设置border颜色
                )
            )
        ));
        $this->PHPExcelWriter($objPHPExcel,$name);
    }

    /**
     * 批量设置
     */
    public function setByBatch($sId=0){
        $shopId = $sId==0?(int)session('WST_USER.shopId'):$sId;
        $ids = explode(',',WSTFormatIn(',',input('post.ids')));
        $isMakeInvoice = (int)input('isMakeInvoice');
        $data = [];
        $data['o.isMakeInvoice'] = $isMakeInvoice;
        Db::startTrans();
        try{
            $result =  Db::name('orders')->alias('o')
                ->where([['o.shopId','=',$shopId],['o.orderId','in',$ids],['o.dataFlag','=',1],['o.orderStatus','not in','-1,-2']])
                ->update($data);
            if(false !== $result){
                Db::commit();
                return WSTReturn("设置成功", 1);
            }
        }catch (\Exception $e) {
            Db::rollback();
            return WSTReturn('设置失败',-1);
        }
    }
}
