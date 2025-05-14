<?php
namespace wstmart\shop\model;
use wstmart\common\model\Reports as CReports;
use think\Db;
use Env;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 报表类
 */
class Reports extends CReports{

    /**
     * 获取商品销售排行
     */
    public function getTopSaleGoods($sId=0){
        $startDate=input('startDate');
        $endDate=input('endDate');
        if(empty($startDate)&&empty($endDate)){
            $start=date('Y-m-d 00:00:00',strtotime("-1 months"));
            $end=date('Y-m-d 23:59:59');
        }else{
            $start = date('Y-m-d 00:00:00',strtotime($startDate));
            $end = date('Y-m-d 23:59:59',strtotime($endDate));
        }
        $shopId = ($sId==0)?(int)session('WST_USER.shopId'):$sId;
        $prefix = config('database.prefix');
        $rs = Db::table($prefix.'order_goods')->alias([$prefix.'order_goods'=>'og',$prefix.'orders'=>'o',$prefix.'goods'=>'g'])
            ->join($prefix.'orders','og.orderId=o.orderId')
            ->join($prefix.'goods','og.goodsId=g.goodsId')
            ->order('goodsNum desc')
            ->whereTime('o.createTime','between',[$start,$end])
            ->where([['o.orderStatus','>=',0]])
            ->where('(payType=0 or (payType=1 and isPay=1)) and o.dataFlag=1 and o.shopId='.$shopId)->group('og.goodsId')
            ->field('og.goodsId,g.goodsName,g.goodsSn,sum(og.goodsNum) goodsNum,g.goodsImg')
            ->paginate(input('limit/d'))->toArray();
        return $rs;
    }

    /**
     * 导出商品销售排行Excel
     */
    public function toExportTopSaleGoods(){
        $name='report';
        $start = date('Y-m-d 00:00:00',strtotime(input('startDate')));
        $end = date('Y-m-d 23:59:59',strtotime(input('endDate')));
        $prefix = config('database.prefix');
        $start = date('Y-m-d 00:00:00',strtotime(input('startDate')));
        $end = date('Y-m-d 23:59:59',strtotime(input('endDate')));
        $shopId = (int)session('WST_USER.shopId');
        $prefix = config('database.prefix');
        $rs = Db::table($prefix.'order_goods')->alias([$prefix.'order_goods'=>'og',$prefix.'orders'=>'o',$prefix.'goods'=>'g'])
          ->join($prefix.'orders','og.orderId=o.orderId')
          ->join($prefix.'goods','og.goodsId=g.goodsId')
          ->order('goodsNum desc')
          ->whereTime('o.createTime','between',[$start,$end])
          ->where([['o.orderStatus','>=',0]])
          ->where('(payType=0 or (payType=1 and isPay=1)) and o.dataFlag=1 and o.shopId='.$shopId)->group('og.goodsId')
          ->field('og.goodsId,g.goodsName,g.goodsSn,sum(og.goodsNum) goodsNum,g.goodsImg')
          ->select();
        require Env::get('root_path') . 'extend/phpexcel/PHPExcel/IOFactory.php';
        $objPHPExcel = new \PHPExcel();
        // 设置excel文档的属性
        $objPHPExcel->getProperties()->setCreator("WSTMart")//创建人
        ->setLastModifiedBy("WSTMart")//最后修改人
        ->setTitle($name)//标题
        ->setSubject($name)//题目
        ->setDescription($name)//描述
        ->setKeywords("商品销售排行");//种类
        // 开始操作excel表
        $objPHPExcel->setActiveSheetIndex(0);
        // 设置工作薄名称
        $objPHPExcel->getActiveSheet()->setTitle(iconv('gbk', 'utf-8', 'Sheet'));
        // 设置默认字体和大小
        $objPHPExcel->getDefaultStyle()->getFont()->setName(iconv('gbk', 'utf-8', ''));
        $objPHPExcel->getDefaultStyle()->getFont()->setSize(11);
        $styleArray = array('font' =>array('bold' => true, 'color'=>array('argb' => 'ffffffff', ) )  );
        //设置宽
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(60);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(16);
        $objRow = $objPHPExcel->getActiveSheet()->getStyle('A1:C1');
        $objRow->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID);
        $objRow->getFill()->getStartColor()->setRGB('666699');
        $objRow->getAlignment()->setVertical(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objRow->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(25);
        $objPHPExcel->getActiveSheet()
        ->setCellValue('A1', '商品名称')
        ->setCellValue('B1', '商品编号')
        ->setCellValue('C1', '销量');
        $objPHPExcel->getActiveSheet()->getStyle('A1:C1')->applyFromArray($styleArray);
        $i = 1;
        $totalRow = 0;
        for ($row = 0; $row < count($rs); $row++){
            $i = $row+2;
            $objPHPExcel->getActiveSheet()
            ->setCellValue('A'.$i, $rs[$row]['goodsName'])
            ->setCellValue('B'.$i, " ".$rs[$row]['goodsSn'])
            ->setCellValue('C'.$i, $rs[$row]['goodsNum']);
            $totalRow++;
        }
        $totalRow = ($totalRow==0)?1:$totalRow+1;
        $objPHPExcel->getActiveSheet()->getStyle('A1:C'.$totalRow)->applyFromArray(array(
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
     * 销售额统计Excel
     */
    public function toExportStatSales(){
        $name = 'report';
        $rdata = $this->getStatSales();
        $rs = empty($rdata)?[]:(isSet($rdata['data'])?$rdata['data']:[]);
        require Env::get('root_path') . 'extend/phpexcel/PHPExcel/IOFactory.php';
        $objPHPExcel = new \PHPExcel();
        // 设置excel文档的属性
        $objPHPExcel->getProperties()->setCreator("WSTMart")//创建人
        ->setLastModifiedBy("WSTMart")//最后修改人
        ->setTitle($name)//标题
        ->setSubject($name)//题目
        ->setDescription($name)//描述
        ->setKeywords("销售额统计");//种类
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
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $objRow = $objPHPExcel->getActiveSheet()->getStyle('A1:C1');
        $objRow->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID);
        $objRow->getFill()->getStartColor()->setRGB('666699');
        $objRow->getAlignment()->setVertical(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objRow->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(25);
        $objPHPExcel->getActiveSheet()
        ->setCellValue('A1', '日期')
        ->setCellValue('B1', '订单数')
        ->setCellValue('C1', '销售额');
        $objPHPExcel->getActiveSheet()->getStyle('A1:C1')->applyFromArray($styleArray);
        $i = 1;
        $totalRow = 0;
        if(isSet($rs['list'])){
            for ($row = 0; $row < count($rs['list']); $row++){
                $i = $row+2;
                $objPHPExcel->getActiveSheet()
                ->setCellValue('A'.$i, $rs['list'][$row]['day'])
                ->setCellValue('B'.$i, $rs['list'][$row]['num'])
                ->setCellValue('C'.$i, $rs['list'][$row]['val']);
                $totalRow++;
            }
        }
        $totalRow = ($totalRow==0)?1:$totalRow+1;
        $objPHPExcel->getActiveSheet()->getStyle('A1:C'.$totalRow)->applyFromArray(array(
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
     * 订单统计导出Excel
     */
    public function toExportStatOrders(){
        $name = 'report';
        $rdata = $this->getStatOrders();
        $rs = empty($rdata)?[]:$rdata['data'];
        require Env::get('root_path') . 'extend/phpexcel/PHPExcel/IOFactory.php';
        $objPHPExcel = new \PHPExcel();
        // 设置excel文档的属性
        $objPHPExcel->getProperties()->setCreator("WSTMart")//创建人
        ->setLastModifiedBy("WSTMart")//最后修改人
        ->setTitle($name)//标题
        ->setSubject($name)//题目
        ->setDescription($name)//描述
        ->setKeywords("销售额统计");//种类
        // 开始操作excel表
        $objPHPExcel->setActiveSheetIndex(0);
        // 设置工作薄名称
        $objPHPExcel->getActiveSheet()->setTitle(iconv('gbk', 'utf-8', 'Sheet'));
        // 设置默认字体和大小
        $objPHPExcel->getDefaultStyle()->getFont()->setName(iconv('gbk', 'utf-8', ''));
        $objPHPExcel->getDefaultStyle()->getFont()->setSize(11);
        $styleArray = array('font' => array('bold' => true,'color'=>array('argb' => 'ffffffff')));
        //设置宽
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(16);
        $objRow = $objPHPExcel->getActiveSheet()->getStyle('A1:F1');
        $objRow->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID);
        $objRow->getFill()->getStartColor()->setRGB('666699');
        $objRow->getAlignment()->setVertical(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objRow->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(25);
        $objPHPExcel->getActiveSheet()
        ->setCellValue('A1', '日期')
        ->setCellValue('B1', '待付款订单')
        ->setCellValue('C1', '取消订单')
        ->setCellValue('D1', '拒收订单')
        ->setCellValue('E1', '正常订单')
        ->setCellValue('F1', '总订单');
        $objPHPExcel->getActiveSheet()->getStyle('A1:F1')->applyFromArray($styleArray);
        $i = 1;
        $totalRow = 0;
        for ($row = 0; $row < count($rs['list']); $row++){
            $i = $row+2;
            $objPHPExcel->getActiveSheet()
            ->setCellValue('A'.$i, $rs['list'][$row]['day'])
            ->setCellValue('B'.$i, $rs['list'][$row]['of2'])
            ->setCellValue('C'.$i, $rs['list'][$row]['o1'])
            ->setCellValue('D'.$i, $rs['list'][$row]['o3'])
            ->setCellValue('E'.$i, $rs['list'][$row]['ou'])
            ->setCellValue('F'.$i, $rs['list'][$row]['of2']+$rs['list'][$row]['o1']+$rs['list'][$row]['o3']+$rs['list'][$row]['ou']);
            $totalRow++;
        }
        $totalRow = ($totalRow==0)?1:$totalRow+1;
        $objPHPExcel->getActiveSheet()->getStyle('A1:F'.$totalRow)->applyFromArray(array(
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
     * 加入购物车数统计
     */
    public function getStatCarts(){
        $shopId = (int)session('WST_USER.shopId');
        $startDate = input("startDate");
        $endDate = input("endDate");
        $goodsName = input("goodsName");
        $where = [];
        $where[] = ['g.dataFlag','=',1];
        $where[] = ['g.shopId','=',$shopId];
        if($startDate!= "")$where[] = ["c.createTime",">=",$startDate." 00:00:00"];
        if($endDate!= "")$where[] = ["c.createTime","<=",$endDate." 23:59:59"];
        if($goodsName!= "")$where[] = ["g.goodsName|g.goodsSn","like",$goodsName];

        $rs = Db::name("carts")->alias('c')
            ->join('goods g','c.goodsId=g.goodsId')
            ->where($where)
            ->field('left(c.createTime,10) createTime,count(c.cartId) cartNum')
            ->group('left(c.createTime,10)')
            ->order('c.createTime asc')
            ->select();
        $map = [];
        $days = [];
        $cartNums = [];
        foreach ($rs as $key => $v) {
            $days[] = $v['createTime'];
            $cartNums[] = $v['cartNum'];
        }
        $data = ['days'=>$days,'cartNums'=>$cartNums];
        return WSTReturn('',1,$data);

    }


    public function getStatCartGoods(){
        $shopId = (int)session('WST_USER.shopId');
        $startDate = input("startDate");
        $endDate = input("endDate");
        $goodsName = input("goodsName");
        $pagesize = input('limit/d');
        $where = [];
        $where[] = ['g.dataFlag','=',1];
        $where[] = ['g.shopId','=',$shopId];
        if($startDate!= "")$where[] = ["c.createTime",">=",$startDate." 00:00:00"];
        if($endDate!= "")$where[] = ["c.createTime","<=",$endDate." 23:59:59"];
        if($goodsName!= "")$where[] = ["g.goodsName|g.goodsSn","like",$goodsName];
        $rs = Db::name("carts")->alias('c')
            ->join("users u","c.userId=u.userId")
            ->join('__GOODS__ g','c.goodsId=g.goodsId','inner')
            ->join('__GOODS_SPECS__ gs','c.goodsSpecId=gs.id','left')
            ->where($where)
            ->field('c.userId,c.goodsSpecId,c.cartId,c.createTime,g.goodsId,g.goodsName,g.goodsSn,g.shopPrice,
            g.isSpec,gs.specPrice,g.goodsImg,gs.specIds,c.cartNum,c.createTime,u.loginName')
            ->order("cartId")
            ->paginate($pagesize)
            ->toArray();
        foreach ($rs['data'] as $key => $v){
            if($v['specIds']){
                $specIds[$key] = explode(':',$v['specIds']);
                $rss = Db::name('spec_items')->alias('si')
                    ->join('__SPEC_CATS__ sc','sc.catId=si.catId','left')
                    ->where('si.shopId = '.$shopId.' and si.goodsId = '.$v['goodsId'])
                    ->where([['si.itemId','in',$specIds[$key]]])
                    ->field('si.itemId,si.itemName,sc.catId,sc.catName')
                    ->select();
                $specNames = [];
                foreach ($rss as $key2 => $v2){
                    $specNames[] = $v2['itemName'];
                }
                $rs['data'][$key]['specNames'] = implode("，",$specNames);
            }
            $rs['data'][$key]['loginName'] =  WSTAnonymous($v['loginName']);
        }
        return $rs;
    }



    /**
     * 加入购物车数统计
     */
    public function getStatFavorites(){
        $shopId = (int)session('WST_USER.shopId');
        $startDate = input("startDate");
        $endDate = input("endDate");
        $goodsName = input("goodsName");
        $where = [];
        $where[] = ['g.dataFlag','=',1];
        $where[] = ['g.shopId','=',$shopId];
        if($startDate!= "")$where[] = ["f.createTime",">=",$startDate." 00:00:00"];
        if($endDate!= "")$where[] = ["f.createTime","<=",$endDate." 23:59:59"];
        if($goodsName!= "")$where[] = ["g.goodsName|g.goodsSn","like",$goodsName];

        $rs = Db::name("favorites")->alias('f')
            ->join('goods g','f.goodsId=g.goodsId')
            ->where($where)
            ->field('left(f.createTime,10) createTime,count(f.favoriteId) favoriteNum')
            ->group('left(f.createTime,10)')
            ->order('f.createTime asc')
            ->select();
        $map = [];
        $days = [];
        $favoriteNums = [];
        foreach ($rs as $key => $v) {
            $days[] = $v['createTime'];
            $favoriteNums[] = $v['favoriteNum'];
        }
        $data = ['days'=>$days,'favoriteNums'=>$favoriteNums];
        return WSTReturn('',1,$data);

    }


    public function getStatFavoriteGoods(){
        $shopId = (int)session('WST_USER.shopId');
        $startDate = input("startDate");
        $endDate = input("endDate");
        $goodsName = input("goodsName");
        $pagesize = input('limit/d');
        $where = [];
        $where[] = ['g.dataFlag','=',1];
        $where[] = ['g.shopId','=',$shopId];
        if($startDate!= "")$where[] = ["f.createTime",">=",$startDate." 00:00:00"];
        if($endDate!= "")$where[] = ["f.createTime","<=",$endDate." 23:59:59"];
        if($goodsName!= "")$where[] = ["g.goodsName|g.goodsSn","like",$goodsName];
        $rs = Db::name("favorites")->alias('f')
            ->join("users u","f.userId=u.userId")
            ->join('__GOODS__ g','f.goodsId=g.goodsId','inner')
            ->where($where)
            ->field('f.userId,f.favoriteId,g.goodsId,g.goodsName,g.goodsSn,g.shopPrice,g.goodsStock,
            g.isSpec,g.goodsImg,f.createTime,u.loginName')
            ->paginate($pagesize)->toArray();
        foreach ($rs['data'] as $key => $v){
            $rs['data'][$key]['loginName'] =  WSTAnonymous($v['loginName']);
        }
        return $rs;
    }

}
